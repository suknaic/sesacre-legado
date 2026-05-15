<?php

namespace App\Http\Controllers;

use App\Models\PlanAction;
use App\Models\PlanObjective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanActionController extends Controller
{
    public function index(): Response
    {
        $planActions = PlanAction::with('objective')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PlanActions/Index', [
            'planActions' => $planActions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/PlanActions/Create', [
            'objectives' => PlanObjective::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_objective_id' => 'required|exists:plan_objectives,id',
            'name' => 'required|string|max:255',
            'indicator' => 'nullable|string|max:255',
            'goal' => 'nullable|string',
            'registration_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        PlanAction::create($validated);

        return redirect()->route('plan-actions.index')
            ->with('success', 'Ação criada com sucesso.');
    }

    public function show(PlanAction $planAction): Response
    {
        $planAction->load('objective');

        return Inertia::render('Planning/PlanActions/Show', [
            'planAction' => $planAction,
        ]);
    }

    public function edit(PlanAction $planAction): Response
    {
        $planAction->load('objective');

        return Inertia::render('Planning/PlanActions/Edit', [
            'planAction' => $planAction,
            'objectives' => PlanObjective::all(),
        ]);
    }

    public function update(Request $request, PlanAction $planAction): RedirectResponse
    {
        $validated = $request->validate([
            'plan_objective_id' => 'required|exists:plan_objectives,id',
            'name' => 'required|string|max:255',
            'indicator' => 'nullable|string|max:255',
            'goal' => 'nullable|string',
            'registration_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $planAction->update($validated);

        return redirect()->route('plan-actions.index')
            ->with('success', 'Ação atualizada com sucesso.');
    }

    public function destroy(PlanAction $planAction): RedirectResponse
    {
        $planAction->delete();

        return redirect()->route('plan-actions.index')
            ->with('success', 'Ação removida com sucesso.');
    }
}
