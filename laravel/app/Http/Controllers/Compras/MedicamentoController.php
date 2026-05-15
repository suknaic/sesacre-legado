<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\ForMedicamento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MedicamentoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ForMedicamento::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_medicamento', 'ilike', "%{$search}%");
        }

        $medicamentos = $query->orderBy('nm_medicamento')->paginate(15);

        return Inertia::render('Compras/Medicamento/Index', [
            'medicamentos' => $medicamentos,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/Medicamento/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_medicamento' => 'required|string|max:255|unique:for_medicamento,nm_medicamento',
        ], [
            'nm_medicamento.required' => 'O nome do medicamento é obrigatório.',
            'nm_medicamento.unique' => 'Este medicamento já está cadastrado.',
        ]);

        ForMedicamento::create($validated);

        return redirect()->route('compras.medicamentos.index')
            ->with('success', 'Medicamento cadastrado com sucesso.');
    }
}
