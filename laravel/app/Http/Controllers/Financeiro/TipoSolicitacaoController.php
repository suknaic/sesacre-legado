<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinTipoSolicitacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TipoSolicitacaoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinTipoSolicitacao::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_tipo_solicitacao', 'ilike', "%{$search}%");
        }

        $tipos = $query->orderBy('nm_tipo_solicitacao')
            ->paginate(15);

        return Inertia::render('Financeiro/TipoSolicitacao/Index', [
            'tipos' => $tipos,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/TipoSolicitacao/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_tipo_solicitacao' => 'required|string|max:255|unique:fin_tipo_solicitacao,nm_tipo_solicitacao',
        ], [
            'nm_tipo_solicitacao.required' => 'O nome do tipo de solicitação é obrigatório.',
            'nm_tipo_solicitacao.unique' => 'Este tipo de solicitação já existe.',
        ]);

        FinTipoSolicitacao::create($validated);

        return redirect()->route('financeiro.tipos-solicitacao.index')
            ->with('success', 'Tipo de solicitação criado com sucesso.');
    }

    public function show(int $id): Response
    {
        $tipo = FinTipoSolicitacao::withCount('pedidos')->findOrFail($id);

        return Inertia::render('Financeiro/TipoSolicitacao/Show', [
            'tipo' => $tipo,
        ]);
    }

    public function edit(int $id): Response
    {
        $tipo = FinTipoSolicitacao::findOrFail($id);

        return Inertia::render('Financeiro/TipoSolicitacao/Edit', [
            'tipo' => $tipo,
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $tipo = FinTipoSolicitacao::findOrFail($id);

        $validated = $request->validate([
            'nm_tipo_solicitacao' => 'required|string|max:255|unique:fin_tipo_solicitacao,nm_tipo_solicitacao,'.$id.',id_tipo_solicitacao',
        ]);

        $tipo->update($validated);

        return redirect()->route('financeiro.tipos-solicitacao.index')
            ->with('success', 'Tipo de solicitação atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $tipo = FinTipoSolicitacao::findOrFail($id);

        if ($tipo->pedidos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um tipo de solicitação que possui pedidos vinculados.');
        }

        $tipo->delete();

        return redirect()->route('financeiro.tipos-solicitacao.index')
            ->with('success', 'Tipo de solicitação removido com sucesso.');
    }
}
