<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDocVincRecebimento;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DocVincRecebimentoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinDocVincRecebimento::query();

        if ($request->filled('id_lotacao')) {
            $query->where('id_doc_lotacao', $request->id_lotacao);
        }

        $vincos = $query->orderBy('id_doc_vinc_recebimento', 'desc')
            ->paginate(15);

        return Inertia::render('Financeiro/DocVincRecebimento/Index', [
            'vincos' => $vincos,
            'filters' => $request->only(['id_lotacao']),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/DocVincRecebimento/Create', [
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_doc_lotacao' => 'required|integer',
            'id_pessoa' => 'required|integer|unique:fin_doc_vinc_recebimento,id_pessoa,NULL,id_doc_vinc_recebimento,id_doc_lotacao,'.$request->id_doc_lotacao,
        ], [
            'id_doc_lotacao.required' => 'A lotação é obrigatória.',
            'id_pessoa.required' => 'A pessoa é obrigatória.',
            'id_pessoa.unique' => 'Este vínculo de recebimento já existe.',
        ]);

        FinDocVincRecebimento::create($validated);

        return redirect()->route('financeiro.doc-vinc-recebimentos.index')
            ->with('success', 'Vínculo de recebimento cadastrado com sucesso.');
    }

    public function destroy(FinDocVincRecebimento $docVincRecebimento): RedirectResponse
    {
        $docVincRecebimento->delete();

        return redirect()->route('financeiro.doc-vinc-recebimentos.index')
            ->with('success', 'Vínculo de recebimento removido com sucesso.');
    }
}
