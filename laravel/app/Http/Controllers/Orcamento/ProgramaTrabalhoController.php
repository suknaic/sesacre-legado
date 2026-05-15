<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinProgramaTrabalho;
use App\Models\FinProgTrabFuncao;
use App\Models\FinProgTrabPrograma;
use App\Models\FinProgTrabSubFuncao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProgramaTrabalhoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinProgramaTrabalho::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('cd_programa_trabalho', 'ilike', "%{$search}%")
                    ->orWhere('nm_programa_trabalho', 'ilike', "%{$search}%");
            });
        }

        $programas = $query->orderBy('cd_programa_trabalho')
            ->paginate(15);

        return Inertia::render('Orcamento/ProgramaTrabalho/Index', [
            'programas' => $programas,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $funcoes = FinProgTrabFuncao::orderBy('cod_funcao')->get();
        $subfuncoes = FinProgTrabSubFuncao::orderBy('cod_sub_funcao')->get();
        $programas = FinProgTrabPrograma::orderBy('cod_programa')->get();

        return Inertia::render('Orcamento/ProgramaTrabalho/Create', [
            'funcoes' => $funcoes,
            'subfuncoes' => $subfuncoes,
            'programasList' => $programas,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cd_programa_trabalho' => 'required|string|size:8|unique:fin_programa_trabalho,cd_programa_trabalho',
            'nm_programa_trabalho' => 'required|string|max:255',
            'st_ativo' => 'nullable|boolean',
        ], [
            'cd_programa_trabalho.required' => 'O código do programa de trabalho é obrigatório.',
            'cd_programa_trabalho.size' => 'O código deve ter exatamente 8 caracteres (formato XX.XXX.XXXX).',
            'cd_programa_trabalho.unique' => 'Este código de programa de trabalho já está em uso.',
            'nm_programa_trabalho.required' => 'O nome do programa de trabalho é obrigatório.',
        ]);

        FinProgramaTrabalho::create($validated);

        return redirect()->route('orcamento.programa-trabalho.index')
            ->with('success', 'Programa de trabalho criado com sucesso.');
    }

    public function show(FinProgramaTrabalho $programaTrabalho): Response
    {
        return Inertia::render('Orcamento/ProgramaTrabalho/Show', [
            'programaTrabalho' => $programaTrabalho,
        ]);
    }

    public function edit(FinProgramaTrabalho $programaTrabalho): Response
    {
        $funcoes = FinProgTrabFuncao::orderBy('cod_funcao')->get();
        $subfuncoes = FinProgTrabSubFuncao::orderBy('cod_sub_funcao')->get();
        $programas = FinProgTrabPrograma::orderBy('cod_programa')->get();

        return Inertia::render('Orcamento/ProgramaTrabalho/Edit', [
            'programaTrabalho' => $programaTrabalho,
            'funcoes' => $funcoes,
            'subfuncoes' => $subfuncoes,
            'programasList' => $programas,
        ]);
    }

    public function update(Request $request, FinProgramaTrabalho $programaTrabalho): RedirectResponse
    {
        $validated = $request->validate([
            'cd_programa_trabalho' => 'required|string|size:8|unique:fin_programa_trabalho,cd_programa_trabalho,'.$programaTrabalho->id_programa_trabalho.',id_programa_trabalho',
            'nm_programa_trabalho' => 'required|string|max:255',
            'st_ativo' => 'nullable|boolean',
        ], [
            'cd_programa_trabalho.size' => 'O código deve ter exatamente 8 caracteres (formato XX.XXX.XXXX).',
            'cd_programa_trabalho.unique' => 'Este código de programa de trabalho já está em uso.',
        ]);

        $programaTrabalho->update($validated);

        return redirect()->route('orcamento.programa-trabalho.index')
            ->with('success', 'Programa de trabalho atualizado com sucesso.');
    }

    public function destroy(FinProgramaTrabalho $programaTrabalho): RedirectResponse
    {
        $programaTrabalho->update(['st_ativo' => 0]);

        return redirect()->route('orcamento.programa-trabalho.index')
            ->with('success', 'Programa de trabalho desativado com sucesso.');
    }
}
