<?php

namespace App\Http\Controllers;

use App\Models\PlanningAxis;
use App\Models\PesPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanningAxisController extends Controller
{
    public function index(): Response
    {
        $axes = PlanningAxis::with('pesPlan')
            ->orderBy('order')
            ->paginate(15);

        return Inertia::render('Planning/PlanningAxes/Index', [
            'axes' => $axes,
        ]);
    }

    public function create(): Response
    {
        $pesPlans = PesPlan::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PlanningAxes/Create', [
            'pesPlans' => $pesPlans,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pes_plan_id' => 'required|exists:pes_plans,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        PlanningAxis::create($validated);

        return redirect()->route('planning-axes.index')
            ->with('success', 'Eixo criado com sucesso.');
    }

    public function show(PlanningAxis $planningAxis): Response
    {
        $planningAxis->load('pesPlan');

        return Inertia::render('Planning/PlanningAxes/Show', [
            'axis' => $planningAxis,
        ]);
    }

    public function edit(PlanningAxis $planningAxis): Response
    {
        $planningAxis->load('pesPlan');
        $pesPlans = PesPlan::where('is_active', true)->orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PlanningAxes/Edit', [
            'axis' => $planningAxis,
            'pesPlans' => $pesPlans,
        ]);
    }

    public function update(Request $request, PlanningAxis $planningAxis): RedirectResponse
    {
        $validated = $request->validate([
            'pes_plan_id' => 'required|exists:pes_plans,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $planningAxis->update($validated);

        return redirect()->route('planning-axes.index')
            ->with('success', 'Eixo atualizado com sucesso.');
    }

    public function destroy(PlanningAxis $planningAxis): RedirectResponse
    {
        $planningAxis->delete();

        return redirect()->route('planning-axes.index')
            ->with('success', 'Eixo removido com sucesso.');
    }
}
