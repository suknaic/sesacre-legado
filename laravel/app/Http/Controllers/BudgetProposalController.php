<?php

namespace App\Http\Controllers;

use App\Models\BudgetProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BudgetProposalController extends Controller
{
    public function index(): Response
    {
        $budgetProposals = BudgetProposal::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/BudgetProposals/Index', [
            'budgetProposals' => $budgetProposals,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/BudgetProposals/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'situation' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        BudgetProposal::create($validated);

        return redirect()->route('budget-proposals.index')
            ->with('success', 'Proposta orçamentária criada com sucesso.');
    }

    public function show(BudgetProposal $budgetProposal): Response
    {
        return Inertia::render('Planning/BudgetProposals/Show', [
            'budgetProposal' => $budgetProposal,
        ]);
    }

    public function edit(BudgetProposal $budgetProposal): Response
    {
        return Inertia::render('Planning/BudgetProposals/Edit', [
            'budgetProposal' => $budgetProposal,
        ]);
    }

    public function update(Request $request, BudgetProposal $budgetProposal): RedirectResponse
    {
        $validated = $request->validate([
            'year' => 'required|integer',
            'situation' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $budgetProposal->update($validated);

        return redirect()->route('budget-proposals.index')
            ->with('success', 'Proposta orçamentária atualizada com sucesso.');
    }

    public function destroy(BudgetProposal $budgetProposal): RedirectResponse
    {
        $budgetProposal->delete();

        return redirect()->route('budget-proposals.index')
            ->with('success', 'Proposta orçamentária removida com sucesso.');
    }
}
