<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDocTramitacao;
use App\Models\FinDocumentoFiscal;
use App\Models\FinFornecedor;
use App\Models\FinPedido;
use App\Models\FinTipoDocumento;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocumentoFiscalController extends Controller
{
    public const SITUACAO_MAP = [
        1 => 'Cadastrado',
        2 => 'A Liquidar',
        3 => 'Liquidado',
        4 => 'A Pagar',
        5 => 'Pago Parcial',
        6 => 'Pago',
        7 => 'Cancelado',
    ];

    public const SITUACAO_COLORS = [
        1 => 'yellow',
        2 => 'blue',
        3 => 'purple',
        4 => 'indigo',
        5 => 'orange',
        6 => 'green',
        7 => 'red',
    ];

    public const TP_TRAMITACAO = [
        1 => 'Aguardando Tramitação',
        2 => 'Aguardando Encaminhamento',
        3 => 'Encaminhado',
        4 => 'Aguardando Recebimento',
        5 => 'Recebido',
        6 => 'Tramitação Finalizada',
    ];

    public function index(Request $request): Response
    {
        $query = FinDocumentoFiscal::with([
            'tipoDocumento', 'documentoSituacao', 'pedido',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nr_documento_fiscal', 'ilike', "%{$search}%")
                    ->orWhere('nr_processo_administrativo', 'ilike', "%{$search}%")
                    ->orWhereHas('pedido', function ($q2) use ($search) {
                        $q2->where('nr_pedido', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('id_documento_situacao')) {
            $query->where('id_documento_situacao', $request->id_documento_situacao);
        }

        if ($request->filled('id_tipo_documento')) {
            $query->where('id_tipo_documento', $request->id_tipo_documento);
        }

        if ($request->filled('id_lotacao')) {
            $query->where('id_lotacao', $request->id_lotacao);
        }

        $documentos = $query->orderBy('id_documento_fiscal', 'desc')
            ->paginate(15)
            ->through(function ($doc) {
                $doc->situacao_label = self::SITUACAO_MAP[$doc->id_documento_situacao] ?? 'Desconhecido';
                $doc->situacao_color = self::SITUACAO_COLORS[$doc->id_documento_situacao] ?? 'gray';

                return $doc;
            });

        return Inertia::render('Financeiro/DocumentoFiscal/Index', [
            'documentos' => $documentos,
            'filters' => $request->only(['search', 'id_documento_situacao', 'id_tipo_documento', 'id_lotacao']),
            'situacaoList' => self::SITUACAO_MAP,
            'tipoDocumentoList' => FinTipoDocumento::orderBy('nm_tipo_documento')->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function create(): Response
    {
        $pedidos = FinPedido::with(['fornecedor'])
            ->whereIn('st_pedido', [16, 17, 18, 19, 20, 21, 22])
            ->orderBy('id_pedido', 'desc')
            ->get()
            ->map(function ($p) {
                $p->label = "{$p->nr_pedido} - ".($p->fornecedor?->pessoa?->nm_pessoa ?? 'N/I');

                return $p;
            });

        return Inertia::render('Financeiro/DocumentoFiscal/Create', [
            'pedidos' => $pedidos,
            'tiposDocumento' => FinTipoDocumento::orderBy('nm_tipo_documento')->get(),
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
            'id_tipo_documento' => 'required|exists:fin_tipo_documento,id_tipo_documento',
            'id_lotacao' => 'required|integer',
            'nr_processo_administrativo' => 'required|string|max:100',
            'nr_documento_fiscal' => 'required|string|max:100',
            'dt_emissao' => 'required|date',
            'dt_vencimento' => 'nullable|date|after_or_equal:dt_emissao',
            'dt_atesto' => 'required|date',
            'vl_documento' => 'required|numeric|min:0.01',
            'competencia' => 'required|string|max:7',
            'fl_grp' => 'nullable|boolean',
            'nr_grp_numero' => 'nullable|string|max:50',
            'fl_encontro_contas' => 'nullable|boolean',
            'nr_encontro_dae' => 'nullable|string|max:50',
            'ds_observacao' => 'nullable|string',
        ], [
            'id_pedido.required' => 'O pedido é obrigatório.',
            'id_tipo_documento.required' => 'O tipo de documento é obrigatório.',
            'id_lotacao.required' => 'A lotação é obrigatória.',
            'nr_processo_administrativo.required' => 'O processo administrativo é obrigatório.',
            'nr_documento_fiscal.required' => 'O número do documento fiscal é obrigatório.',
            'dt_emissao.required' => 'A data de emissão é obrigatória.',
            'dt_atesto.required' => 'A data de atesto é obrigatória.',
            'vl_documento.required' => 'O valor é obrigatório.',
            'vl_documento.min' => 'O valor deve ser maior que zero.',
            'competencia.required' => 'A competência é obrigatória.',
        ]);

        $pedido = FinPedido::findOrFail($validated['id_pedido']);

        $competencia = explode('/', $validated['competencia']);
        $mmCompetencia = (int) ($competencia[0] ?? now()->month);
        $aaCompetencia = (int) ($competencia[1] ?? now()->year);

        $documento = FinDocumentoFiscal::create([
            'id_pedido' => $validated['id_pedido'],
            'id_tipo_documento' => $validated['id_tipo_documento'],
            'id_lotacao' => $validated['id_lotacao'],
            'id_pessoa' => auth()->id(),
            'id_documento_situacao' => 1,
            'nr_processo_administrativo' => $validated['nr_processo_administrativo'],
            'nr_documento_fiscal' => $validated['nr_documento_fiscal'],
            'mm_competencia' => $mmCompetencia,
            'aa_competencia' => $aaCompetencia,
            'dt_emissao' => $validated['dt_emissao'],
            'dt_vencimento' => $validated['dt_vencimento'] ?? null,
            'dt_atesto' => $validated['dt_atesto'],
            'vl_documento' => $validated['vl_documento'],
            'vl_documento_saldo' => $validated['vl_documento'],
            'fl_grp' => $validated['fl_grp'] ?? false,
            'nr_grp_numero' => $validated['nr_grp_numero'] ?? null,
            'fl_encontro_contas' => $validated['fl_encontro_contas'] ?? false,
            'nr_encontro_dae' => $validated['nr_encontro_dae'] ?? null,
            'ds_observacao' => $validated['ds_observacao'] ?? null,
            'st_ativo' => 1,
        ]);

        $tramitacao = FinDocTramitacao::create([
            'id_documento_fiscal' => $documento->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 1,
            'id_tipo_tramitacao' => 1,
            'ds_doc_tramitacao' => 'Documento cadastrado, aguardando tramitação.',
            'fl_pesquisa' => 1,
        ]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documento->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 1,
            'id_tipo_tramitacao' => 2,
            'ds_doc_tramitacao' => 'Aguardando encaminhamento.',
            'fl_pesquisa' => 0,
        ]);

        $documento->update(['id_doc_tramitacao' => $tramitacao->id_doc_tramitacao]);

        return redirect()->route('financeiro.documentos-fiscais.show', $documento->id_documento_fiscal)
            ->with('success', 'Documento fiscal cadastrado com sucesso.');
    }

    public function show(FinDocumentoFiscal $documentoFiscal): Response
    {
        $documentoFiscal->load([
            'tipoDocumento', 'documentoSituacao', 'pedido.fornecedor',
            'pedido.programaTrabalho', 'pedido.fonte',
        ]);

        $documentoFiscal->situacao_label = self::SITUACAO_MAP[$documentoFiscal->id_documento_situacao] ?? 'Desconhecido';
        $documentoFiscal->situacao_color = self::SITUACAO_COLORS[$documentoFiscal->id_documento_situacao] ?? 'gray';

        $tramitacoes = FinDocTramitacao::where('id_documento_fiscal', $documentoFiscal->id_documento_fiscal)
            ->orderBy('id_doc_tramitacao', 'desc')
            ->get()
            ->map(function ($t) {
                $t->tipo_label = self::TP_TRAMITACAO[$t->id_tipo_tramitacao] ?? '-';

                return $t;
            });

        return Inertia::render('Financeiro/DocumentoFiscal/Show', [
            'documento' => $documentoFiscal,
            'tramitacoes' => $tramitacoes,
            'situacaoList' => self::SITUACAO_MAP,
            'tpTramitacao' => self::TP_TRAMITACAO,
        ]);
    }

    public function edit(FinDocumentoFiscal $documentoFiscal): Response
    {
        if ($documentoFiscal->id_documento_situacao !== 1) {
            return redirect()->route('financeiro.documentos-fiscais.show', $documentoFiscal->id_documento_fiscal)
                ->with('error', 'Apenas documentos cadastrados podem ser editados.');
        }

        $documentoFiscal->load(['tipoDocumento', 'pedido']);

        return Inertia::render('Financeiro/DocumentoFiscal/Edit', [
            'documento' => $documentoFiscal,
            'tiposDocumento' => FinTipoDocumento::orderBy('nm_tipo_documento')->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function update(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if ($documentoFiscal->id_documento_situacao !== 1) {
            return back()->with('error', 'Apenas documentos cadastrados podem ser editados.');
        }

        $validated = $request->validate([
            'id_tipo_documento' => 'required|exists:fin_tipo_documento,id_tipo_documento',
            'id_lotacao' => 'required|integer',
            'nr_processo_administrativo' => 'required|string|max:100',
            'nr_documento_fiscal' => 'required|string|max:100',
            'dt_emissao' => 'required|date',
            'dt_vencimento' => 'nullable|date|after_or_equal:dt_emissao',
            'dt_atesto' => 'required|date',
            'vl_documento' => 'required|numeric|min:0.01',
            'competencia' => 'required|string|max:7',
            'fl_grp' => 'nullable|boolean',
            'nr_grp_numero' => 'nullable|string|max:50',
            'ds_observacao' => 'nullable|string',
        ]);

        $competencia = explode('/', $validated['competencia']);

        $documentoFiscal->update([
            'id_tipo_documento' => $validated['id_tipo_documento'],
            'id_lotacao' => $validated['id_lotacao'],
            'nr_processo_administrativo' => $validated['nr_processo_administrativo'],
            'nr_documento_fiscal' => $validated['nr_documento_fiscal'],
            'mm_competencia' => (int) ($competencia[0] ?? $documentoFiscal->mm_competencia),
            'aa_competencia' => (int) ($competencia[1] ?? $documentoFiscal->aa_competencia),
            'dt_emissao' => $validated['dt_emissao'],
            'dt_vencimento' => $validated['dt_vencimento'] ?? null,
            'dt_atesto' => $validated['dt_atesto'],
            'vl_documento' => $validated['vl_documento'],
            'vl_documento_saldo' => $validated['vl_documento'],
            'fl_grp' => $validated['fl_grp'] ?? false,
            'nr_grp_numero' => $validated['nr_grp_numero'] ?? null,
            'ds_observacao' => $validated['ds_observacao'] ?? null,
        ]);

        return redirect()->route('financeiro.documentos-fiscais.show', $documentoFiscal->id_documento_fiscal)
            ->with('success', 'Documento fiscal atualizado com sucesso.');
    }

    public function destroy(FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if ($documentoFiscal->id_documento_situacao !== 1) {
            return back()->with('error', 'Apenas documentos cadastrados podem ser cancelados.');
        }

        $documentoFiscal->update(['id_documento_situacao' => 7, 'st_ativo' => 0]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 7,
            'id_tipo_tramitacao' => 6,
            'ds_doc_tramitacao' => 'Documento cancelado.',
            'fl_pesquisa' => 0,
        ]);

        return redirect()->route('financeiro.documentos-fiscais.index')
            ->with('success', 'Documento fiscal cancelado com sucesso.');
    }

    public function encaminhar(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if (! in_array($documentoFiscal->id_documento_situacao, [1, 2])) {
            return back()->with('error', 'Documento precisa estar cadastrado ou "A Liquidar" para ser encaminhado.');
        }

        $validated = $request->validate([
            'id_doc_destino' => 'required|integer',
            'ds_doc_tramitacao' => 'nullable|string',
        ]);

        $tramitacao = FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_doc_origem' => $documentoFiscal->id_lotacao,
            'id_doc_destino' => $validated['id_doc_destino'],
            'id_documento_situacao' => $documentoFiscal->id_documento_situacao,
            'id_tipo_tramitacao' => 3,
            'ds_doc_tramitacao' => $validated['ds_doc_tramitacao'] ?? 'Documento encaminhado.',
            'fl_pesquisa' => 1,
        ]);

        $documentoFiscal->update(['id_doc_tramitacao' => $tramitacao->id_doc_tramitacao]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_doc_origem' => $documentoFiscal->id_lotacao,
            'id_doc_destino' => $validated['id_doc_destino'],
            'id_documento_situacao' => $documentoFiscal->id_documento_situacao,
            'id_tipo_tramitacao' => 4,
            'ds_doc_tramitacao' => 'Aguardando recebimento.',
            'fl_pesquisa' => 0,
        ]);

        return back()->with('success', 'Documento encaminhado com sucesso.');
    }

    public function receber(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if ($documentoFiscal->id_documento_situacao !== 1 && $documentoFiscal->id_documento_situacao !== 2) {
            return back()->with('error', 'Situação inválida para recebimento.');
        }

        $validated = $request->validate([
            'ds_doc_tramitacao' => 'nullable|string',
        ]);

        $tramitacao = FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => $documentoFiscal->id_documento_situacao,
            'id_tipo_tramitacao' => 5,
            'ds_doc_tramitacao' => $validated['ds_doc_tramitacao'] ?? 'Documento recebido.',
            'fl_pesquisa' => 1,
        ]);

        $documentoFiscal->update(['id_doc_tramitacao' => $tramitacao->id_doc_tramitacao]);

        if ($documentoFiscal->id_documento_situacao === 1) {
            $documentoFiscal->update(['id_documento_situacao' => 2]);
        }

        return back()->with('success', 'Documento recebido com sucesso.');
    }

    public function liquidar(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if ($documentoFiscal->id_documento_situacao !== 2) {
            return back()->with('error', 'Documento precisa estar "A Liquidar" para ser liquidado.');
        }

        $documentoFiscal->update(['id_documento_situacao' => 3]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 3,
            'id_tipo_tramitacao' => 6,
            'ds_doc_tramitacao' => 'Documento liquidado.',
            'fl_pesquisa' => 1,
        ]);

        return back()->with('success', 'Documento liquidado com sucesso.');
    }

    public function pagar(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if (! in_array($documentoFiscal->id_documento_situacao, [3, 4, 5])) {
            return back()->with('error', 'Documento precisa estar liquidado, "A Pagar" ou "Pago Parcial".');
        }

        $documentoFiscal->update(['id_documento_situacao' => 6]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 6,
            'id_tipo_tramitacao' => 6,
            'ds_doc_tramitacao' => 'Documento pago.',
            'fl_pesquisa' => 1,
        ]);

        return back()->with('success', 'Pagamento registrado com sucesso.');
    }

    public function cancelarAction(Request $request, FinDocumentoFiscal $documentoFiscal): RedirectResponse
    {
        if ($documentoFiscal->id_documento_situacao !== 1) {
            return back()->with('error', 'Apenas documentos cadastrados podem ser cancelados.');
        }

        $validated = $request->validate([
            'ds_observacao' => 'required|string',
        ]);

        $documentoFiscal->update([
            'id_documento_situacao' => 7,
            'st_ativo' => 0,
            'ds_observacao' => $validated['ds_observacao'],
        ]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $documentoFiscal->id_documento_fiscal,
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_documento_situacao' => 7,
            'id_tipo_tramitacao' => 6,
            'ds_doc_tramitacao' => $validated['ds_observacao'],
            'fl_pesquisa' => 1,
        ]);

        return back()->with('success', 'Documento fiscal cancelado com sucesso.');
    }
}
