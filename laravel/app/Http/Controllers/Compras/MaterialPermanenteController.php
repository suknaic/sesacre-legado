<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\ForMaterialPermanente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MaterialPermanenteController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ForMaterialPermanente::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_material_permanente', 'ilike', "%{$search}%");
        }

        $materiais = $query->orderBy('nm_material_permanente')->paginate(15);

        return Inertia::render('Compras/MaterialPermanente/Index', [
            'materiais' => $materiais,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/MaterialPermanente/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_material_permanente' => 'required|string|max:255|unique:for_material_permanente,nm_material_permanente',
        ], [
            'nm_material_permanente.required' => 'O nome do material permanente é obrigatório.',
            'nm_material_permanente.unique' => 'Este material permanente já está cadastrado.',
        ]);

        ForMaterialPermanente::create($validated);

        return redirect()->route('compras.materiais-permanente.index')
            ->with('success', 'Material permanente cadastrado com sucesso.');
    }
}
