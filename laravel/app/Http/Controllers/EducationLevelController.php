<?php

namespace App\Http\Controllers;

use App\Models\EducationLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EducationLevelController extends Controller
{
    public function index(): Response
    {
        $educationLevels = EducationLevel::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/EducationLevels/Index', [
            'educationLevels' => $educationLevels,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/EducationLevels/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        EducationLevel::create($validated);

        return redirect()->route('education-levels.index')
            ->with('success', 'Escolaridade criada com sucesso.');
    }

    public function show(EducationLevel $educationLevel): Response
    {
        return Inertia::render('HR/EducationLevels/Show', [
            'educationLevel' => $educationLevel,
        ]);
    }

    public function edit(EducationLevel $educationLevel): Response
    {
        return Inertia::render('HR/EducationLevels/Edit', [
            'educationLevel' => $educationLevel,
        ]);
    }

    public function update(Request $request, EducationLevel $educationLevel): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $educationLevel->update($validated);

        return redirect()->route('education-levels.index')
            ->with('success', 'Escolaridade atualizada com sucesso.');
    }

    public function destroy(EducationLevel $educationLevel): RedirectResponse
    {
        $educationLevel->delete();

        return redirect()->route('education-levels.index')
            ->with('success', 'Escolaridade removida com sucesso.');
    }
}
