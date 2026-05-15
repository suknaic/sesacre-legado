<?php

namespace App\Http\Controllers;

use App\Models\EducationFormation;
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
        return Inertia::render('HR/EducationFormations/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        EducationFormation::create($validated);

        return redirect()->route('education-formations.index')
            ->with('success', 'Curso criado com sucesso.');
    }

    public function show(EducationFormation $educationFormation): Response
    {
        return Inertia::render('HR/EducationFormations/Show', [
            'educationFormation' => $educationFormation,
        ]);
    }

    public function edit(EducationFormation $educationFormation): Response
    {
        return Inertia::render('HR/EducationFormations/Edit', [
            'educationFormation' => $educationFormation,
        ]);
    }

    public function update(Request $request, EducationFormation $educationFormation): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
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
