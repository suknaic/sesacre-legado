<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinBlocoOrcamentario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlocoOrcamentarioController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinBlocoOrcamentario::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_bloc_orcamentario', 'ilike', "%{$search}%");
        }

        $blocos = $query->orderBy('nm_bloc_orcamentario')
            ->paginate(15);

        return Inertia::render('Orcamento/BlocoOrcamentario/Index', [
            'blocos' => $blocos,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Orcamento/BlocoOrcamentario/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_bloc_orcamentario' => 'required|string|max:255',
        ], [
            'nm_bloc_orcamentario.required' => 'O nome do bloco orçamentário é obrigatório.',
        ]);

        FinBlocoOrcamentario::create($validated);

        return redirect()->route('orcamento.blocos-orcamentarios.index')
            ->with('success', 'Bloco orçamentário criado com sucesso.');
    }

    public function show(FinBlocoOrcamentario $blocoOrcamentario): Response
    {
        $blocoOrcamentario->load('redesTematicas');

        return Inertia::render('Orcamento/BlocoOrcamentario/Show', [
            'blocoOrcamentario' => $blocoOrcamentario,
        ]);
    }

    public function edit(FinBlocoOrcamentario $blocoOrcamentario): Response
    {
        return Inertia::render('Orcamento/BlocoOrcamentario/Edit', [
            'blocoOrcamentario' => $blocoOrcamentario,
        ]);
    }

    public function update(Request $request, FinBlocoOrcamentario $blocoOrcamentario): RedirectResponse
    {
        $validated = $request->validate([
            'nm_bloc_orcamentario' => 'required|string|max:255',
        ]);

        $blocoOrcamentario->update($validated);

        return redirect()->route('orcamento.blocos-orcamentarios.index')
            ->with('success', 'Bloco orçamentário atualizado com sucesso.');
    }

    public function destroy(FinBlocoOrcamentario $blocoOrcamentario): RedirectResponse
    {
        $blocoOrcamentario->redesTematicas()->delete();
        $blocoOrcamentario->delete();

        return redirect()->route('orcamento.blocos-orcamentarios.index')
            ->with('success', 'Bloco orçamentário removido com sucesso.');
    }
}
