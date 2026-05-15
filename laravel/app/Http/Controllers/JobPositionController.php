<?php

namespace App\Http\Controllers;

use App\Models\JobPosition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobPositionController extends Controller
{
    public function index(): Response
    {
        $jobPositions = JobPosition::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/JobPositions/Index', [
            'jobPositions' => $jobPositions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/JobPositions/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        JobPosition::create($validated);

        return redirect()->route('job-positions.index')
            ->with('success', 'Cargo criado com sucesso.');
    }

    public function show(JobPosition $jobPosition): Response
    {
        return Inertia::render('HR/JobPositions/Show', [
            'jobPosition' => $jobPosition,
        ]);
    }

    public function edit(JobPosition $jobPosition): Response
    {
        return Inertia::render('HR/JobPositions/Edit', [
            'jobPosition' => $jobPosition,
        ]);
    }

    public function update(Request $request, JobPosition $jobPosition): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $jobPosition->update($validated);

        return redirect()->route('job-positions.index')
            ->with('success', 'Cargo atualizado com sucesso.');
    }

    public function destroy(JobPosition $jobPosition): RedirectResponse
    {
        $jobPosition->delete();

        return redirect()->route('job-positions.index')
            ->with('success', 'Cargo removido com sucesso.');
    }
}
