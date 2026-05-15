<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinDespesaElemento;
use App\Models\FinFonte;
use App\Models\FinProgramaTrabalho;
use App\Models\FinQdd;
use App\Models\FinQddValor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QddValorController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinQddValor::with(['qdd', 'fonte', 'programaTrabalho', 'despesaElemento']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('fonte', fn ($q) => $q->where('nr_fonte', 'ilike', "%{$search}%"))
                ->orWhereHas('programaTrabalho', fn ($q) => $q->where('nm_programa_trabalho', 'ilike', "%{$search}%"))
                ->orWhereHas('despesaElemento', fn ($q) => $q->where('nm_despesa_elemento', 'ilike', "%{$search}%"));
        }

        if ($request->filled('id_qdd')) {
            $query->where('id_qdd', $request->id_qdd);
        }

        $valores = $query->orderBy('id_qdd_valor', 'desc')
            ->paginate(15);

        $qdds = FinQdd::orderBy('aa_qdd', 'desc')->get(['id_qdd', 'aa_qdd']);

        return Inertia::render('Orcamento/QddValor/Index', [
            'valores' => $valores,
            'qdds' => $qdds,
            'filters' => $request->only(['search', 'id_qdd']),
        ]);
    }

    public function create(): Response
    {
        $qdds = FinQdd::orderBy('aa_qdd', 'desc')->get(['id_qdd', 'aa_qdd']);
        $fontes = FinFonte::orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);
        $programas = FinProgramaTrabalho::orderBy('cd_programa_trabalho')->get(['id_programa_trabalho', 'cd_programa_trabalho', 'nm_programa_trabalho']);
        $elementos = FinDespesaElemento::orderBy('cd_despesa_elemento')->get(['id_despesa_elemento', 'cd_despesa_elemento', 'nm_despesa_elemento']);

        return Inertia::render('Orcamento/QddValor/Create', [
            'qdds' => $qdds,
            'fontes' => $fontes,
            'programas' => $programas,
            'elementos' => $elementos,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_qdd' => 'required|exists:fin_qdd,id_qdd',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_despesa_elemento' => 'required|exists:fin_despesa_elemento,id_despesa_elemento',
            'vl_qdd_inical' => 'nullable|numeric|min:0',
            'vl_qdd_suplementado' => 'nullable|numeric|min:0',
            'vl_qdd_reduzido' => 'nullable|numeric|min:0',
            'vl_empenhado' => 'nullable|numeric|min:0',
            'vl_bloqueado' => 'nullable|numeric|min:0',
            'vl_liberado' => 'nullable|numeric|min:0',
        ], [
            'id_qdd.required' => 'O QDD é obrigatório.',
            'id_fonte.required' => 'A fonte é obrigatória.',
            'id_programa_trabalho.required' => 'O programa de trabalho é obrigatório.',
            'id_despesa_elemento.required' => 'O elemento de despesa é obrigatório.',
        ]);

        $vlInicial = (float) ($validated['vl_qdd_inical'] ?? 0);
        $vlSuplementado = (float) ($validated['vl_qdd_suplementado'] ?? 0);
        $vlReduzido = (float) ($validated['vl_qdd_reduzido'] ?? 0);
        $vlEmpenhado = (float) ($validated['vl_empenhado'] ?? 0);
        $vlBloqueado = (float) ($validated['vl_bloqueado'] ?? 0);
        $vlLiberado = (float) ($validated['vl_liberado'] ?? 0);

        $vlAtual = $vlInicial + $vlSuplementado - $vlReduzido;
        $vlSaldo = $vlAtual - $vlEmpenhado - $vlBloqueado;

        $validated['vl_qdd_inical'] = $vlInicial;
        $validated['vl_qdd_suplementado'] = $vlSuplementado;
        $validated['vl_qdd_reduzido'] = $vlReduzido;
        $validated['vl_empenhado'] = $vlEmpenhado;
        $validated['vl_bloqueado'] = $vlBloqueado;
        $validated['vl_liberado'] = $vlLiberado;
        $validated['vl_saldo'] = $vlSaldo;

        FinQddValor::create($validated);

        return redirect()->route('orcamento.qdd-valor.index')
            ->with('success', 'Valor QDD criado com sucesso.');
    }

    public function show(FinQddValor $qddValor): Response
    {
        $qddValor->load(['qdd', 'fonte', 'programaTrabalho', 'despesaElemento']);

        return Inertia::render('Orcamento/QddValor/Show', [
            'qddValor' => $qddValor,
        ]);
    }

    public function edit(FinQddValor $qddValor): Response
    {
        $qdds = FinQdd::orderBy('aa_qdd', 'desc')->get(['id_qdd', 'aa_qdd']);
        $fontes = FinFonte::orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);
        $programas = FinProgramaTrabalho::orderBy('cd_programa_trabalho')->get(['id_programa_trabalho', 'cd_programa_trabalho', 'nm_programa_trabalho']);
        $elementos = FinDespesaElemento::orderBy('cd_despesa_elemento')->get(['id_despesa_elemento', 'cd_despesa_elemento', 'nm_despesa_elemento']);

        return Inertia::render('Orcamento/QddValor/Edit', [
            'qddValor' => $qddValor,
            'qdds' => $qdds,
            'fontes' => $fontes,
            'programas' => $programas,
            'elementos' => $elementos,
        ]);
    }

    public function update(Request $request, FinQddValor $qddValor): RedirectResponse
    {
        $validated = $request->validate([
            'id_qdd' => 'required|exists:fin_qdd,id_qdd',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_despesa_elemento' => 'required|exists:fin_despesa_elemento,id_despesa_elemento',
            'vl_qdd_inical' => 'nullable|numeric|min:0',
            'vl_qdd_suplementado' => 'nullable|numeric|min:0',
            'vl_qdd_reduzido' => 'nullable|numeric|min:0',
            'vl_empenhado' => 'nullable|numeric|min:0',
            'vl_bloqueado' => 'nullable|numeric|min:0',
            'vl_liberado' => 'nullable|numeric|min:0',
        ]);

        $vlInicial = (float) ($validated['vl_qdd_inical'] ?? 0);
        $vlSuplementado = (float) ($validated['vl_qdd_suplementado'] ?? 0);
        $vlReduzido = (float) ($validated['vl_qdd_reduzido'] ?? 0);
        $vlEmpenhado = (float) ($validated['vl_empenhado'] ?? 0);
        $vlBloqueado = (float) ($validated['vl_bloqueado'] ?? 0);
        $vlLiberado = (float) ($validated['vl_liberado'] ?? 0);

        $vlAtual = $vlInicial + $vlSuplementado - $vlReduzido;
        $vlSaldo = $vlAtual - $vlEmpenhado - $vlBloqueado;

        $validated['vl_qdd_inical'] = $vlInicial;
        $validated['vl_qdd_suplementado'] = $vlSuplementado;
        $validated['vl_qdd_reduzido'] = $vlReduzido;
        $validated['vl_empenhado'] = $vlEmpenhado;
        $validated['vl_bloqueado'] = $vlBloqueado;
        $validated['vl_liberado'] = $vlLiberado;
        $validated['vl_saldo'] = $vlSaldo;

        $qddValor->update($validated);

        return redirect()->route('orcamento.qdd-valor.index')
            ->with('success', 'Valor QDD atualizado com sucesso.');
    }

    public function destroy(FinQddValor $qddValor): RedirectResponse
    {
        $qddValor->delete();

        return redirect()->route('orcamento.qdd-valor.index')
            ->with('success', 'Valor QDD removido com sucesso.');
    }
}
