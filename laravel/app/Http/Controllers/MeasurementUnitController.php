<?php

namespace App\Http\Controllers;

use App\Models\MeasurementUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MeasurementUnitController extends Controller
{
    public function index(): Response
    {
        $measurementUnits = MeasurementUnit::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/MeasurementUnits/Index', [
            'measurementUnits' => $measurementUnits,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/MeasurementUnits/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        MeasurementUnit::create($validated);

        return redirect()->route('measurement-units.index')
            ->with('success', 'Unidade de medida criada com sucesso.');
    }

    public function show(MeasurementUnit $measurementUnit): Response
    {
        return Inertia::render('Planning/MeasurementUnits/Show', [
            'measurementUnit' => $measurementUnit,
        ]);
    }

    public function edit(MeasurementUnit $measurementUnit): Response
    {
        return Inertia::render('Planning/MeasurementUnits/Edit', [
            'measurementUnit' => $measurementUnit,
        ]);
    }

    public function update(Request $request, MeasurementUnit $measurementUnit): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $measurementUnit->update($validated);

        return redirect()->route('measurement-units.index')
            ->with('success', 'Unidade de medida atualizada com sucesso.');
    }

    public function destroy(MeasurementUnit $measurementUnit): RedirectResponse
    {
        $measurementUnit->delete();

        return redirect()->route('measurement-units.index')
            ->with('success', 'Unidade de medida removida com sucesso.');
    }
}
