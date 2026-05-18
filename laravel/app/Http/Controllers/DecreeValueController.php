<?php

namespace App\Http\Controllers;

use App\Models\DecreeType;
use App\Models\DecreeValue;
use App\Models\TravelClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DecreeValueController extends Controller
{
    public function index(): Response
    {
        $decreeValues = DecreeValue::with(['decreeType', 'travelClass'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Diarias/DecreeValues/Index', [
            'decreeValues' => $decreeValues,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Diarias/DecreeValues/Create', [
            'decreeTypes' => DecreeType::where('is_active', true)->get(),
            'travelClasses' => TravelClass::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'decree_type_id' => 'required|exists:decree_types,id',
            'travel_class_id' => 'required|exists:travel_classes,id',
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        DecreeValue::create($validated);

        return redirect()->route('decree-values.index')
            ->with('success', 'Valor de diária criado com sucesso.');
    }

    public function show(DecreeValue $decreeValue): Response
    {
        $decreeValue->load(['decreeType', 'travelClass']);

        return Inertia::render('Diarias/DecreeValues/Show', [
            'decreeValue' => $decreeValue,
        ]);
    }

    public function edit(DecreeValue $decreeValue): Response
    {
        return Inertia::render('Diarias/DecreeValues/Edit', [
            'decreeValue' => $decreeValue,
            'decreeTypes' => DecreeType::where('is_active', true)->get(),
            'travelClasses' => TravelClass::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, DecreeValue $decreeValue): RedirectResponse
    {
        $validated = $request->validate([
            'decree_type_id' => 'required|exists:decree_types,id',
            'travel_class_id' => 'required|exists:travel_classes,id',
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $decreeValue->update($validated);

        return redirect()->route('decree-values.index')
            ->with('success', 'Valor de diária atualizado com sucesso.');
    }

    public function destroy(DecreeValue $decreeValue): RedirectResponse
    {
        $decreeValue->delete();

        return redirect()->route('decree-values.index')
            ->with('success', 'Valor de diária removido com sucesso.');
    }
}
