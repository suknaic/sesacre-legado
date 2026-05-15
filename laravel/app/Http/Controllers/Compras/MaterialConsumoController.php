<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\ForMaterialConsumo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MaterialConsumoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ForMaterialConsumo::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_material_consumo', 'ilike', "%{$search}%");
        }

        $materiais = $query->orderBy('nm_material_consumo')->paginate(15);

        return Inertia::render('Compras/MaterialConsumo/Index', [
            'materiais' => $materiais,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/MaterialConsumo/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_material_consumo' => 'required|string|max:255|unique:for_material_consumo,nm_material_consumo',
        ], [
            'nm_material_consumo.required' => 'O nome do material de consumo é obrigatório.',
            'nm_material_consumo.unique' => 'Este material de consumo já está cadastrado.',
        ]);

        ForMaterialConsumo::create($validated);

        return redirect()->route('compras.materiais-consumo.index')
            ->with('success', 'Material de consumo cadastrado com sucesso.');
    }
}
