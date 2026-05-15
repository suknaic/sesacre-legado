<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinCentralDemanda;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CentralDemandaController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinCentralDemanda::with('lotacao');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('lotacao', function ($q) use ($search) {
                $q->where('nm_lotacao', 'ilike', "%{$search}%");
            });
        }

        $centrais = $query->orderBy('id_central_demanda')
            ->paginate(15);

        return Inertia::render('Financeiro/CentralDemanda/Index', [
            'centrais' => $centrais,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/CentralDemanda/Create', [
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_lotacao' => 'required|exists:ses_lotacao,id_lotacao',
        ], [
            'id_lotacao.required' => 'A lotação é obrigatória.',
            'id_lotacao.exists' => 'A lotação informada não existe.',
        ]);

        $exists = FinCentralDemanda::where('id_lotacao', $validated['id_lotacao'])->exists();
        if ($exists) {
            return back()->withErrors(['id_lotacao' => 'Esta lotação já está cadastrada como central de demanda.']);
        }

        FinCentralDemanda::create($validated);

        return redirect()->route('financeiro.centrais-demanda.index')
            ->with('success', 'Central de demanda cadastrada com sucesso.');
    }

    public function show(int $id): Response
    {
        $central = FinCentralDemanda::with('lotacao')->findOrFail($id);

        return Inertia::render('Financeiro/CentralDemanda/Show', [
            'central' => $central,
        ]);
    }

    public function edit(int $id): Response
    {
        $central = FinCentralDemanda::findOrFail($id);

        return Inertia::render('Financeiro/CentralDemanda/Edit', [
            'central' => $central,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $central = FinCentralDemanda::findOrFail($id);

        $validated = $request->validate([
            'id_lotacao' => 'required|exists:ses_lotacao,id_lotacao',
        ]);

        $exists = FinCentralDemanda::where('id_lotacao', $validated['id_lotacao'])
            ->where('id_central_demanda', '!=', $id)
            ->exists();
        if ($exists) {
            return back()->withErrors(['id_lotacao' => 'Esta lotação já está cadastrada como central de demanda.']);
        }

        $central->update($validated);

        return redirect()->route('financeiro.centrais-demanda.index')
            ->with('success', 'Central de demanda atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $central = FinCentralDemanda::findOrFail($id);
        $central->delete();

        return redirect()->route('financeiro.centrais-demanda.index')
            ->with('success', 'Central de demanda removida com sucesso.');
    }
}
