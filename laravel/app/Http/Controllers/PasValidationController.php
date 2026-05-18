<?php

namespace App\Http\Controllers;

use App\Models\AnnualPlan;
use App\Models\PasValidation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PasValidationController extends Controller
{
    public function index(): Response
    {
        $validations = PasValidation::with('annualPlan')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PasValidations/Index', [
            'validations' => $validations,
        ]);
    }

    public function create(): Response
    {
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasValidations/Create', [
            'annualPlans' => $annualPlans,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'validation_status' => 'required|integer|min:1|max:4',
            'description' => 'nullable|string',
        ]);

        PasValidation::create($validated);

        return redirect()->route('pas-validations.index')
            ->with('success', 'Validação do PAS registrada com sucesso.');
    }

    public function show(PasValidation $pasValidation): Response
    {
        $pasValidation->load('annualPlan');

        return Inertia::render('Planning/PasValidations/Show', [
            'validation' => $pasValidation,
        ]);
    }

    public function edit(PasValidation $pasValidation): Response
    {
        $pasValidation->load('annualPlan');
        $annualPlans = AnnualPlan::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasValidations/Edit', [
            'validation' => $pasValidation,
            'annualPlans' => $annualPlans,
        ]);
    }

    public function update(Request $request, PasValidation $pasValidation): RedirectResponse
    {
        $validated = $request->validate([
            'annual_plan_id' => 'required|exists:annual_plans,id',
            'validation_status' => 'required|integer|min:1|max:4',
            'description' => 'nullable|string',
        ]);

        $pasValidation->update($validated);

        return redirect()->route('pas-validations.index')
            ->with('success', 'Validação do PAS atualizada com sucesso.');
    }

    public function destroy(PasValidation $pasValidation): RedirectResponse
    {
        $pasValidation->delete();

        return redirect()->route('pas-validations.index')
            ->with('success', 'Validação do PAS removida com sucesso.');
    }
}
