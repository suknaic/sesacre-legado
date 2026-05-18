<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MaterialController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Material::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('patrimony_number', 'like', "%{$search}%")
                    ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $materials = $query->orderBy('name')->paginate(15);

        return Inertia::render('Helpdesk/Materials/Index', [
            'materials' => $materials,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Helpdesk/Materials/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'brand' => 'nullable|string',
            'model' => 'nullable|string|max:255',
            'patrimony_number' => 'nullable|string|max:20',
            'price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'serial_number' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:50',
            'ram_memory' => 'nullable|integer|min:0',
            'processor' => 'nullable|string',
            'hd_size' => 'nullable|integer|min:0',
            'has_wireless' => 'nullable|boolean',
        ]);

        Material::create($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Material cadastrado com sucesso.');
    }

    public function show(Material $material): Response
    {
        return Inertia::render('Helpdesk/Materials/Show', [
            'material' => $material,
        ]);
    }

    public function edit(Material $material): Response
    {
        return Inertia::render('Helpdesk/Materials/Edit', [
            'material' => $material,
        ]);
    }

    public function update(Request $request, Material $material): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
            'brand' => 'nullable|string',
            'model' => 'nullable|string|max:255',
            'patrimony_number' => 'nullable|string|max:20',
            'price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'serial_number' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:50',
            'ram_memory' => 'nullable|integer|min:0',
            'processor' => 'nullable|string',
            'hd_size' => 'nullable|integer|min:0',
            'has_wireless' => 'nullable|boolean',
        ]);

        $material->update($validated);

        return redirect()->route('materials.index')
            ->with('success', 'Material atualizado com sucesso.');
    }

    public function destroy(Material $material): RedirectResponse
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with('success', 'Material removido com sucesso.');
    }
}
