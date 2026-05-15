<?php

namespace App\Http\Controllers;

use App\Models\JobFunction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class JobFunctionController extends Controller
{
    public function index(): Response
    {
        $jobFunctions = JobFunction::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/JobFunctions/Index', [
            'jobFunctions' => $jobFunctions,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/JobFunctions/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        JobFunction::create($validated);

        return redirect()->route('job-functions.index')
            ->with('success', 'Função criada com sucesso.');
    }

    public function show(JobFunction $jobFunction): Response
    {
        return Inertia::render('HR/JobFunctions/Show', [
            'jobFunction' => $jobFunction,
        ]);
    }

    public function edit(JobFunction $jobFunction): Response
    {
        return Inertia::render('HR/JobFunctions/Edit', [
            'jobFunction' => $jobFunction,
        ]);
    }

    public function update(Request $request, JobFunction $jobFunction): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $jobFunction->update($validated);

        return redirect()->route('job-functions.index')
            ->with('success', 'Função atualizada com sucesso.');
    }

    public function destroy(JobFunction $jobFunction): RedirectResponse
    {
        $jobFunction->delete();

        return redirect()->route('job-functions.index')
            ->with('success', 'Função removida com sucesso.');
    }
}
