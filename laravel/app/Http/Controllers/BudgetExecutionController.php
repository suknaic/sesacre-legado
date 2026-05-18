<?php

namespace App\Http\Controllers;

use App\Models\BudgetExecution;
use App\Models\BudgetProposal;
use App\Models\PlanAction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BudgetExecutionController extends Controller
{
    public function index(): Response
    {
        $executions = BudgetExecution::with(['budgetProposal', 'planAction'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $summary = [
            'total' => BudgetExecution::count(),
            'total_executed' => BudgetExecution::sum('executed_amount'),
            'by_status' => [
                'not_started' => BudgetExecution::where('status', 'not_started')->count(),
                'in_progress' => BudgetExecution::where('status', 'in_progress')->count(),
                'partially_completed' => BudgetExecution::where('status', 'partially_completed')->count(),
                'completed' => BudgetExecution::where('status', 'completed')->count(),
            ],
        ];

        $budgetProposals = BudgetProposal::orderBy('year', 'desc')->get(['id', 'year', 'situation']);
        $planActions = PlanAction::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/BudgetExecutions/Index', [
            'executions' => $executions,
            'summary' => $summary,
            'budgetProposals' => $budgetProposals,
            'planActions' => $planActions,
        ]);
    }

    public function create(): Response
    {
        $budgetProposals = BudgetProposal::orderBy('year', 'desc')->get(['id', 'year', 'situation']);
        $planActions = PlanAction::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/BudgetExecutions/Create', [
            'budgetProposals' => $budgetProposals,
            'planActions' => $planActions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'budget_proposal_id' => 'required|exists:budget_proposals,id',
            'plan_action_id' => 'nullable|exists:plan_actions,id',
            'status' => 'required|in:not_started,in_progress,partially_completed,completed',
            'executed_amount' => 'required|numeric|min:0|max:9999999999999',
            'execution_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        BudgetExecution::create($validated);

        return redirect()->route('budget-execution.index')
            ->with('success', 'Execução orçamentária registrada com sucesso.');
    }

    public function show(BudgetExecution $budgetExecution): Response
    {
        $budgetExecution->load(['budgetProposal', 'planAction']);

        return Inertia::render('Planning/BudgetExecutions/Show', [
            'execution' => $budgetExecution,
        ]);
    }

    public function edit(BudgetExecution $budgetExecution): Response
    {
        $budgetExecution->load(['budgetProposal', 'planAction']);
        $budgetProposals = BudgetProposal::orderBy('year', 'desc')->get(['id', 'year', 'situation']);
        $planActions = PlanAction::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/BudgetExecutions/Edit', [
            'execution' => $budgetExecution,
            'budgetProposals' => $budgetProposals,
            'planActions' => $planActions,
        ]);
    }

    public function update(Request $request, BudgetExecution $budgetExecution): RedirectResponse
    {
        $validated = $request->validate([
            'budget_proposal_id' => 'required|exists:budget_proposals,id',
            'plan_action_id' => 'nullable|exists:plan_actions,id',
            'status' => 'required|in:not_started,in_progress,partially_completed,completed',
            'executed_amount' => 'required|numeric|min:0|max:9999999999999',
            'execution_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $budgetExecution->update($validated);

        return redirect()->route('budget-execution.index')
            ->with('success', 'Execução orçamentária atualizada com sucesso.');
    }

    public function destroy(BudgetExecution $budgetExecution): RedirectResponse
    {
        $budgetExecution->delete();

        return redirect()->route('budget-execution.index')
            ->with('success', 'Execução orçamentária removida com sucesso.');
    }
}
