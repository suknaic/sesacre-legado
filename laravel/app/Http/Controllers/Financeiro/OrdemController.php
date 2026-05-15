<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinFornecedor;
use App\Models\FinOrdem;
use App\Models\FinPedido;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrdemController extends Controller
{
    public const SITUACAO_MAP = [
        0 => 'Cancelado',
        1 => 'Cadastrado',
        2 => 'Requisitado',
        3 => 'Finalizado (Supressão Ordenador)',
        4 => 'Finalizado (Descumprimento Contratada)',
        5 => 'Finalizado',
        6 => 'Liquidado Parcial',
        7 => 'Liquidado Total',
        8 => 'Pago Parcial',
        9 => 'Pago Total',
    ];

    public const SITUACAO_COLORS = [
        0 => 'red',
        1 => 'yellow',
        2 => 'blue',
        3 => 'orange',
        4 => 'orange',
        5 => 'green',
        6 => 'purple',
        7 => 'purple',
        8 => 'indigo',
        9 => 'green',
    ];

    public const TIPO_ORDEM = [
        1 => 'Entrega',
        2 => 'Execução/Serviço',
    ];

    public function index(Request $request): Response
    {
        $query = FinOrdem::with(['pedido.tipoSolicitacao', 'pedido.fornecedor', 'itens']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nr_ordem', 'ilike', "%{$search}%")
                    ->orWhereHas('pedido', function ($q2) use ($search) {
                        $q2->where('nr_pedido', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('sit_ordem')) {
            $query->where('sit_ordem', $request->sit_ordem);
        }

        if ($request->filled('id_lotacao')) {
            $query->where('id_lotacao', $request->id_lotacao);
        }

        if ($request->filled('ano')) {
            $query->where('aa_ordem', $request->ano);
        }

        $ordens = $query->orderBy('id_ordem', 'desc')
            ->paginate(15)
            ->through(function ($ordem) {
                $ordem->status_label = self::SITUACAO_MAP[$ordem->sit_ordem] ?? 'Desconhecido';
                $ordem->status_color = self::SITUACAO_COLORS[$ordem->sit_ordem] ?? 'gray';
                $ordem->tipo_label = self::TIPO_ORDEM[$ordem->tp_ordem] ?? '-';
                $ordem->pode_cancelar = $ordem->sit_ordem === 1;
                $ordem->pode_requisitar = $ordem->sit_ordem === 1;
                $ordem->pode_finalizar = in_array($ordem->sit_ordem, [1, 2]);
                $ordem->vl_ordem = $ordem->itens->sum('vl_itens_pre');

                return $ordem;
            });

        return Inertia::render('Financeiro/Ordem/Index', [
            'ordens' => $ordens,
            'filters' => $request->only(['search', 'sit_ordem', 'id_lotacao', 'ano']),
            'situacaoList' => self::SITUACAO_MAP,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function create(): Response
    {
        $pedidos = FinPedido::with(['tipoSolicitacao', 'fornecedor', 'preOrdens'])
            ->where('st_pedido', 16)
            ->orderBy('id_pedido', 'desc')
            ->get()
            ->map(function ($p) {
                $p->vl_pre_ordens = $p->preOrdens->sum('vl_total');
                $p->label = "{$p->nr_pedido} - {$p->ds_pedido} (R$ ".number_format($p->vl_pedido, 2, ',', '.').')';

                return $p;
            });

        return Inertia::render('Financeiro/Ordem/Create', [
            'nextNumber' => $this->getNextNumber(),
            'pedidos' => $pedidos,
            'tiposOrdem' => self::TIPO_ORDEM,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'id_lotacao' => 'required|integer',
            'tp_ordem' => 'required|in:1,2',
            'nr_prazo_ordem' => 'nullable|integer|min:1',
            'dt_ini_ordem' => 'nullable|date',
            'dt_fim_ordem' => 'nullable|date|after_or_equal:dt_ini_ordem',
        ], [
            'id_pedido.required' => 'O pedido é obrigatório.',
            'id_lotacao.required' => 'A lotação é obrigatória.',
            'tp_ordem.required' => 'O tipo de ordem é obrigatório.',
        ]);

        $pedido = FinPedido::findOrFail($validated['id_pedido']);

        if ($pedido->st_pedido !== 16) {
            return back()->with('error', 'O pedido deve estar com status "Aguardando Ordem" (16).');
        }

        $nrOrdem = $this->getNextNumber();
        $ano = now()->year;

        $ordem = FinOrdem::create([
            'id_pedido' => $validated['id_pedido'],
            'id_lotacao' => $validated['id_lotacao'],
            'id_pessoa' => auth()->id(),
            'nr_ordem' => $nrOrdem,
            'dh_ordem' => now(),
            'aa_ordem' => $ano,
            'nr_prazo_ordem' => $validated['nr_prazo_ordem'] ?? 30,
            'tp_ordem' => $validated['tp_ordem'],
            'sit_ordem' => 1,
            'dt_ini_ordem' => $validated['dt_ini_ordem'] ?? null,
            'dt_fim_ordem' => $validated['dt_fim_ordem'] ?? null,
        ]);

        $pedido->update(['st_pedido' => 17]);

        return redirect()->route('financeiro.ordens.show', $ordem->id_ordem)
            ->with('success', "Ordem nº {$nrOrdem}/{$ano} criada com sucesso.");
    }

    public function show(FinOrdem $ordem): Response
    {
        $ordem->load(['pedido.tipoSolicitacao', 'pedido.fornecedor', 'pedido.programaTrabalho', 'pedido.fonte', 'itens']);

        $ordem->status_label = self::SITUACAO_MAP[$ordem->sit_ordem] ?? 'Desconhecido';
        $ordem->status_color = self::SITUACAO_COLORS[$ordem->sit_ordem] ?? 'gray';
        $ordem->tipo_label = self::TIPO_ORDEM[$ordem->tp_ordem] ?? '-';
        $ordem->pode_cancelar = $ordem->sit_ordem === 1;
        $ordem->pode_requisitar = $ordem->sit_ordem === 1;
        $ordem->pode_finalizar = in_array($ordem->sit_ordem, [1, 2]);
        $ordem->vl_ordem = $ordem->itens->sum('vl_itens_pre');

        $lotacao = SesLotacao::find($ordem->id_lotacao);

        return Inertia::render('Financeiro/Ordem/Show', [
            'ordem' => $ordem,
            'lotacao' => $lotacao,
            'situacaoList' => self::SITUACAO_MAP,
        ]);
    }

    public function edit(FinOrdem $ordem): Response
    {
        if ($ordem->sit_ordem !== 1) {
            return redirect()->route('financeiro.ordens.show', $ordem->id_ordem)
                ->with('error', 'Apenas ordens cadastradas podem ser editadas.');
        }

        $ordem->load(['pedido', 'itens']);

        return Inertia::render('Financeiro/Ordem/Edit', [
            'ordem' => $ordem,
            'tiposOrdem' => self::TIPO_ORDEM,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function update(Request $request, FinOrdem $ordem): RedirectResponse
    {
        if ($ordem->sit_ordem !== 1) {
            return back()->with('error', 'Apenas ordens cadastradas podem ser editadas.');
        }

        $validated = $request->validate([
            'id_lotacao' => 'required|integer',
            'tp_ordem' => 'required|in:1,2',
            'nr_prazo_ordem' => 'nullable|integer|min:1',
            'dt_ini_ordem' => 'nullable|date',
            'dt_fim_ordem' => 'nullable|date|after_or_equal:dt_ini_ordem',
        ]);

        $ordem->update($validated);

        return redirect()->route('financeiro.ordens.show', $ordem->id_ordem)
            ->with('success', 'Ordem atualizada com sucesso.');
    }

    public function destroy(FinOrdem $ordem): RedirectResponse
    {
        if ($ordem->sit_ordem !== 1) {
            return back()->with('error', 'Apenas ordens cadastradas podem ser canceladas.');
        }

        $pedido = $ordem->pedido;
        $ordem->itens()->delete();
        $ordem->delete();

        if ($pedido && $pedido->st_pedido === 17) {
            $pedido->update(['st_pedido' => 16]);
        }

        return redirect()->route('financeiro.ordens.index')
            ->with('success', 'Ordem cancelada com sucesso.');
    }

    public function requisitar(Request $request, FinOrdem $ordem): RedirectResponse
    {
        if ($ordem->sit_ordem !== 1) {
            return back()->with('error', 'Apenas ordens cadastradas podem ser requisitadas.');
        }

        $ordem->update([
            'sit_ordem' => 2,
            'dh_ordem' => now(),
        ]);

        return back()->with('success', 'Ordem requisitada com sucesso.');
    }

    public function finalizar(Request $request, FinOrdem $ordem): RedirectResponse
    {
        if (! in_array($ordem->sit_ordem, [1, 2])) {
            return back()->with('error', 'A ordem precisa estar cadastrada ou requisitada para ser finalizada.');
        }

        $validated = $request->validate([
            'tipo_finalizacao' => 'required|in:3,4,5',
        ]);

        $ordem->update([
            'sit_ordem' => $validated['tipo_finalizacao'],
        ]);

        return back()->with('success', 'Ordem finalizada com sucesso.');
    }

    public function cancelar(FinOrdem $ordem): RedirectResponse
    {
        if ($ordem->sit_ordem !== 1) {
            return back()->with('error', 'Apenas ordens cadastradas podem ser canceladas.');
        }

        $pedido = $ordem->pedido;
        $ordem->update(['sit_ordem' => 0]);

        if ($pedido && $pedido->st_pedido === 17) {
            $pedido->update(['st_pedido' => 16]);
        }

        return back()->with('success', 'Ordem cancelada com sucesso.');
    }

    private function getNextNumber(): int
    {
        $last = FinOrdem::where('aa_ordem', now()->year)
            ->orderBy('nr_ordem', 'desc')
            ->first();

        return $last ? ((int) $last->nr_ordem) + 1 : 1;
    }
}
