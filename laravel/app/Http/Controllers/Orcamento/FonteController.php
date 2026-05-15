<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinFonte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FonteController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinFonte::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nr_fonte', 'ilike', "%{$search}%");
        }

        $fontes = $query->orderBy('nr_fonte')
            ->paginate(15);

        return Inertia::render('Orcamento/Fonte/Index', [
            'fontes' => $fontes,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Orcamento/Fonte/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nr_fonte' => 'required|string|max:255|unique:fin_fonte,nr_fonte',
            'st_fonte' => 'nullable|boolean',
        ], [
            'nr_fonte.required' => 'O número da fonte é obrigatório.',
            'nr_fonte.unique' => 'Esta fonte já está cadastrada.',
        ]);

        FinFonte::create($validated);

        return redirect()->route('orcamento.fontes.index')
            ->with('success', 'Fonte criada com sucesso.');
    }

    public function show(FinFonte $fonte): Response
    {
        return Inertia::render('Orcamento/Fonte/Show', [
            'fonte' => $fonte,
        ]);
    }

    public function edit(FinFonte $fonte): Response
    {
        return Inertia::render('Orcamento/Fonte/Edit', [
            'fonte' => $fonte,
        ]);
    }

    public function update(Request $request, FinFonte $fonte): RedirectResponse
    {
        $validated = $request->validate([
            'nr_fonte' => 'required|string|max:255|unique:fin_fonte,nr_fonte,'.$fonte->id_fonte.',id_fonte',
            'st_fonte' => 'nullable|boolean',
        ]);

        $fonte->update($validated);

        return redirect()->route('orcamento.fontes.index')
            ->with('success', 'Fonte atualizada com sucesso.');
    }

    public function destroy(FinFonte $fonte): RedirectResponse
    {
        $fonte->update(['st_fonte' => 0]);

        return redirect()->route('orcamento.fontes.index')
            ->with('success', 'Fonte desativada com sucesso.');
    }
}
