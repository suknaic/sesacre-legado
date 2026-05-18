<?php

namespace App\Http\Controllers;

use App\Models\AnnualPlan;
use App\Models\PasAction;
use App\Models\PlanAction;
use App\Models\PpaProjectActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PasActionController extends Controller
{
    public function index(): Response
    {
        $pasActions = PasAction::with(['annualPlan', 'planAction', 'ppaProjectActivity'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PasActions/Index', [
            'pasActions' => $pasActions,
        ]);
    }

    public function create(): Response
    {
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);
        $planActions = PlanAction::orderBy('name')->get(['id', 'name']);
        $ppaProjectActivities = PpaProjectActivity::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasActions/Create', [
            'annualPlans' => $annualPlans,
            'planActions' => $planActions,
            'ppaProjectActivities' => $ppaProjectActivities,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'plan_action_id' => 'required|exists:plan_actions,id',
            'ppa_project_activity_id' => 'nullable|exists:ppa_project_activities,id',
            'partnership_desc' => 'nullable|string',
            'programming_goal' => 'nullable|string',
            'programming_indicator' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PasAction::create($validated);

        return redirect()->route('pas-actions.index')
            ->with('success', 'Ação do PAS criada com sucesso.');
    }

    public function show(PasAction $pasAction): Response
    {
        $pasAction->load(['annualPlan', 'planAction', 'ppaProjectActivity']);

        return Inertia::render('Planning/PasActions/Show', [
            'pasAction' => $pasAction,
        ]);
    }

    public function edit(PasAction $pasAction): Response
    {
        $pasAction->load(['annualPlan', 'planAction', 'ppaProjectActivity']);
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);
        $planActions = PlanAction::orderBy('name')->get(['id', 'name']);
        $ppaProjectActivities = PpaProjectActivity::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasActions/Edit', [
            'pasAction' => $pasAction,
            'annualPlans' => $annualPlans,
            'planActions' => $planActions,
            'ppaProjectActivities' => $ppaProjectActivities,
        ]);
    }

    public function update(Request $request, PasAction $pasAction): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'plan_action_id' => 'required|exists:plan_actions,id',
            'ppa_project_activity_id' => 'nullable|exists:ppa_project_activities,id',
            'partnership_desc' => 'nullable|string',
            'programming_goal' => 'nullable|string',
            'programming_indicator' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $pasAction->update($validated);

        return redirect()->route('pas-actions.index')
            ->with('success', 'Ação do PAS atualizada com sucesso.');
    }

    public function destroy(PasAction $pasAction): RedirectResponse
    {
        $pasAction->delete();

        return redirect()->route('pas-actions.index')
            ->with('success', 'Ação do PAS removida com sucesso.');
    }
}
