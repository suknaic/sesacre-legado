<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinCentralLiberacao;
use App\Models\FinQddValor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CentralLiberacaoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinCentralLiberacao::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('ds_central_liberacao', 'ilike', "%{$search}%");
        }

        $liberacoes = $query->orderBy('dh_central_liberacao', 'desc')
            ->paginate(15);

        return Inertia::render('Orcamento/CentralLiberacao/Index', [
            'liberacoes' => $liberacoes,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $qddValores = FinQddValor::with(['qdd', 'fonte', 'programaTrabalho', 'despesaElemento'])
            ->get();

        return Inertia::render('Orcamento/CentralLiberacao/Create', [
            'qddValores' => $qddValores,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_qdd_valor' => 'required|exists:fin_qdd_valor,id_qdd_valor',
            'dh_central_liberacao' => 'required|date',
            'ds_central_liberacao' => 'nullable|string',
            'tp_central_liberacao' => 'nullable|string|max:50',
            'id_pessoa' => 'nullable|integer',
            'id_lotacao' => 'nullable|integer',
            'st_central_liberacao' => 'nullable|integer|in:1,2,3',
            'vl_central_liberacao' => 'required|numeric|min:0.01',
        ], [
            'id_qdd_valor.required' => 'O valor de QDD é obrigatório.',
            'dh_central_liberacao.required' => 'A data/hora é obrigatória.',
            'vl_central_liberacao.required' => 'O valor da liberação é obrigatório.',
            'vl_central_liberacao.min' => 'O valor deve ser maior que zero.',
        ]);

        $qddValor = FinQddValor::findOrFail($validated['id_qdd_valor']);
        $vlLiberacao = (float) $validated['vl_central_liberacao'];

        $vlInicial = (float) $qddValor->vl_qdd_inical;
        $vlSuplementado = (float) $qddValor->vl_qdd_suplementado;
        $vlReduzido = (float) $qddValor->vl_qdd_reduzido;
        $vlEmpenhado = (float) $qddValor->vl_empenhado;
        $vlBloqueado = (float) $qddValor->vl_bloqueado;

        $novoBloqueado = $vlBloqueado + $vlLiberacao;
        $vlAtual = $vlInicial + $vlSuplementado - $vlReduzido;
        $vlSaldo = $vlAtual - $vlEmpenhado - $novoBloqueado;

        $qddValor->update([
            'vl_bloqueado' => $novoBloqueado,
            'vl_saldo' => $vlSaldo,
        ]);

        FinCentralLiberacao::create([
            'dh_central_liberacao' => $validated['dh_central_liberacao'],
            'ds_central_liberacao' => $validated['ds_central_liberacao'] ?? null,
            'tp_central_liberacao' => $validated['tp_central_liberacao'] ?? null,
            'id_pessoa' => $validated['id_pessoa'] ?? null,
            'id_lotacao' => $validated['id_lotacao'] ?? null,
            'st_central_liberacao' => $validated['st_central_liberacao'] ?? 1,
        ]);

        return redirect()->route('orcamento.central-liberacoes.index')
            ->with('success', 'Liberação registrada com sucesso.');
    }

    public function show(FinCentralLiberacao $centralLiberacao): Response
    {
        return Inertia::render('Orcamento/CentralLiberacao/Show', [
            'centralLiberacao' => $centralLiberacao,
        ]);
    }

    public function edit(FinCentralLiberacao $centralLiberacao): Response
    {
        $qddValores = FinQddValor::with(['qdd', 'fonte', 'programaTrabalho', 'despesaElemento'])
            ->get();

        return Inertia::render('Orcamento/CentralLiberacao/Edit', [
            'centralLiberacao' => $centralLiberacao,
            'qddValores' => $qddValores,
        ]);
    }

    public function update(Request $request, FinCentralLiberacao $centralLiberacao): RedirectResponse
    {
        $validated = $request->validate([
            'id_qdd_valor' => 'required|exists:fin_qdd_valor,id_qdd_valor',
            'dh_central_liberacao' => 'required|date',
            'ds_central_liberacao' => 'nullable|string',
            'tp_central_liberacao' => 'nullable|string|max:50',
            'id_pessoa' => 'nullable|integer',
            'id_lotacao' => 'nullable|integer',
            'st_central_liberacao' => 'nullable|integer|in:1,2,3',
            'vl_central_liberacao' => 'required|numeric|min:0.01',
        ]);

        $centralLiberacao->update($validated);

        return redirect()->route('orcamento.central-liberacoes.index')
            ->with('success', 'Liberação atualizada com sucesso.');
    }

    public function destroy(FinCentralLiberacao $centralLiberacao): RedirectResponse
    {
        $centralLiberacao->update(['st_central_liberacao' => 3]);

        return redirect()->route('orcamento.central-liberacoes.index')
            ->with('success', 'Liberação cancelada com sucesso.');
    }
}
