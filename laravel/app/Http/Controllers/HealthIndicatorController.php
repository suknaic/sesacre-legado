<?php

namespace App\Http\Controllers;

use App\Models\HealthIndicator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HealthIndicatorController extends Controller
{
    public function index(): Response
    {
        $indicators = HealthIndicator::orderBy('name')
            ->paginate(15);

        return Inertia::render('Planning/HealthIndicators/Index', [
            'indicators' => $indicators,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/HealthIndicators/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:2200',
            'note_code' => 'nullable|string|max:20',
            'indicator_type' => 'nullable|string|max:50',
            'goal' => 'nullable|string',
            'unit' => 'nullable|string|max:255',
        ]);

        HealthIndicator::create($validated);

        return redirect()->route('health-indicators.index')
            ->with('success', 'Indicador de saúde criado com sucesso.');
    }

    public function show(HealthIndicator $healthIndicator): Response
    {
        return Inertia::render('Planning/HealthIndicators/Show', [
            'indicator' => $healthIndicator,
        ]);
    }

    public function edit(HealthIndicator $healthIndicator): Response
    {
        return Inertia::render('Planning/HealthIndicators/Edit', [
            'indicator' => $healthIndicator,
        ]);
    }

    public function update(Request $request, HealthIndicator $healthIndicator): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'nullable|integer|min:1900|max:2200',
            'note_code' => 'nullable|string|max:20',
            'indicator_type' => 'nullable|string|max:50',
            'goal' => 'nullable|string',
            'unit' => 'nullable|string|max:255',
        ]);

        $healthIndicator->update($validated);

        return redirect()->route('health-indicators.index')
            ->with('success', 'Indicador de saúde atualizado com sucesso.');
    }

    public function destroy(HealthIndicator $healthIndicator): RedirectResponse
    {
        $healthIndicator->delete();

        return redirect()->route('health-indicators.index')
            ->with('success', 'Indicador de saúde removido com sucesso.');
    }
}
