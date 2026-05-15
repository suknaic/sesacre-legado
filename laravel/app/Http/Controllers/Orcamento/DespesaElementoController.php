<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinDespesa;
use App\Models\FinDespesaElemento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DespesaElementoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinDespesaElemento::with('despesa');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cd_despesa_elemento', 'ilike', "%{$search}%")
                    ->orWhere('nm_despesa_elemento', 'ilike', "%{$search}%");
            });
        }

        $elementos = $query->orderBy('cd_despesa_elemento')
            ->paginate(15);

        return Inertia::render('Orcamento/DespesaElemento/Index', [
            'elementos' => $elementos,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $despesas = FinDespesa::where('st_ativo', '!=', 0)->orderBy('cd_despesa')->get(['id_despesa', 'cd_despesa', 'nm_despesa']);

        return Inertia::render('Orcamento/DespesaElemento/Create', [
            'despesas' => $despesas,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cd_despesa_elemento' => 'required|string|max:20|unique:fin_despesa_elemento,cd_despesa_elemento',
            'nm_despesa_elemento' => 'required|string|max:255',
            'id_despesa' => 'required|exists:fin_despesa,id_despesa',
            'st_ativo' => 'nullable|boolean',
        ], [
            'cd_despesa_elemento.required' => 'O código do elemento é obrigatório.',
            'nm_despesa_elemento.required' => 'O nome do elemento é obrigatório.',
            'id_despesa.required' => 'A despesa é obrigatória.',
        ]);

        FinDespesaElemento::create($validated);

        return redirect()->route('orcamento.despesa-elementos.index')
            ->with('success', 'Elemento de despesa criado com sucesso.');
    }

    public function show(FinDespesaElemento $despesaElemento): Response
    {
        $despesaElemento->load('despesa');

        return Inertia::render('Orcamento/DespesaElemento/Show', [
            'despesaElemento' => $despesaElemento,
        ]);
    }

    public function edit(FinDespesaElemento $despesaElemento): Response
    {
        $despesas = FinDespesa::where('st_ativo', '!=', 0)->orderBy('cd_despesa')->get(['id_despesa', 'cd_despesa', 'nm_despesa']);

        return Inertia::render('Orcamento/DespesaElemento/Edit', [
            'despesaElemento' => $despesaElemento,
            'despesas' => $despesas,
        ]);
    }

    public function update(Request $request, FinDespesaElemento $despesaElemento): RedirectResponse
    {
        $validated = $request->validate([
            'cd_despesa_elemento' => 'required|string|max:20|unique:fin_despesa_elemento,cd_despesa_elemento,'.$despesaElemento->id_despesa_elemento.',id_despesa_elemento',
            'nm_despesa_elemento' => 'required|string|max:255',
            'id_despesa' => 'required|exists:fin_despesa,id_despesa',
            'st_ativo' => 'nullable|boolean',
        ]);

        $despesaElemento->update($validated);

        return redirect()->route('orcamento.despesa-elementos.index')
            ->with('success', 'Elemento de despesa atualizado com sucesso.');
    }

    public function destroy(FinDespesaElemento $despesaElemento): RedirectResponse
    {
        $despesaElemento->update(['st_ativo' => 0]);

        return redirect()->route('orcamento.despesa-elementos.index')
            ->with('success', 'Elemento de despesa desativado com sucesso.');
    }
}
