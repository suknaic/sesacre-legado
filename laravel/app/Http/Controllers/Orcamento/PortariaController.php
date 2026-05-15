<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinPortaria;
use App\Models\FinRedeTematica;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PortariaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinPortaria::with('redeTematica');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_portaria', 'ilike', "%{$search}%");
        }

        if ($request->filled('st_portaria')) {
            $query->where('st_portaria', $request->st_portaria);
        }

        $portarias = $query->orderBy('dt_portaria', 'desc')
            ->paginate(15);

        return Inertia::render('Orcamento/Portaria/Index', [
            'portarias' => $portarias,
            'filters' => $request->only(['search', 'st_portaria']),
        ]);
    }

    public function create(): Response
    {
        $redes = FinRedeTematica::orderBy('nm_rede_tematica')->get(['id_rede_tematica', 'nm_rede_tematica']);

        return Inertia::render('Orcamento/Portaria/Create', [
            'redes' => $redes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_rede_tematica' => 'required|exists:fin_rede_tematica,id_rede_tematica',
            'nm_portaria' => 'required|string|max:255',
            'dt_portaria' => 'required|date',
            'vl_total' => 'required|numeric|min:0',
            'st_portaria' => 'nullable|integer|in:1,2,3',
        ], [
            'id_rede_tematica.required' => 'A rede temática é obrigatória.',
            'nm_portaria.required' => 'O nome da portaria é obrigatório.',
            'dt_portaria.required' => 'A data é obrigatória.',
            'vl_total.required' => 'O valor total é obrigatório.',
            'vl_total.min' => 'O valor total deve ser maior ou igual a zero.',
            'st_portaria.in' => 'Status inválido (1=Rascunho, 2=Assinado, 3=Cancelado).',
        ]);

        FinPortaria::create($validated);

        return redirect()->route('orcamento.portarias.index')
            ->with('success', 'Portaria criada com sucesso.');
    }

    public function show(FinPortaria $portaria): Response
    {
        $portaria->load('redeTematica');

        return Inertia::render('Orcamento/Portaria/Show', [
            'portaria' => $portaria,
        ]);
    }

    public function edit(FinPortaria $portaria): Response
    {
        $redes = FinRedeTematica::orderBy('nm_rede_tematica')->get(['id_rede_tematica', 'nm_rede_tematica']);

        return Inertia::render('Orcamento/Portaria/Edit', [
            'portaria' => $portaria,
            'redes' => $redes,
        ]);
    }

    public function update(Request $request, FinPortaria $portaria): RedirectResponse
    {
        $validated = $request->validate([
            'id_rede_tematica' => 'required|exists:fin_rede_tematica,id_rede_tematica',
            'nm_portaria' => 'required|string|max:255',
            'dt_portaria' => 'required|date',
            'vl_total' => 'required|numeric|min:0',
            'st_portaria' => 'nullable|integer|in:1,2,3',
        ]);

        $portaria->update($validated);

        return redirect()->route('orcamento.portarias.index')
            ->with('success', 'Portaria atualizada com sucesso.');
    }

    public function destroy(FinPortaria $portaria): RedirectResponse
    {
        $portaria->update(['st_portaria' => 3]);

        return redirect()->route('orcamento.portarias.index')
            ->with('success', 'Portaria cancelada com sucesso.');
    }
}
