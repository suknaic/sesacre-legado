<?php

namespace App\Http\Controllers;

use App\Models\PlanMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PlanMaterialController extends Controller
{
    public function index(): Response
    {
        $planMaterials = PlanMaterial::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PlanMaterials/Index', [
            'planMaterials' => $planMaterials,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/PlanMaterials/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'description_code' => 'nullable|string|max:20',
            'description_name' => 'nullable|string|max:255',
            'group_code' => 'nullable|string|max:20',
            'group_name' => 'nullable|string|max:255',
            'subgroup_code' => 'nullable|string|max:20',
            'subgroup_name' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:50',
            'expense_element_code' => 'nullable|string|max:20',
            'expense_type_id' => 'nullable|integer',
        ]);

        PlanMaterial::create($validated);

        return redirect()->route('plan-materials.index')
            ->with('success', 'Material criado com sucesso.');
    }

    public function show(PlanMaterial $planMaterial): Response
    {
        return Inertia::render('Planning/PlanMaterials/Show', [
            'planMaterial' => $planMaterial,
        ]);
    }

    public function edit(PlanMaterial $planMaterial): Response
    {
        return Inertia::render('Planning/PlanMaterials/Edit', [
            'planMaterial' => $planMaterial,
        ]);
    }

    public function update(Request $request, PlanMaterial $planMaterial): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'description_code' => 'nullable|string|max:20',
            'description_name' => 'nullable|string|max:255',
            'group_code' => 'nullable|string|max:20',
            'group_name' => 'nullable|string|max:255',
            'subgroup_code' => 'nullable|string|max:20',
            'subgroup_name' => 'nullable|string|max:255',
            'material_type' => 'nullable|string|max:50',
            'expense_element_code' => 'nullable|string|max:20',
            'expense_type_id' => 'nullable|integer',
        ]);

        $planMaterial->update($validated);

        return redirect()->route('plan-materials.index')
            ->with('success', 'Material atualizado com sucesso.');
    }

    public function destroy(PlanMaterial $planMaterial): RedirectResponse
    {
        $planMaterial->delete();

        return redirect()->route('plan-materials.index')
            ->with('success', 'Material removido com sucesso.');
    }
}
