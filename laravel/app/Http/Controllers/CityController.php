<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CityController extends Controller
{
    public function index(): Response
    {
        $cities = City::with('state')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/Cities/Index', [
            'cities' => $cities,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/Cities/Create', [
            'states' => State::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'health_region_id' => 'nullable|integer',
            'geo_region_id' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        City::create($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Cidade criada com sucesso.');
    }

    public function show(City $city): Response
    {
        $city->load('state');

        return Inertia::render('HR/Cities/Show', [
            'city' => $city,
        ]);
    }

    public function edit(City $city): Response
    {
        $city->load('state');

        return Inertia::render('HR/Cities/Edit', [
            'city' => $city,
            'states' => State::all(),
        ]);
    }

    public function update(Request $request, City $city): RedirectResponse
    {
        $validated = $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'health_region_id' => 'nullable|integer',
            'geo_region_id' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $city->update($validated);

        return redirect()->route('cities.index')
            ->with('success', 'Cidade atualizada com sucesso.');
    }

    public function destroy(City $city): RedirectResponse
    {
        $city->delete();

        return redirect()->route('cities.index')
            ->with('success', 'Cidade removida com sucesso.');
    }
}
