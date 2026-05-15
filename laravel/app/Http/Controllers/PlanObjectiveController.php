<?php

namespace App\Http\Controllers;

use App\Models\PlanObjective;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanObjectiveController extends Controller
{
    public function index(): Response
    {
        $planObjectives = PlanObjective::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PlanObjectives/Index', [
            'planObjectives' => $planObjectives,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/PlanObjectives/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'indicator' => 'nullable|string|max:255',
            'goal' => 'nullable|string',
            'registration_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        PlanObjective::create($validated);

        return redirect()->route('plan-objectives.index')
            ->with('success', 'Objetivo criado com sucesso.');
    }

    public function show(PlanObjective $planObjective): Response
    {
        return Inertia::render('Planning/PlanObjectives/Show', [
            'planObjective' => $planObjective,
        ]);
    }

    public function edit(PlanObjective $planObjective): Response
    {
        return Inertia::render('Planning/PlanObjectives/Edit', [
            'planObjective' => $planObjective,
        ]);
    }

    public function update(Request $request, PlanObjective $planObjective): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'indicator' => 'nullable|string|max:255',
            'goal' => 'nullable|string',
            'registration_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $planObjective->update($validated);

        return redirect()->route('plan-objectives.index')
            ->with('success', 'Objetivo atualizado com sucesso.');
    }

    public function destroy(PlanObjective $planObjective): RedirectResponse
    {
        $planObjective->delete();

        return redirect()->route('plan-objectives.index')
            ->with('success', 'Objetivo removido com sucesso.');
    }
}
