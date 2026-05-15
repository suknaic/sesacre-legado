<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StateController extends Controller
{
    public function index(): Response
    {
        $states = State::with('country')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/States/Index', [
            'states' => $states,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/States/Create', [
            'countries' => Country::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        State::create($validated);

        return redirect()->route('states.index')
            ->with('success', 'Estado criado com sucesso.');
    }

    public function show(State $state): Response
    {
        $state->load('country');

        return Inertia::render('HR/States/Show', [
            'state' => $state,
        ]);
    }

    public function edit(State $state): Response
    {
        $state->load('country');

        return Inertia::render('HR/States/Edit', [
            'state' => $state,
            'countries' => Country::all(),
        ]);
    }

    public function update(Request $request, State $state): RedirectResponse
    {
        $validated = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'code' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $state->update($validated);

        return redirect()->route('states.index')
            ->with('success', 'Estado atualizado com sucesso.');
    }

    public function destroy(State $state): RedirectResponse
    {
        $state->delete();

        return redirect()->route('states.index')
            ->with('success', 'Estado removido com sucesso.');
    }
}
