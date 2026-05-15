<?php

namespace App\Http\Controllers;

use App\Models\ContractSituation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContractSituationController extends Controller
{
    public function index(): Response
    {
        $contractSituations = ContractSituation::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/ContractSituations/Index', [
            'contractSituations' => $contractSituations,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/ContractSituations/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:F,L,C,A,I',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'type.required' => 'O tipo é obrigatório.',
            'type.in' => 'O tipo deve ser F (Férias), L (Licenças), C (Concessões), A (Afastamentos) ou I (Inativos).',
        ]);

        ContractSituation::create($validated);

        return redirect()->route('contract-situations.index')
            ->with('success', 'Situação contratual criada com sucesso.');
    }

    public function show(ContractSituation $contractSituation): Response
    {
        return Inertia::render('HR/ContractSituations/Show', [
            'contractSituation' => $contractSituation,
        ]);
    }

    public function edit(ContractSituation $contractSituation): Response
    {
        return Inertia::render('HR/ContractSituations/Edit', [
            'contractSituation' => $contractSituation,
        ]);
    }

    public function update(Request $request, ContractSituation $contractSituation): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:F,L,C,A,I',
            'is_active' => 'boolean',
        ]);

        $contractSituation->update($validated);

        return redirect()->route('contract-situations.index')
            ->with('success', 'Situação contratual atualizada com sucesso.');
    }

    public function destroy(ContractSituation $contractSituation): RedirectResponse
    {
        if ($contractSituation->recruitmentHistory()->exists()) {
            return redirect()->route('contract-situations.index')
                ->with('error', 'Não é possível remover esta situação pois existem registros históricos vinculados a ela.');
        }

        $contractSituation->delete();

        return redirect()->route('contract-situations.index')
            ->with('success', 'Situação contratual removida com sucesso.');
    }
}
