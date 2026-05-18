<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GovernmentProgramController extends Controller
{
    public function index(): Response
    {
        $programs = StrategicPlan::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/GovernmentPrograms/Index', [
            'programs' => $programs,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/GovernmentPrograms/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        StrategicPlan::create($validated);

        return redirect()->route('government-programs.index')
            ->with('success', 'Programa de Governo criado com sucesso.');
    }

    public function show(StrategicPlan $governmentProgram): Response
    {
        return Inertia::render('Planning/GovernmentPrograms/Show', [
            'program' => $governmentProgram,
        ]);
    }

    public function edit(StrategicPlan $governmentProgram): Response
    {
        return Inertia::render('Planning/GovernmentPrograms/Edit', [
            'program' => $governmentProgram,
        ]);
    }

    public function update(Request $request, StrategicPlan $governmentProgram): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        $governmentProgram->update($validated);

        return redirect()->route('government-programs.index')
            ->with('success', 'Programa de Governo atualizado com sucesso.');
    }

    public function destroy(StrategicPlan $governmentProgram): RedirectResponse
    {
        $governmentProgram->delete();

        return redirect()->route('government-programs.index')
            ->with('success', 'Programa de Governo removido com sucesso.');
    }
}
