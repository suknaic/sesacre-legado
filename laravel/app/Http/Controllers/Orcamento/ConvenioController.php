<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinConvenio;
use App\Models\FinFonte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ConvenioController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinConvenio::with('fonte');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nm_convenio', 'ilike', "%{$search}%");
        }

        $convenios = $query->orderBy('nm_convenio')
            ->paginate(15);

        return Inertia::render('Orcamento/Convenio/Index', [
            'convenios' => $convenios,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $fontes = FinFonte::where('st_fonte', '!=', 0)->orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);

        return Inertia::render('Orcamento/Convenio/Create', [
            'fontes' => $fontes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'nm_convenio' => 'required|string|max:255',
            'vl_total' => 'nullable|numeric|min:0',
        ], [
            'id_fonte.required' => 'A fonte é obrigatória.',
            'nm_convenio.required' => 'O nome do convênio é obrigatório.',
        ]);

        FinConvenio::create($validated);

        return redirect()->route('orcamento.convenios.index')
            ->with('success', 'Convênio criado com sucesso.');
    }

    public function show(FinConvenio $convenio): Response
    {
        $convenio->load('fonte');

        return Inertia::render('Orcamento/Convenio/Show', [
            'convenio' => $convenio,
        ]);
    }

    public function edit(FinConvenio $convenio): Response
    {
        $fontes = FinFonte::where('st_fonte', '!=', 0)->orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);

        return Inertia::render('Orcamento/Convenio/Edit', [
            'convenio' => $convenio,
            'fontes' => $fontes,
        ]);
    }

    public function update(Request $request, FinConvenio $convenio): RedirectResponse
    {
        $validated = $request->validate([
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'nm_convenio' => 'required|string|max:255',
            'vl_total' => 'nullable|numeric|min:0',
        ]);

        $convenio->update($validated);

        return redirect()->route('orcamento.convenios.index')
            ->with('success', 'Convênio atualizado com sucesso.');
    }

    public function destroy(FinConvenio $convenio): RedirectResponse
    {
        $convenio->delete();

        return redirect()->route('orcamento.convenios.index')
            ->with('success', 'Convênio removido com sucesso.');
    }
}
