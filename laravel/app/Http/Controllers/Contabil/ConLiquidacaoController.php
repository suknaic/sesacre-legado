<?php

namespace App\Http\Controllers\Contabil;

use App\Http\Controllers\Controller;
use App\Models\ConEmpenho;
use App\Models\ConLiquidacao;
use App\Models\ConLiquidacaoSituacao;
use App\Models\ConLiquidacaoStatus;
use App\Models\FinDocumentoFiscal;
use App\Models\FinPedidoAnotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConLiquidacaoController extends Controller
{
    public const SITUACAO_MAP = [
        1 => 'Cadastrado',
        2 => 'Pago Parcial',
        3 => 'Pago',
        4 => 'Cancelado',
    ];

    public const SITUACAO_COLORS = [
        1 => 'bg-blue-100 text-blue-800',
        2 => 'bg-yellow-100 text-yellow-800',
        3 => 'bg-green-100 text-green-800',
        4 => 'bg-red-100 text-red-800',
    ];

    public const STATUS_MAP = [
        1 => 'Aguardando Pagamento',
        2 => 'Aguardando Finalizar Pagamento',
        3 => 'Finalizado',
    ];

    public function index(Request $request): Response
    {
        $query = ConLiquidacao::with([
            'empenho.pedido.fornecedor.pessoa',
            'situacao',
            'status',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nr_liquidacao', 'ilike', "%{$search}%");
        }

        if ($request->filled('id_liquidacao_situacao')) {
            $query->where('id_liquidacao_situacao', $request->id_liquidacao_situacao);
        }

        if ($request->filled('id_liquidacao_status')) {
            $query->where('id_liquidacao_status', $request->id_liquidacao_status);
        }

        $liquidacoes = $query->orderBy('id_liquidacao', 'desc')
            ->paginate(15)
            ->through(function ($l) {
                $l->situacao_label = self::SITUACAO_MAP[$l->id_liquidacao_situacao] ?? 'Desconhecido';
                $l->situacao_color = self::SITUACAO_COLORS[$l->id_liquidacao_situacao] ?? 'bg-gray-100 text-gray-800';
                $l->status_label = self::STATUS_MAP[$l->id_liquidacao_status] ?? 'Desconhecido';
                $l->vl_formatado = number_format((float) $l->vl_liquidacao, 2, ',', '.');

                return $l;
            });

        return Inertia::render('Contabil/Liquidacao/Index', [
            'liquidacoes' => $liquidacoes,
            'filters' => $request->only(['search', 'id_liquidacao_situacao', 'id_liquidacao_status']),
            'situacoes' => ConLiquidacaoSituacao::orderBy('id_liquidacao_situacao')->get(),
            'statusList' => ConLiquidacaoStatus::orderBy('id_liquidacao_status')->get(),
        ]);
    }

    public function create(): Response
    {
        $nextNumber = $this->getNextNumber();

        $empenhos = ConEmpenho::with(['pedido.fornecedor.pessoa', 'pedido.programaTrabalho', 'pedido.fonte'])
            ->where('sit_empenho', 1)
            ->orderBy('nr_empenho')
            ->get()
            ->map(function ($e) {
                $totalLiquidado = ConLiquidacao::where('id_empenho', $e->id_empenho)
                    ->whereNotIn('id_liquidacao_situacao', [4])
                    ->sum('vl_liquidacao');
                $e->vl_saldo = (float) $e->vl_empenho - (float) $totalLiquidado;
                $e->label = $e->nr_empenho
                    .' - '.($e->pedido->fornecedor->pessoa->nm_pessoa ?? 'N/D')
                    .' | Saldo: R$ '.number_format($e->vl_saldo, 2, ',', '.');

                return $e;
            })
            ->filter(fn ($e) => $e->vl_saldo > 0)
            ->values();

        $documentosFiscais = FinDocumentoFiscal::with(['tipoDocumento', 'documentoSituacao'])
            ->where('id_documento_situacao', 2)
            ->orderBy('nr_documento_fiscal')
            ->get()
            ->map(function ($d) {
                $d->label = ($d->tipoDocumento->nm_tipo_documento ?? 'Doc').' '.$d->nr_documento_fiscal
                    .' | R$ '.number_format((float) $d->vl_documento_fiscal, 2, ',', '.');

                return $d;
            });

        return Inertia::render('Contabil/Liquidacao/Create', [
            'nextNumber' => $nextNumber,
            'empenhos' => $empenhos,
            'documentosFiscais' => $documentosFiscais,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_empenho' => 'required|exists:fin_empenho,id_empenho',
            'vl_liquidacao' => 'required|numeric|min:0.01',
            'dt_liquidacao' => 'required|date',
            'ds_liquidacao' => 'nullable|string',
            'documentos' => 'nullable|array',
            'documentos.*.id_documento_fiscal' => 'required|exists:fin_documento_fiscal,id_documento_fiscal',
            'documentos.*.vl_liquidacao_doc' => 'required|numeric|min:0.01',
        ], [
            'id_empenho.required' => 'O empenho é obrigatório.',
            'vl_liquidacao.required' => 'O valor da liquidação é obrigatório.',
            'vl_liquidacao.min' => 'O valor deve ser maior que zero.',
            'dt_liquidacao.required' => 'A data é obrigatória.',
        ]);

        $empenho = ConEmpenho::with('pedido')->findOrFail($validated['id_empenho']);

        $totalLiquidado = ConLiquidacao::where('id_empenho', $empenho->id_empenho)
            ->whereNotIn('id_liquidacao_situacao', [4])
            ->sum('vl_liquidacao');

        $vlSaldoEmpenho = (float) $empenho->vl_empenho - (float) $totalLiquidado;

        if ((float) $validated['vl_liquidacao'] > $vlSaldoEmpenho) {
            return back()->withErrors([
                'vl_liquidacao' => 'Valor da liquidação excede o saldo do empenho. Saldo: R$ '.number_format($vlSaldoEmpenho, 2, ',', '.'),
            ]);
        }

        $totalDocs = collect($validated['documentos'] ?? [])->sum('vl_liquidacao_doc');
        if (abs((float) $totalDocs - (float) $validated['vl_liquidacao']) > 0.01) {
            return back()->withErrors([
                'documentos' => 'A soma dos valores dos documentos ('.number_format((float) $totalDocs, 2, ',', '.').') deve ser igual ao valor da liquidação ('.number_format((float) $validated['vl_liquidacao'], 2, ',', '.').').',
            ]);
        }

        $nrLiquidacao = $this->getNextNumber();

        $liquidacao = ConLiquidacao::create([
            'nr_liquidacao' => $nrLiquidacao,
            'id_empenho' => $validated['id_empenho'],
            'id_liquidacao_situacao' => 1,
            'id_liquidacao_status' => 1,
            'id_lotacao' => $empenho->pedido->id_lotacao,
            'dt_liquidacao' => $validated['dt_liquidacao'],
            'vl_liquidacao' => $validated['vl_liquidacao'],
            'vl_liquidacao_saldo' => $validated['vl_liquidacao'],
            'ds_liquidacao' => $validated['ds_liquidacao'] ?? null,
            'st_ativo' => 1,
        ]);

        if ($request->has('documentos')) {
            foreach ($validated['documentos'] as $doc) {
                $documentoFiscal = FinDocumentoFiscal::findOrFail($doc['id_documento_fiscal']);
                $documentoFiscal->update(['id_documento_situacao' => 3]);

                $liquidacao->documentos()->create([
                    'id_liquidacao' => $liquidacao->id_liquidacao,
                    'id_documento_fiscal' => $doc['id_documento_fiscal'],
                    'vl_liquidacao_doc' => $doc['vl_liquidacao_doc'],
                    'vl_liquidacao_doc_saldo' => $doc['vl_liquidacao_doc'],
                    'id_documento_situacao' => 3,
                ]);
            }
        }

        $pedido = $empenho->pedido;
        if ((int) $pedido->st_pedido === 21) {
            $pedido->update(['st_pedido' => 22]);
        } elseif ((int) $pedido->st_pedido < 21) {
            $pedido->update(['st_pedido' => 22]);
        }

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Liquidação nº '.$nrLiquidacao.' criada no valor de R$ '.number_format((float) $validated['vl_liquidacao'], 2, ',', '.').'.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.liquidacoes.show', $liquidacao->id_liquidacao)
            ->with('success', 'Liquidação nº '.$nrLiquidacao.' criada com sucesso.');
    }

    public function show(ConLiquidacao $liquidacao): Response
    {
        $liquidacao->load([
            'empenho.pedido.fornecedor.pessoa',
            'empenho.pedido.programaTrabalho',
            'empenho.pedido.fonte',
            'situacao',
            'status',
            'documentos.documentoFiscal.tipoDocumento',
            'pagamentos',
        ]);

        $liquidacao->situacao_label = self::SITUACAO_MAP[$liquidacao->id_liquidacao_situacao] ?? 'Desconhecido';
        $liquidacao->situacao_color = self::SITUACAO_COLORS[$liquidacao->id_liquidacao_situacao] ?? 'bg-gray-100 text-gray-800';
        $liquidacao->status_label = self::STATUS_MAP[$liquidacao->id_liquidacao_status] ?? 'Desconhecido';
        $liquidacao->vl_formatado = number_format((float) $liquidacao->vl_liquidacao, 2, ',', '.');
        $liquidacao->vl_saldo_formatado = number_format((float) $liquidacao->vl_liquidacao_saldo, 2, ',', '.');

        $totalPago = $liquidacao->pagamentos()
            ->where('id_pagamento_situacao', '!=', 2)
            ->sum('vl_pagamento');

        return Inertia::render('Contabil/Liquidacao/Show', [
            'liquidacao' => $liquidacao,
            'totalPago' => number_format((float) $totalPago, 2, ',', '.'),
        ]);
    }

    public function assinar(Request $request, ConLiquidacao $liquidacao): RedirectResponse
    {
        if ((int) $liquidacao->id_liquidacao_situacao !== 1) {
            return back()->with('error', 'Esta liquidação não está no status "Cadastrado".');
        }

        $totalPago = $liquidacao->pagamentos()
            ->where('id_pagamento_situacao', '!=', 2)
            ->sum('vl_pagamento');

        $vlRestante = (float) $liquidacao->vl_liquidacao - (float) $totalPago;

        if ($vlRestante <= 0.01) {
            $novaSituacao = 3;
        } else {
            $novaSituacao = 2;
        }

        $liquidacao->update([
            'id_liquidacao_situacao' => $novaSituacao,
            'id_liquidacao_status' => 2,
            'vl_liquidacao_saldo' => $vlRestante,
        ]);

        $pedido = $liquidacao->empenho->pedido;

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Liquidação nº '.$liquidacao->nr_liquidacao.' assinada. Situação: '.self::SITUACAO_MAP[$novaSituacao].'.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.liquidacoes.show', $liquidacao->id_liquidacao)
            ->with('success', 'Liquidação assinada com sucesso.');
    }

    public function finalizarPagamento(ConLiquidacao $liquidacao): RedirectResponse
    {
        if ((int) $liquidacao->id_liquidacao_status !== 2) {
            return back()->with('error', 'Esta liquidação não está aguardando finalização de pagamento.');
        }

        $liquidacao->update([
            'id_liquidacao_status' => 3,
        ]);

        return redirect()->route('contabil.liquidacoes.show', $liquidacao->id_liquidacao)
            ->with('success', 'Pagamento da liquidação finalizado com sucesso.');
    }

    public function cancelar(ConLiquidacao $liquidacao): RedirectResponse
    {
        if ((int) $liquidacao->id_liquidacao_situacao === 4) {
            return back()->with('error', 'Esta liquidação já está cancelada.');
        }

        if ((int) $liquidacao->id_liquidacao_situacao === 3) {
            return back()->with('error', 'Não é possível cancelar uma liquidação já paga.');
        }

        foreach ($liquidacao->documentos as $doc) {
            if ($doc->documentoFiscal) {
                $doc->documentoFiscal->update(['id_documento_situacao' => 2]);
            }
        }

        $liquidacao->update([
            'id_liquidacao_situacao' => 4,
            'id_liquidacao_status' => 3,
        ]);

        $pedido = $liquidacao->empenho->pedido;

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Liquidação nº '.$liquidacao->nr_liquidacao.' cancelada.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('contabil.liquidacoes.index')
            ->with('success', 'Liquidação cancelada com sucesso.');
    }

    private function getNextNumber(): string
    {
        $year = now()->year;
        $last = ConLiquidacao::whereYear('dt_liquidacao', $year)
            ->orderBy('nr_liquidacao', 'desc')
            ->first();

        if ($last && $last->nr_liquidacao) {
            $parts = explode('/', $last->nr_liquidacao);
            $seq = ((int) ($parts[0] ?? 0)) + 1;
        } else {
            $seq = 1;
        }

        return str_pad((string) $seq, 4, '0', STR_PAD_LEFT).'/'.$year;
    }
}
