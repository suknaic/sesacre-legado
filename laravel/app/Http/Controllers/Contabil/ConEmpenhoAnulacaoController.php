<?php

namespace App\Http\Controllers\Contabil;

use App\Http\Controllers\Controller;
use App\Models\ConEmpenhoAnulacao;
use App\Models\ConEmpenhoAnulacaoSituacao;
use App\Models\ConEmpenhoAnulacaoStatus;
use App\Models\FinPedido;
use App\Models\FinPedidoAnotacao;
use App\Models\FinQddValor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConEmpenhoAnulacaoController extends Controller
{
    public const SITUACAO_MAP = [
        1 => 'Cadastrado',
        2 => 'Deferido',
        3 => 'Indeferido',
        4 => 'Cancelado',
    ];

    public const STATUS_MAP = [
        1 => 'Aguardando Deferimento',
        2 => 'Finalizado',
    ];

    public function index(Request $request): Response
    {
        $query = ConEmpenhoAnulacao::with([
            'pedido.fornecedor.pessoa',
            'situacao',
            'status',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nr_empenho_anulacao', 'ilike', "%{$search}%");
        }

        if ($request->filled('id_empenho_anulacao_situacao')) {
            $query->where('id_empenho_anulacao_situacao', $request->id_empenho_anulacao_situacao);
        }

        if ($request->filled('id_empenho_anulacao_status')) {
            $query->where('id_empenho_anulacao_status', $request->id_empenho_anulacao_status);
        }

        $anulacoes = $query->orderBy('id_empenho_anulacao', 'desc')
            ->paginate(15)
            ->through(function ($a) {
                $a->situacao_label = self::SITUACAO_MAP[$a->id_empenho_anulacao_situacao] ?? 'Desconhecido';
                $a->status_label = self::STATUS_MAP[$a->id_empenho_anulacao_status] ?? 'Desconhecido';
                $a->vl_formatado = number_format((float) $a->vl_empenho_anulacao, 2, ',', '.');

                return $a;
            });

        return Inertia::render('Contabil/EmpenhoAnulacao/Index', [
            'anulacoes' => $anulacoes,
            'filters' => $request->only(['search', 'id_empenho_anulacao_situacao', 'id_empenho_anulacao_status']),
            'situacoes' => ConEmpenhoAnulacaoSituacao::orderBy('id_empenho_anulacao_situacao')->get(),
            'statusList' => ConEmpenhoAnulacaoStatus::orderBy('id_empenho_anulacao_status')->get(),
        ]);
    }

    public function create(): Response
    {
        $nextNumber = $this->getNextNumber();

        $pedidosComEmpenho = FinPedido::with(['empenhos', 'fornecedor.pessoa', 'programaTrabalho', 'fonte'])
            ->whereHas('empenhos', function ($q) {
                $q->where('sit_empenho', 1);
            })
            ->whereIn('st_pedido', [16, 17, 18, 19, 20, 21, 22, 23])
            ->orderBy('nr_pedido')
            ->get()
            ->map(function ($pedido) {
                $activeEmpenho = $pedido->empenhos->firstWhere('sit_empenho', 1);
                if (! $activeEmpenho) {
                    return null;
                }
                $totalLiquidado = $pedido->liquidacoes()
                    ->whereNotIn('id_liquidacao_situacao', [4])
                    ->sum('vl_liquidacao');
                $vlSaldo = (float) $activeEmpenho->vl_empenho - (float) $totalLiquidado;
                $pedido->vl_saldo_empenho = $vlSaldo;
                $pedido->id_empenho_ativo = $activeEmpenho->id_empenho;
                $pedido->nr_empenho_ativo = $activeEmpenho->nr_empenho;
                $pedido->label = 'Pedido '.$pedido->nr_pedido
                    .' | Empenho '.$activeEmpenho->nr_empenho
                    .' | Saldo: R$ '.number_format($vlSaldo, 2, ',', '.');

                return $pedido;
            })
            ->filter();

        return Inertia::render('Contabil/EmpenhoAnulacao/Create', [
            'nextNumber' => $nextNumber,
            'pedidos' => $pedidosComEmpenho->values(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'vl_empenho_anulacao' => 'required|numeric|min:0.01',
            'dt_empenho_anulacao' => 'required|date',
        ], [
            'id_pedido.required' => 'O pedido é obrigatório.',
            'vl_empenho_anulacao.required' => 'O valor da anulação é obrigatório.',
            'vl_empenho_anulacao.min' => 'O valor deve ser maior que zero.',
            'dt_empenho_anulacao.required' => 'A data da anulação é obrigatória.',
        ]);

        $pedido = FinPedido::with(['empenhos', 'fonte', 'programaTrabalho', 'despesaElemento'])->findOrFail($validated['id_pedido']);

        $activeEmpenho = $pedido->empenhos->firstWhere('sit_empenho', 1);
        if (! $activeEmpenho) {
            return back()->withErrors(['id_pedido' => 'O pedido selecionado não possui empenho ativo.']);
        }

        $totalLiquidado = $pedido->liquidacoes()
            ->whereNotIn('id_liquidacao_situacao', [4])
            ->sum('vl_liquidacao');

        $vlSaldoEmpenho = (float) $activeEmpenho->vl_empenho - (float) $totalLiquidado;

        if ((float) $validated['vl_empenho_anulacao'] > $vlSaldoEmpenho) {
            return back()->withErrors([
                'vl_empenho_anulacao' => 'Valor da anulação excede o saldo disponível do empenho. Saldo: R$ '.number_format($vlSaldoEmpenho, 2, ',', '.'),
            ]);
        }

        $nrAnulacao = $this->getNextNumber();

        $anulacao = ConEmpenhoAnulacao::create([
            'id_pedido' => $pedido->id_pedido,
            'nr_empenho_anulacao' => $nrAnulacao,
            'dt_empenho_anulacao' => $validated['dt_empenho_anulacao'],
            'dh_empenho_anulacao' => now(),
            'vl_empenho_anulacao' => $validated['vl_empenho_anulacao'],
            'vl_empenho_antigo' => $vlSaldoEmpenho,
            'id_empenho_anulacao_situacao' => 1,
            'id_empenho_anulacao_status' => 1,
            'id_pessoa' => auth()->id(),
            'id_lotacao' => $pedido->id_lotacao,
            'vl_empenho_saldo' => $vlSaldoEmpenho - (float) $validated['vl_empenho_anulacao'],
        ]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Anulação de empenho nº '.$nrAnulacao.' cadastrada no valor de R$ '.number_format((float) $validated['vl_empenho_anulacao'], 2, ',', '.').'.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.empenhos-anulacao.show', $anulacao->id_empenho_anulacao)
            ->with('success', 'Anulação de empenho cadastrada com sucesso.');
    }

    public function show(ConEmpenhoAnulacao $empenhoAnulacao): Response
    {
        $empenhoAnulacao->load([
            'pedido.fornecedor.pessoa',
            'pedido.programaTrabalho',
            'pedido.fonte',
            'situacao',
            'status',
        ]);

        $activeEmpenho = $empenhoAnulacao->pedido->empenhos->firstWhere('sit_empenho', 1);

        $empenhoAnulacao->situacao_label = self::SITUACAO_MAP[$empenhoAnulacao->id_empenho_anulacao_situacao] ?? 'Desconhecido';
        $empenhoAnulacao->status_label = self::STATUS_MAP[$empenhoAnulacao->id_empenho_anulacao_status] ?? 'Desconhecido';
        $empenhoAnulacao->vl_formatado = number_format((float) $empenhoAnulacao->vl_empenho_anulacao, 2, ',', '.');
        $empenhoAnulacao->vl_saldo_formatado = number_format((float) $empenhoAnulacao->vl_empenho_saldo, 2, ',', '.');
        $empenhoAnulacao->nr_empenho = $activeEmpenho->nr_empenho ?? '-';

        return Inertia::render('Contabil/EmpenhoAnulacao/Show', [
            'anulacao' => $empenhoAnulacao,
        ]);
    }

    public function assinar(Request $request, ConEmpenhoAnulacao $empenhoAnulacao): RedirectResponse
    {
        if ((int) $empenhoAnulacao->id_empenho_anulacao_situacao !== 1) {
            return back()->with('error', 'Esta anulação já foi processada.');
        }

        $validated = $request->validate([
            'deferido' => 'required|boolean',
            'ds_observacao' => 'nullable|string',
        ]);

        $novaSituacao = $validated['deferido'] ? 2 : 3;

        $empenhoAnulacao->update([
            'id_empenho_anulacao_situacao' => $novaSituacao,
            'id_empenho_anulacao_status' => 2,
        ]);

        $pedido = $empenhoAnulacao->pedido;

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Anulação nº '.$empenhoAnulacao->nr_empenho_anulacao.' '.($validated['deferido'] ? 'deferida' : 'indeferida').'.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        if ($validated['deferido']) {
            $qddValor = FinQddValor::where('id_fonte', $pedido->id_fonte)
                ->where('id_programa_trabalho', $pedido->id_programa_trabalho)
                ->where('id_despesa_elemento', $pedido->id_despesa_elemento)
                ->first();

            if ($qddValor) {
                $qddValor->update([
                    'vl_empenhado' => (float) $qddValor->vl_empenhado - (float) $empenhoAnulacao->vl_empenho_anulacao,
                ]);

                $vlAtual = (float) $qddValor->vl_qdd_inical
                    + (float) $qddValor->vl_qdd_suplementado
                    - (float) $qddValor->vl_qdd_reduzido;

                $qddValor->update([
                    'vl_saldo' => $vlAtual - (float) $qddValor->vl_empenhado - (float) $qddValor->vl_bloqueado,
                ]);
            }
        }

        return redirect()->route('contabil.empenhos-anulacao.show', $empenhoAnulacao->id_empenho_anulacao)
            ->with('success', 'Anulação '.($validated['deferido'] ? 'deferida' : 'indeferida').' com sucesso.');
    }

    public function cancelar(ConEmpenhoAnulacao $empenhoAnulacao): RedirectResponse
    {
        if ((int) $empenhoAnulacao->id_empenho_anulacao_situacao === 4) {
            return back()->with('error', 'Esta anulação já está cancelada.');
        }

        if (in_array((int) $empenhoAnulacao->id_empenho_anulacao_situacao, [2, 3])) {
            return back()->with('error', 'Não é possível cancelar uma anulação já processada.');
        }

        $empenhoAnulacao->update([
            'id_empenho_anulacao_situacao' => 4,
            'id_empenho_anulacao_status' => 2,
        ]);

        $pedido = $empenhoAnulacao->pedido;

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Anulação nº '.$empenhoAnulacao->nr_empenho_anulacao.' cancelada.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.empenhos-anulacao.index')
            ->with('success', 'Anulação cancelada com sucesso.');
    }

    private function getNextNumber(): string
    {
        $year = now()->year;
        $last = ConEmpenhoAnulacao::whereYear('dt_empenho_anulacao', $year)
            ->orderBy('nr_empenho_anulacao', 'desc')
            ->first();

        if ($last && $last->nr_empenho_anulacao) {
            $parts = explode('/', $last->nr_empenho_anulacao);
            $seq = ((int) ($parts[0] ?? 0)) + 1;
        } else {
            $seq = 1;
        }

        return str_pad((string) $seq, 4, '0', STR_PAD_LEFT).'/'.$year;
    }
}
