<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinCentralResponsavel;
use App\Models\FinTipoAdministracao;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CentralResponsavelController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinCentralResponsavel::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('lotacao', function ($q) use ($search) {
                $q->where('nm_lotacao', 'ilike', "%{$search}%");
            });
        }

        $responsaveis = $query->orderBy('id_central_responsavel')
            ->paginate(15);

        return Inertia::render('Financeiro/CentralResponsavel/Index', [
            'responsaveis' => $responsaveis,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/CentralResponsavel/Create', [
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'tiposAdministracao' => FinTipoAdministracao::where('st_ativo', 1)->orderBy('nm_tipo_administracao')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_lotacao' => 'required|exists:ses_lotacao,id_lotacao',
            'id_pessoa' => 'required|integer',
            'id_tipo_administracao' => 'required|exists:fin_tipo_administracao,id_tipo_administracao',
        ], [
            'id_lotacao.required' => 'A lotação é obrigatória.',
            'id_pessoa.required' => 'A pessoa é obrigatória.',
            'id_tipo_administracao.required' => 'O tipo de administração é obrigatório.',
        ]);

        FinCentralResponsavel::create($validated);

        return redirect()->route('financeiro.centrais-responsavel.index')
            ->with('success', 'Responsável vinculado com sucesso.');
    }

    public function show(int $id): Response
    {
        $responsavel = FinCentralResponsavel::findOrFail($id);

        return Inertia::render('Financeiro/CentralResponsavel/Show', [
            'responsavel' => $responsavel,
        ]);
    }

    public function edit(int $id): Response
    {
        $responsavel = FinCentralResponsavel::findOrFail($id);

        return Inertia::render('Financeiro/CentralResponsavel/Edit', [
            'responsavel' => $responsavel,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'tiposAdministracao' => FinTipoAdministracao::where('st_ativo', 1)->orderBy('nm_tipo_administracao')->get(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $responsavel = FinCentralResponsavel::findOrFail($id);

        $validated = $request->validate([
            'id_lotacao' => 'required|exists:ses_lotacao,id_lotacao',
            'id_pessoa' => 'required|integer',
            'id_tipo_administracao' => 'required|exists:fin_tipo_administracao,id_tipo_administracao',
        ]);

        $responsavel->update($validated);

        return redirect()->route('financeiro.centrais-responsavel.index')
            ->with('success', 'Responsável atualizado com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $responsavel = FinCentralResponsavel::findOrFail($id);
        $responsavel->delete();

        return redirect()->route('financeiro.centrais-responsavel.index')
            ->with('success', 'Vínculo removido com sucesso.');
    }
}
