<?php

namespace App\Http\Controllers\Contabil;

use App\Http\Controllers\Controller;
use App\Models\ConEmpenho;
use App\Models\FinDespesa;
use App\Models\FinDespesaElemento;
use App\Models\FinEmpenhoStatus;
use App\Models\FinFonte;
use App\Models\FinFornecedor;
use App\Models\FinPedido;
use App\Models\FinPedidoAnotacao;
use App\Models\FinProgramaTrabalho;
use App\Models\FinQddValor;
use App\Models\FinTipoEmpenho;
use App\Models\PlaTipoGasto;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConEmpenhoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ConEmpenho::with(['pedido.tipoSolicitacao', 'pedido.fornecedor.pessoa', 'pedido.programaTrabalho', 'pedido.fonte', 'tipoEmpenho', 'empenhoStatus']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nr_empenho', 'ilike', "%{$search}%")
                    ->orWhere('ds_empenho', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('nr_empenho')) {
            $query->where('nr_empenho', 'ilike', "%{$request->nr_empenho}%");
        }

        if ($request->filled('id_tipo_empenho')) {
            $query->where('id_tipo_empenho', $request->id_tipo_empenho);
        }

        if ($request->filled('sit_empenho')) {
            $query->where('sit_empenho', $request->sit_empenho);
        }

        if ($request->filled('ano')) {
            $query->whereYear('dt_empenho_sistema', $request->ano);
        }

        $empenhos = $query->orderBy('id_empenho', 'desc')
            ->paginate(15)
            ->through(function ($empenho) {
                $empenho->vl_empenho_formatado = number_format((float) $empenho->vl_empenho, 2, ',', '.');

                return $empenho;
            });

        return Inertia::render('Contabil/Empenho/Index', [
            'empenhos' => $empenhos,
            'filters' => $request->only(['search', 'nr_empenho', 'id_tipo_empenho', 'sit_empenho', 'ano']),
            'tiposEmpenho' => FinTipoEmpenho::where('st_ativo', 1)->orderBy('nm_tipo_empenho')->get(),
            'statusEmpenho' => FinEmpenhoStatus::where('st_ativo', 1)->orderBy('nm_empenho_status')->get(),
        ]);
    }

    public function create(): Response
    {
        $nextNumber = $this->getNextNumber();

        $pedidosAguardando = FinPedido::with(['tipoSolicitacao', 'fornecedor.pessoa', 'programaTrabalho', 'fonte', 'despesaElemento', 'despesa'])
            ->where('st_pedido', 15)
            ->orderBy('nr_pedido')
            ->get()
            ->map(function ($p) {
                $p->label = $p->nr_pedido.' - '.($p->fornecedor->pessoa->nm_pessoa ?? 'Sem fornecedor').' | R$ '.number_format((float) $p->vl_pedido, 2, ',', '.');

                return $p;
            });

        return Inertia::render('Contabil/Empenho/Create', [
            'nextNumber' => $nextNumber,
            'pedidos' => $pedidosAguardando,
            'tiposEmpenho' => FinTipoEmpenho::where('st_ativo', 1)->orderBy('nm_tipo_empenho')->get(),
            'fontes' => FinFonte::where('st_fonte', 1)->orderBy('nr_fonte')->get(),
            'programasTrabalho' => FinProgramaTrabalho::where('st_ativo', 1)->orderBy('cd_programa_trabalho')->get(),
            'despesasElemento' => FinDespesaElemento::where('st_ativo', 1)->orderBy('cd_despesa_elemento')->get(),
            'despesas' => FinDespesa::where('st_ativo', 1)->orderBy('cd_despesa')->get(),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'id_tipo_empenho' => 'required|exists:fin_tipo_empenho,id_tipo_empenho',
            'dt_empenho_safira' => 'required|date',
            'vl_empenho' => 'required|numeric|min:0.01',
            'ds_empenho' => 'nullable|string',
        ], [
            'id_pedido.required' => 'O pedido é obrigatório.',
            'id_tipo_empenho.required' => 'O tipo de empenho é obrigatório.',
            'dt_empenho_safira.required' => 'A data do empenho no SAFIRA é obrigatória.',
            'vl_empenho.required' => 'O valor do empenho é obrigatório.',
            'vl_empenho.min' => 'O valor deve ser maior que zero.',
        ]);

        $pedido = FinPedido::with(['fonte', 'programaTrabalho', 'despesaElemento'])->findOrFail($validated['id_pedido']);

        if ($pedido->st_pedido !== 15) {
            return back()->withErrors(['id_pedido' => 'O pedido selecionado não está no status "Aguardando Empenho".']);
        }

        $nrEmpenho = $this->getNextNumber();

        $qddValor = FinQddValor::where('id_fonte', $pedido->id_fonte)
            ->where('id_programa_trabalho', $pedido->id_programa_trabalho)
            ->where('id_despesa_elemento', $pedido->id_despesa_elemento)
            ->first();

        if ($qddValor) {
            $saldoDisponivel = (float) $qddValor->vl_saldo - (float) $qddValor->vl_bloqueado;
            if ($saldoDisponivel < (float) $validated['vl_empenho']) {
                return back()->withErrors([
                    'vl_empenho' => 'Saldo orçamentário insuficiente. Saldo disponível: R$ '.number_format($saldoDisponivel, 2, ',', '.'),
                ]);
            }
        }

        $empenho = ConEmpenho::create([
            'id_pedido' => $validated['id_pedido'],
            'id_pessoa' => auth()->id(),
            'id_tipo_empenho' => $validated['id_tipo_empenho'],
            'nr_empenho' => $nrEmpenho,
            'dt_empenho_sistema' => now(),
            'dt_empenho_safira' => $validated['dt_empenho_safira'],
            'vl_empenho' => $validated['vl_empenho'],
            'ds_empenho' => $validated['ds_empenho'] ?? null,
            'sit_empenho' => 1,
            'id_lotacao' => $pedido->id_lotacao,
        ]);

        $pedido->update(['st_pedido' => 16]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Empenho nº '.$nrEmpenho.' criado. Status alterado para Aguardando Ordem.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        if ($qddValor) {
            $qddValor->update([
                'vl_empenhado' => (float) $qddValor->vl_empenhado + (float) $validated['vl_empenho'],
            ]);

            $vlAtual = (float) $qddValor->vl_qdd_inical
                + (float) $qddValor->vl_qdd_suplementado
                - (float) $qddValor->vl_qdd_reduzido;

            $qddValor->update([
                'vl_saldo' => $vlAtual - (float) $qddValor->vl_empenhado - (float) $qddValor->vl_bloqueado,
            ]);
        }

        return redirect()->route('contabil.empenhos.show', $empenho->id_empenho)
            ->with('success', 'Empenho nº '.$nrEmpenho.' criado com sucesso.');
    }

    public function show(ConEmpenho $empenho): Response
    {
        $empenho->load([
            'pedido.tipoSolicitacao',
            'pedido.fornecedor.pessoa',
            'pedido.programaTrabalho',
            'pedido.fonte',
            'pedido.despesaElemento',
            'pedido.despesa',
            'tipoEmpenho',
            'empenhoStatus',
            'pedido.liquidacoes',
        ]);

        $empenho->vl_empenho_formatado = number_format((float) $empenho->vl_empenho, 2, ',', '.');

        $totalLiquidado = $empenho->pedido->liquidacoes()
            ->whereNotIn('id_liquidacao_situacao', [4])
            ->sum('vl_liquidacao');

        $saldoDisponivel = (float) $empenho->vl_empenho - (float) $totalLiquidado;

        return Inertia::render('Contabil/Empenho/Show', [
            'empenho' => $empenho,
            'totalLiquidado' => number_format((float) $totalLiquidado, 2, ',', '.'),
            'saldoDisponivel' => number_format($saldoDisponivel, 2, ',', '.'),
        ]);
    }

    public function cancelar(ConEmpenho $empenho): RedirectResponse
    {
        if ((int) $empenho->sit_empenho !== 1) {
            return back()->with('error', 'Este empenho não pode ser cancelado.');
        }

        $pedido = $empenho->pedido;

        $empenho->update(['sit_empenho' => 0]);

        $pedido->update(['st_pedido' => 15]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Empenho nº '.$empenho->nr_empenho.' cancelado. Status retornado para Aguardando Empenho.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        $qddValor = FinQddValor::where('id_fonte', $pedido->id_fonte)
            ->where('id_programa_trabalho', $pedido->id_programa_trabalho)
            ->where('id_despesa_elemento', $pedido->id_despesa_elemento)
            ->first();

        if ($qddValor) {
            $qddValor->update([
                'vl_empenhado' => (float) $qddValor->vl_empenhado - (float) $empenho->vl_empenho,
            ]);

            $vlAtual = (float) $qddValor->vl_qdd_inical
                + (float) $qddValor->vl_qdd_suplementado
                - (float) $qddValor->vl_qdd_reduzido;

            $qddValor->update([
                'vl_saldo' => $vlAtual - (float) $qddValor->vl_empenhado - (float) $qddValor->vl_bloqueado,
            ]);
        }

        return redirect()->route('contabil.empenhos.index')
            ->with('success', 'Empenho cancelado com sucesso.');
    }

    private function getNextNumber(): string
    {
        $year = now()->year;
        $last = ConEmpenho::whereYear('dt_empenho_sistema', $year)
            ->orderBy('nr_empenho', 'desc')
            ->first();

        if ($last && $last->nr_empenho) {
            $parts = explode('/', $last->nr_empenho);
            $seq = ((int) ($parts[0] ?? 0)) + 1;
        } else {
            $seq = 1;
        }

        return str_pad((string) $seq, 4, '0', STR_PAD_LEFT).'/'.$year;
    }
}
