<?php

namespace App\Http\Controllers;

use App\Models\AnnualPlan;
use App\Models\WorkPlan;
use App\Models\WorkPlanItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class WorkPlanController extends Controller
{
    public function index(): Response
    {
        $plans = WorkPlan::with('annualPlan')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/WorkPlans/Index', [
            'plans' => $plans,
        ]);
    }

    public function create(): Response
    {
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/WorkPlans/Create', [
            'annualPlans' => $annualPlans,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        WorkPlan::create($validated);

        return redirect()->route('work-plans.index')
            ->with('success', 'PTA criado com sucesso.');
    }

    public function show(WorkPlan $workPlan): Response
    {
        $workPlan->load(['annualPlan', 'items']);

        return Inertia::render('Planning/WorkPlans/Show', [
            'plan' => $workPlan,
        ]);
    }

    public function edit(WorkPlan $workPlan): Response
    {
        $workPlan->load('annualPlan');
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/WorkPlans/Edit', [
            'plan' => $workPlan,
            'annualPlans' => $annualPlans,
        ]);
    }

    public function update(Request $request, WorkPlan $workPlan): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $workPlan->update($validated);

        return redirect()->route('work-plans.index')
            ->with('success', 'PTA atualizado com sucesso.');
    }

    public function destroy(WorkPlan $workPlan): RedirectResponse
    {
        $workPlan->delete();

        return redirect()->route('work-plans.index')
            ->with('success', 'PTA removido com sucesso.');
    }

    public function addItem(Request $request, WorkPlan $workPlan): RedirectResponse
    {
        $validated = $request->validate([
            'material_description' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_value' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['total_value'] = $validated['quantity'] * $validated['unit_value'];
        $validated['status'] = 'draft';

        $workPlan->items()->create($validated);

        return redirect()->route('work-plans.show', $workPlan)
            ->with('success', 'Item adicionado ao PTA com sucesso.');
    }

    public function updateItem(Request $request, WorkPlan $workPlan, WorkPlanItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'material_description' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_value' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,validated,returned',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['total_value'] = $validated['quantity'] * $validated['unit_value'];
        $item->update($validated);

        return redirect()->route('work-plans.show', $workPlan)
            ->with('success', 'Item do PTA atualizado com sucesso.');
    }

    public function removeItem(WorkPlan $workPlan, WorkPlanItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('work-plans.show', $workPlan)
            ->with('success', 'Item removido do PTA com sucesso.');
    }
}
