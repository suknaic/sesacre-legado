<?php

namespace App\Http\Controllers;

use App\Models\StrategicPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StrategicPlanController extends Controller
{
    public function index(): Response
    {
        $strategicPlans = StrategicPlan::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/StrategicPlans/Index', [
            'strategicPlans' => $strategicPlans,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/StrategicPlans/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        StrategicPlan::create($validated);

        return redirect()->route('strategic-plans.index')
            ->with('success', 'PPA criado com sucesso.');
    }

    public function show(StrategicPlan $strategicPlan): Response
    {
        return Inertia::render('Planning/StrategicPlans/Show', [
            'strategicPlan' => $strategicPlan,
        ]);
    }

    public function edit(StrategicPlan $strategicPlan): Response
    {
        return Inertia::render('Planning/StrategicPlans/Edit', [
            'strategicPlan' => $strategicPlan,
        ]);
    }

    public function update(Request $request, StrategicPlan $strategicPlan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        $strategicPlan->update($validated);

        return redirect()->route('strategic-plans.index')
            ->with('success', 'PPA atualizado com sucesso.');
    }

    public function destroy(StrategicPlan $strategicPlan): RedirectResponse
    {
        $strategicPlan->delete();

        return redirect()->route('strategic-plans.index')
            ->with('success', 'PPA removido com sucesso.');
    }
}
