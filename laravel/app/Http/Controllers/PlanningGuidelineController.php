<?php

namespace App\Http\Controllers;

use App\Models\PlanningGuideline;
use App\Models\PlanningAxis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanningGuidelineController extends Controller
{
    public function index(): Response
    {
        $guidelines = PlanningGuideline::with('planningAxis.pesPlan')
            ->orderBy('planning_axis_id')
            ->orderBy('order')
            ->paginate(15);

        return Inertia::render('Planning/PlanningGuidelines/Index', [
            'guidelines' => $guidelines,
        ]);
    }

    public function create(): Response
    {
        $axes = PlanningAxis::with('pesPlan')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'pes_plan_id']);

        return Inertia::render('Planning/PlanningGuidelines/Create', [
            'axes' => $axes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'planning_axis_id' => 'required|exists:planning_axes,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        PlanningGuideline::create($validated);

        return redirect()->route('planning-guidelines.index')
            ->with('success', 'Diretriz criada com sucesso.');
    }

    public function show(PlanningGuideline $planningGuideline): Response
    {
        $planningGuideline->load('planningAxis.pesPlan');

        return Inertia::render('Planning/PlanningGuidelines/Show', [
            'guideline' => $planningGuideline,
        ]);
    }

    public function edit(PlanningGuideline $planningGuideline): Response
    {
        $planningGuideline->load('planningAxis.pesPlan');
        $axes = PlanningAxis::with('pesPlan')
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'pes_plan_id']);

        return Inertia::render('Planning/PlanningGuidelines/Edit', [
            'guideline' => $planningGuideline,
            'axes' => $axes,
        ]);
    }

    public function update(Request $request, PlanningGuideline $planningGuideline): RedirectResponse
    {
        $validated = $request->validate([
            'planning_axis_id' => 'required|exists:planning_axes,id',
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $planningGuideline->update($validated);

        return redirect()->route('planning-guidelines.index')
            ->with('success', 'Diretriz atualizada com sucesso.');
    }

    public function destroy(PlanningGuideline $planningGuideline): RedirectResponse
    {
        $planningGuideline->delete();

        return redirect()->route('planning-guidelines.index')
            ->with('success', 'Diretriz removida com sucesso.');
    }
}
