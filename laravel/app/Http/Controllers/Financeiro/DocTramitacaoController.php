<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDocTramitacao;
use App\Models\FinDocumentoFiscal;
use App\Models\FinDocumentoSituacao;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocTramitacaoController extends Controller
{
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
        $query = FinDocTramitacao::with(['documentoFiscal', 'documentoSituacao']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('documentoFiscal', function ($q) use ($search) {
                $q->where('nr_documento_fiscal', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('id_tipo_tramitacao')) {
            $query->where('id_tipo_tramitacao', $request->id_tipo_tramitacao);
        }

        $tramitacoes = $query->orderBy('id_doc_tramitacao', 'desc')
            ->paginate(15)
            ->through(function ($t) {
                $t->tipo_label = self::TP_TRAMITACAO[$t->id_tipo_tramitacao] ?? 'Desconhecido';

                return $t;
            });

        return Inertia::render('Financeiro/DocTramitacao/Index', [
            'tramitacoes' => $tramitacoes,
            'filters' => $request->only(['search', 'id_tipo_tramitacao']),
            'tpTramitacao' => self::TP_TRAMITACAO,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/DocTramitacao/Create', [
            'documentos' => FinDocumentoFiscal::where('st_ativo', 1)
                ->orderBy('id_documento_fiscal', 'desc')
                ->get(['id_documento_fiscal', 'nr_documento_fiscal']),
            'situacoes' => FinDocumentoSituacao::orderBy('id_documento_situacao')->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'tpTramitacao' => self::TP_TRAMITACAO,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_documento_fiscal' => 'required|exists:fin_documento_fiscal,id_documento_fiscal',
            'id_doc_origem' => 'nullable|integer',
            'id_doc_destino' => 'nullable|integer',
            'id_tipo_tramitacao' => 'required|integer|in:1,2,3,4,5,6',
            'ds_doc_tramitacao' => 'nullable|string',
        ]);

        FinDocTramitacao::create([
            'id_documento_fiscal' => $validated['id_documento_fiscal'],
            'id_pessoa' => auth()->id(),
            'dh_doc_tramitacao' => now(),
            'id_doc_origem' => $validated['id_doc_origem'] ?? null,
            'id_doc_destino' => $validated['id_doc_destino'] ?? null,
            'id_documento_situacao' => 1,
            'id_tipo_tramitacao' => $validated['id_tipo_tramitacao'],
            'ds_doc_tramitacao' => $validated['ds_doc_tramitacao'] ?? null,
            'fl_pesquisa' => 1,
        ]);

        return redirect()->route('financeiro.doc-tramitacoes.index')
            ->with('success', 'Tramitação registrada com sucesso.');
    }

    public function show(FinDocTramitacao $docTramitacao): Response
    {
        $docTramitacao->load(['documentoFiscal.tipoDocumento', 'documentoSituacao']);
        $docTramitacao->tipo_label = self::TP_TRAMITACAO[$docTramitacao->id_tipo_tramitacao] ?? 'Desconhecido';

        return Inertia::render('Financeiro/DocTramitacao/Show', [
            'tramitacao' => $docTramitacao,
        ]);
    }

    public function destroy(FinDocTramitacao $docTramitacao): RedirectResponse
    {
        $docTramitacao->delete();

        return redirect()->route('financeiro.doc-tramitacoes.index')
            ->with('success', 'Tramitação removida com sucesso.');
    }
}
