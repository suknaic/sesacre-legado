<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDocVincEncaminhamento;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocVincEncaminhamentoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinDocVincEncaminhamento::query();

        if ($request->filled('id_lotacao')) {
            $query->where('id_doc_lotacao', $request->id_lotacao);
        }

        $vincos = $query->orderBy('id_doc_vinc_encaminhamento', 'desc')
            ->paginate(15);

        return Inertia::render('Financeiro/DocVincEncaminhamento/Index', [
            'vincos' => $vincos,
            'filters' => $request->only(['id_lotacao']),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/DocVincEncaminhamento/Create', [
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_doc_lotacao' => 'required|integer',
            'id_pessoa' => 'required|integer|unique:fin_doc_vinc_encaminhamento,id_pessoa,NULL,id_doc_vinc_encaminhamento,id_doc_lotacao,'.$request->id_doc_lotacao,
        ], [
            'id_doc_lotacao.required' => 'A lotação é obrigatória.',
            'id_pessoa.required' => 'A pessoa é obrigatória.',
            'id_pessoa.unique' => 'Este vínculo de encaminhamento já existe.',
        ]);

        FinDocVincEncaminhamento::create($validated);

        return redirect()->route('financeiro.doc-vinc-encaminhamentos.index')
            ->with('success', 'Vínculo de encaminhamento cadastrado com sucesso.');
    }

    public function destroy(FinDocVincEncaminhamento $docVincEncaminhamento): RedirectResponse
    {
        $docVincEncaminhamento->delete();

        return redirect()->route('financeiro.doc-vinc-encaminhamentos.index')
            ->with('success', 'Vínculo de encaminhamento removido com sucesso.');
    }
}
