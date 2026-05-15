<?php

namespace App\Http\Controllers;

use App\Models\MaritalStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MaritalStatusController extends Controller
{
    public function index(): Response
    {
        $maritalStatuses = MaritalStatus::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/MaritalStatuses/Index', [
            'maritalStatuses' => $maritalStatuses,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/MaritalStatuses/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        MaritalStatus::create($validated);

        return redirect()->route('marital-statuses.index')
            ->with('success', 'Estado civil criado com sucesso.');
    }

    public function show(MaritalStatus $maritalStatus): Response
    {
        return Inertia::render('HR/MaritalStatuses/Show', [
            'maritalStatus' => $maritalStatus,
        ]);
    }

    public function edit(MaritalStatus $maritalStatus): Response
    {
        return Inertia::render('HR/MaritalStatuses/Edit', [
            'maritalStatus' => $maritalStatus,
        ]);
    }

    public function update(Request $request, MaritalStatus $maritalStatus): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $maritalStatus->update($validated);

        return redirect()->route('marital-statuses.index')
            ->with('success', 'Estado civil atualizado com sucesso.');
    }

    public function destroy(MaritalStatus $maritalStatus): RedirectResponse
    {
        $maritalStatus->delete();

        return redirect()->route('marital-statuses.index')
            ->with('success', 'Estado civil removido com sucesso.');
    }
}
