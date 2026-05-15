<?php

namespace App\Http\Controllers;

use App\Models\EducationFormation;
use App\Models\EducationLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationFormationController extends Controller
{
    public function index(): Response
    {
        $educationFormations = EducationFormation::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/EducationFormations/Index', [
            'educationFormations' => $educationFormations,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/EducationFormations/Create', [
            'educationLevels' => EducationLevel::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'education_level_id' => 'nullable|exists:education_levels,id',
            'is_active' => 'boolean',
        ]);

        EducationFormation::create($validated);

        return redirect()->route('education-formations.index')
            ->with('success', 'Curso criado com sucesso.');
    }

    public function show(EducationFormation $educationFormation): Response
    {
        $educationFormation->load('educationLevel');

        return Inertia::render('HR/EducationFormations/Show', [
            'educationFormation' => $educationFormation,
        ]);
    }

    public function edit(EducationFormation $educationFormation): Response
    {
        return Inertia::render('HR/EducationFormations/Edit', [
            'educationFormation' => $educationFormation,
            'educationLevels' => EducationLevel::all(),
        ]);
    }

    public function update(Request $request, EducationFormation $educationFormation): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'education_level_id' => 'nullable|exists:education_levels,id',
            'is_active' => 'boolean',
        ]);

        $educationFormation->update($validated);

        return redirect()->route('education-formations.index')
            ->with('success', 'Curso atualizado com sucesso.');
    }

    public function destroy(EducationFormation $educationFormation): RedirectResponse
    {
        $educationFormation->delete();

        return redirect()->route('education-formations.index')
            ->with('success', 'Curso removido com sucesso.');
    }
}
