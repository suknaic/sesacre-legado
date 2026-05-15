<?php

namespace App\Http\Controllers\Contabil;

use App\Http\Controllers\Controller;
use App\Models\ConLiquidacao;
use App\Models\ConPagamento;
use App\Models\FinPedidoAnotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConPagamentoController extends Controller
{
    public const SITUACAO_MAP = [
        1 => 'Cadastrado',
        2 => 'Cancelado',
    ];

    public function index(Request $request): Response
    {
        $query = ConPagamento::with([
            'liquidacao.empenho.pedido.fornecedor.pessoa',
            'liquidacaoSituacao',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nr_pagamento', 'ilike', "%{$search}%");
        }

        if ($request->filled('id_pagamento_situacao')) {
            $query->where('id_pagamento_situacao', $request->id_pagamento_situacao);
        }

        if ($request->filled('id_liquidacao')) {
            $query->where('id_liquidacao', $request->id_liquidacao);
        }

        $pagamentos = $query->orderBy('id_pagamento', 'desc')
            ->paginate(15)
            ->through(function ($p) {
                $p->situacao_label = self::SITUACAO_MAP[$p->id_pagamento_situacao] ?? 'Desconhecido';
                $p->vl_formatado = number_format((float) $p->vl_pagamento, 2, ',', '.');

                return $p;
            });

        return Inertia::render('Contabil/Pagamento/Index', [
            'pagamentos' => $pagamentos,
            'filters' => $request->only(['search', 'id_pagamento_situacao', 'id_liquidacao']),
            'liquidacoes' => ConLiquidacao::whereIn('id_liquidacao_status', [1, 2])
                ->orderBy('nr_liquidacao')
                ->get(['id_liquidacao', 'nr_liquidacao']),
        ]);
    }

    public function create(): Response
    {
        $nextNumber = $this->getNextNumber();

        $liquidacoes = ConLiquidacao::with(['empenho.pedido.fornecedor.pessoa', 'empenho.pedido.programaTrabalho'])
            ->whereIn('id_liquidacao_situacao', [1, 2])
            ->where('st_ativo', 1)
            ->orderBy('nr_liquidacao')
            ->get()
            ->map(function ($l) {
                $totalPago = ConPagamento::where('id_liquidacao', $l->id_liquidacao)
                    ->where('id_pagamento_situacao', '!=', 2)
                    ->sum('vl_pagamento');
                $l->vl_saldo = (float) $l->vl_liquidacao - (float) $totalPago;
                $l->label = 'Liquidação '.$l->nr_liquidacao
                    .' | Saldo: R$ '.number_format($l->vl_saldo, 2, ',', '.')
                    .' | '.($l->empenho->pedido->fornecedor->pessoa->nm_pessoa ?? 'N/D');

                return $l;
            })
            ->filter(fn ($l) => $l->vl_saldo > 0)
            ->values();

        return Inertia::render('Contabil/Pagamento/Create', [
            'nextNumber' => $nextNumber,
            'liquidacoes' => $liquidacoes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_liquidacao' => 'required|exists:con_liquidacao,id_liquidacao',
            'vl_pagamento' => 'required|numeric|min:0.01',
            'dt_pagamento' => 'required|date',
            'ds_pagamento' => 'nullable|string',
        ], [
            'id_liquidacao.required' => 'A liquidação é obrigatória.',
            'vl_pagamento.required' => 'O valor do pagamento é obrigatório.',
            'vl_pagamento.min' => 'O valor deve ser maior que zero.',
            'dt_pagamento.required' => 'A data é obrigatória.',
        ]);

        $liquidacao = ConLiquidacao::with('empenho.pedido')->findOrFail($validated['id_liquidacao']);

        $totalPago = ConPagamento::where('id_liquidacao', $liquidacao->id_liquidacao)
            ->where('id_pagamento_situacao', '!=', 2)
            ->sum('vl_pagamento');

        $vlSaldoLiquidacao = (float) $liquidacao->vl_liquidacao - (float) $totalPago;

        if ((float) $validated['vl_pagamento'] > $vlSaldoLiquidacao) {
            return back()->withErrors([
                'vl_pagamento' => 'Valor do pagamento excede o saldo da liquidação. Saldo: R$ '.number_format($vlSaldoLiquidacao, 2, ',', '.'),
            ]);
        }

        $nrPagamento = $this->getNextNumber();
        $novoSaldo = $vlSaldoLiquidacao - (float) $validated['vl_pagamento'];

        $pagamento = ConPagamento::create([
            'id_pagamento_situacao' => 1,
            'id_liquidacao' => $validated['id_liquidacao'],
            'id_liquidacao_situacao' => $liquidacao->id_liquidacao_situacao,
            'id_lotacao' => $liquidacao->empenho->pedido->id_lotacao,
            'nr_pagamento' => $nrPagamento,
            'dt_pagamento' => $validated['dt_pagamento'],
            'vl_pagamento' => $validated['vl_pagamento'],
            'vl_pagamento_saldo' => $novoSaldo,
            'ds_pagamento' => $validated['ds_pagamento'] ?? null,
            'st_ativo' => 1,
        ]);

        $liquidacao->update([
            'vl_liquidacao_saldo' => $novoSaldo,
        ]);

        if ($novoSaldo <= 0.01) {
            $liquidacao->update([
                'id_liquidacao_situacao' => 3,
                'id_liquidacao_status' => 3,
            ]);

            $pedido = $liquidacao->empenho->pedido;
            $pedido->update(['st_pedido' => 23]);

            FinPedidoAnotacao::create([
                'id_pedido' => $pedido->id_pedido,
                'ds_pedido_anotacao' => 'Pagamento completo. Pedido finalizado.',
                'dh_pedido_anotacao' => now(),
                'id_pessoa' => auth()->id(),
            ]);
        } else {
            $liquidacao->update([
                'id_liquidacao_situacao' => 2,
                'id_liquidacao_status' => 2,
            ]);
        }

        $pedido = $liquidacao->empenho->pedido;
        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Pagamento nº '.$nrPagamento.' registrado no valor de R$ '.number_format((float) $validated['vl_pagamento'], 2, ',', '.').'.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.pagamentos.show', $pagamento->id_pagamento)
            ->with('success', 'Pagamento nº '.$nrPagamento.' registrado com sucesso.');
    }

    public function show(ConPagamento $pagamento): Response
    {
        $pagamento->load([
            'liquidacao.empenho.pedido.fornecedor.pessoa',
            'liquidacao.empenho.pedido.programaTrabalho',
            'liquidacao.empenho.pedido.fonte',
            'liquidacaoSituacao',
        ]);

        $pagamento->situacao_label = self::SITUACAO_MAP[$pagamento->id_pagamento_situacao] ?? 'Desconhecido';
        $pagamento->vl_formatado = number_format((float) $pagamento->vl_pagamento, 2, ',', '.');
        $pagamento->vl_saldo_formatado = number_format((float) $pagamento->vl_pagamento_saldo, 2, ',', '.');

        return Inertia::render('Contabil/Pagamento/Show', [
            'pagamento' => $pagamento,
        ]);
    }

    public function cancelar(ConPagamento $pagamento): RedirectResponse
    {
        if ((int) $pagamento->id_pagamento_situacao === 2) {
            return back()->with('error', 'Este pagamento já está cancelado.');
        }

        $liquidacao = $pagamento->liquidacao;

        $pagamento->update(['id_pagamento_situacao' => 2]);

        $saldoLiquidacao = (float) $liquidacao->vl_liquidacao_saldo + (float) $pagamento->vl_pagamento;
        $liquidacao->update([
            'vl_liquidacao_saldo' => $saldoLiquidacao,
        ]);

        if ((float) $saldoLiquidacao > 0) {
            $liquidacao->update(['id_liquidacao_situacao' => 2]);
        }

        if ((float) $liquidacao->vl_liquidacao_saldo < (float) $liquidacao->vl_liquidacao) {
            $liquidacao->update(['id_liquidacao_status' => 2]);
        }

        if ((float) $saldoLiquidacao >= (float) $liquidacao->vl_liquidacao) {
            $liquidacao->update([
                'id_liquidacao_situacao' => 1,
                'id_liquidacao_status' => 1,
            ]);
        }

        $pedido = $liquidacao->empenho->pedido;
        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Pagamento nº '.$pagamento->nr_pagamento.' cancelado.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.pagamentos.index')
            ->with('success', 'Pagamento cancelado com sucesso.');
    }

    private function getNextNumber(): string
    {
        $year = now()->year;
        $last = ConPagamento::whereYear('dt_pagamento', $year)
            ->orderBy('nr_pagamento', 'desc')
            ->first();

        if ($last && $last->nr_pagamento) {
            $parts = explode('/', $last->nr_pagamento);
            $seq = ((int) ($parts[0] ?? 0)) + 1;
        } else {
            $seq = 1;
        }

        return str_pad((string) $seq, 4, '0', STR_PAD_LEFT).'/'.$year;
    }
}
