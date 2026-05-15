<?php

namespace App\Http\Controllers;

use App\Models\ProcessType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProcessTypeController extends Controller
{
    public function index(): Response
    {
        $processTypes = ProcessType::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Administration/ProcessTypes/Index', [
            'processTypes' => $processTypes,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Administration/ProcessTypes/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ProcessType::create($validated);

        return redirect()->route('process-types.index')
            ->with('success', 'Tipo de tramitação criado com sucesso.');
    }

    public function show(ProcessType $processType): Response
    {
        return Inertia::render('Administration/ProcessTypes/Show', [
            'processType' => $processType,
        ]);
    }

    public function edit(ProcessType $processType): Response
    {
        return Inertia::render('Administration/ProcessTypes/Edit', [
            'processType' => $processType,
        ]);
    }

    public function update(Request $request, ProcessType $processType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $processType->update($validated);

        return redirect()->route('process-types.index')
            ->with('success', 'Tipo de tramitação atualizado com sucesso.');
    }

    public function destroy(ProcessType $processType): RedirectResponse
    {
        $processType->delete();

        return redirect()->route('process-types.index')
            ->with('success', 'Tipo de tramitação removido com sucesso.');
    }
}
