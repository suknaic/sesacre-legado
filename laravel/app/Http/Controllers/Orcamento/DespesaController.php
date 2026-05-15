<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinDespesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DespesaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinDespesa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cd_despesa', 'ilike', "%{$search}%")
                    ->orWhere('nm_despesa', 'ilike', "%{$search}%");
            });
        }

        $despesas = $query->orderBy('cd_despesa')
            ->paginate(15);

        return Inertia::render('Orcamento/Despesa/Index', [
            'despesas' => $despesas,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Orcamento/Despesa/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cd_despesa' => 'required|string|max:20|unique:fin_despesa,cd_despesa',
            'nm_despesa' => 'required|string|max:255',
            'st_ativo' => 'nullable|boolean',
        ], [
            'cd_despesa.required' => 'O código da despesa é obrigatório.',
            'cd_despesa.unique' => 'Este código de despesa já está em uso.',
            'nm_despesa.required' => 'O nome da despesa é obrigatório.',
        ]);

        FinDespesa::create($validated);

        return redirect()->route('orcamento.despesas.index')
            ->with('success', 'Despesa criada com sucesso.');
    }

    public function show(FinDespesa $despesa): Response
    {
        $despesa->load('elementos');

        return Inertia::render('Orcamento/Despesa/Show', [
            'despesa' => $despesa,
        ]);
    }

    public function edit(FinDespesa $despesa): Response
    {
        return Inertia::render('Orcamento/Despesa/Edit', [
            'despesa' => $despesa,
        ]);
    }

    public function update(Request $request, FinDespesa $despesa): RedirectResponse
    {
        $validated = $request->validate([
            'cd_despesa' => 'required|string|max:20|unique:fin_despesa,cd_despesa,'.$despesa->id_despesa.',id_despesa',
            'nm_despesa' => 'required|string|max:255',
            'st_ativo' => 'nullable|boolean',
        ]);

        $despesa->update($validated);

        return redirect()->route('orcamento.despesas.index')
            ->with('success', 'Despesa atualizada com sucesso.');
    }

    public function destroy(FinDespesa $despesa): RedirectResponse
    {
        $despesa->update(['st_ativo' => 0]);

        return redirect()->route('orcamento.despesas.index')
            ->with('success', 'Despesa desativada com sucesso.');
    }
}
