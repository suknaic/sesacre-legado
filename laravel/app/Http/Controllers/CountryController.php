<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function index(): Response
    {
        $countries = Country::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/Countries/Index', [
            'countries' => $countries,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/Countries/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Country::create($validated);

        return redirect()->route('countries.index')
            ->with('success', 'País criado com sucesso.');
    }

    public function show(Country $country): Response
    {
        return Inertia::render('HR/Countries/Show', [
            'country' => $country,
        ]);
    }

    public function edit(Country $country): Response
    {
        return Inertia::render('HR/Countries/Edit', [
            'country' => $country,
        ]);
    }

    public function update(Request $request, Country $country): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $country->update($validated);

        return redirect()->route('countries.index')
            ->with('success', 'País atualizado com sucesso.');
    }

    public function destroy(Country $country): RedirectResponse
    {
        $country->delete();

        return redirect()->route('countries.index')
            ->with('success', 'País removido com sucesso.');
    }
}
