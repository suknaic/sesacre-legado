<?php

namespace App\Http\Controllers;

use App\Models\AnnualPlan;
use App\Models\StrategicPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AnnualPlanController extends Controller
{
    public function index(): Response
    {
        $annualPlans = AnnualPlan::with('strategicPlan')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/AnnualPlans/Index', [
            'annualPlans' => $annualPlans,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/AnnualPlans/Create', [
            'strategicPlans' => StrategicPlan::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'strategic_plan_id' => 'required|exists:strategic_plans,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        AnnualPlan::create($validated);

        return redirect()->route('annual-plans.index')
            ->with('success', 'Plano anual criado com sucesso.');
    }

    public function show(AnnualPlan $annualPlan): Response
    {
        $annualPlan->load('strategicPlan');

        return Inertia::render('Planning/AnnualPlans/Show', [
            'annualPlan' => $annualPlan,
        ]);
    }

    public function edit(AnnualPlan $annualPlan): Response
    {
        $annualPlan->load('strategicPlan');

        return Inertia::render('Planning/AnnualPlans/Edit', [
            'annualPlan' => $annualPlan,
            'strategicPlans' => StrategicPlan::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, AnnualPlan $annualPlan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'strategic_plan_id' => 'required|exists:strategic_plans,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        $annualPlan->update($validated);

        return redirect()->route('annual-plans.index')
            ->with('success', 'Plano anual atualizado com sucesso.');
    }

    public function destroy(AnnualPlan $annualPlan): RedirectResponse
    {
        $annualPlan->delete();

        return redirect()->route('annual-plans.index')
            ->with('success', 'Plano anual removido com sucesso.');
    }
}
