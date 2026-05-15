<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinBlocoOrcamentario;
use App\Models\FinRedeTematica;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RedeTematicaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinRedeTematica::with('blocoOrcamentario');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_rede_tematica', 'ilike', "%{$search}%");
        }

        $redes = $query->orderBy('nm_rede_tematica')
            ->paginate(15);

        return Inertia::render('Orcamento/RedeTematica/Index', [
            'redes' => $redes,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $blocos = FinBlocoOrcamentario::orderBy('nm_bloc_orcamentario')->get(['id_bloc_orcamentario', 'nm_bloc_orcamentario']);

        return Inertia::render('Orcamento/RedeTematica/Create', [
            'blocos' => $blocos,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_rede_tematica' => 'required|string|max:255',
            'id_bloc_orcamentario' => 'required|exists:fin_bloco_orcamentario,id_bloc_orcamentario',
        ], [
            'nm_rede_tematica.required' => 'O nome da rede temática é obrigatório.',
            'id_bloc_orcamentario.required' => 'O bloco orçamentário é obrigatório.',
        ]);

        FinRedeTematica::create($validated);

        return redirect()->route('orcamento.redes-tematicas.index')
            ->with('success', 'Rede temática criada com sucesso.');
    }

    public function show(FinRedeTematica $redeTematica): Response
    {
        $redeTematica->load('blocoOrcamentario');

        return Inertia::render('Orcamento/RedeTematica/Show', [
            'redeTematica' => $redeTematica,
        ]);
    }

    public function edit(FinRedeTematica $redeTematica): Response
    {
        $blocos = FinBlocoOrcamentario::orderBy('nm_bloc_orcamentario')->get(['id_bloc_orcamentario', 'nm_bloc_orcamentario']);

        return Inertia::render('Orcamento/RedeTematica/Edit', [
            'redeTematica' => $redeTematica,
            'blocos' => $blocos,
        ]);
    }

    public function update(Request $request, FinRedeTematica $redeTematica): RedirectResponse
    {
        $validated = $request->validate([
            'nm_rede_tematica' => 'required|string|max:255',
            'id_bloc_orcamentario' => 'required|exists:fin_bloco_orcamentario,id_bloc_orcamentario',
        ]);

        $redeTematica->update($validated);

        return redirect()->route('orcamento.redes-tematicas.index')
            ->with('success', 'Rede temática atualizada com sucesso.');
    }

    public function destroy(FinRedeTematica $redeTematica): RedirectResponse
    {
        $redeTematica->delete();

        return redirect()->route('orcamento.redes-tematicas.index')
            ->with('success', 'Rede temática removida com sucesso.');
    }
}
