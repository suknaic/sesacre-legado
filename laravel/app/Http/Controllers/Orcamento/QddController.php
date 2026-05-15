<?php

namespace App\Http\Controllers\Orcamento;

use App\Http\Controllers\Controller;
use App\Models\FinQdd;
use App\Models\FinQddValor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QddController extends Controller
{
    public function index(): Response
    {
        $qddList = FinQdd::orderBy('aa_qdd', 'desc')
            ->paginate(15);

        return Inertia::render('Orcamento/Qdd/Index', [
            'qddList' => $qddList,
        ]);
    }

    public function create(): Response
    {
        $ultimoQdd = FinQdd::orderBy('aa_qdd', 'desc')->first();

        return Inertia::render('Orcamento/Qdd/Create', [
            'ultimoAno' => $ultimoQdd?->aa_qdd,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'aa_qdd' => 'required|integer|digits:4|unique:fin_qdd,aa_qdd',
        ], [
            'aa_qdd.required' => 'O ano é obrigatório.',
            'aa_qdd.digits' => 'O ano deve ter exatamente 4 dígitos.',
            'aa_qdd.unique' => 'Já existe um QDD para este ano.',
        ]);

        $qdd = FinQdd::create($validated);

        $anoAnterior = $validated['aa_qdd'] - 1;
        $qddAnterior = FinQdd::where('aa_qdd', $anoAnterior)->first();

        if ($qddAnterior) {
            $valoresAnteriores = FinQddValor::where('id_qdd', $qddAnterior->id_qdd)->get();

            foreach ($valoresAnteriores as $valor) {
                FinQddValor::create([
                    'id_qdd' => $qdd->id_qdd,
                    'id_fonte' => $valor->id_fonte,
                    'id_programa_trabalho' => $valor->id_programa_trabalho,
                    'id_despesa_elemento' => $valor->id_despesa_elemento,
                    'vl_qdd_inical' => $valor->vl_qdd_inical + $valor->vl_qdd_suplementado - $valor->vl_qdd_reduzido,
                    'vl_qdd_suplementado' => 0,
                    'vl_qdd_reduzido' => 0,
                    'vl_empenhado' => 0,
                    'vl_bloqueado' => 0,
                    'vl_liberado' => 0,
                    'vl_saldo' => ($valor->vl_qdd_inical + $valor->vl_qdd_suplementado - $valor->vl_qdd_reduzido) - 0 - 0,
                ]);
            }
        }

        return redirect()->route('orcamento.qdd.index')
            ->with('success', 'QDD criado com sucesso.');
    }

    public function show(FinQdd $qdd): Response
    {
        $qdd->load(['valores.fonte', 'valores.programaTrabalho', 'valores.despesaElemento']);

        return Inertia::render('Orcamento/Qdd/Show', [
            'qdd' => $qdd,
        ]);
    }

    public function edit(FinQdd $qdd): Response
    {
        return Inertia::render('Orcamento/Qdd/Edit', [
            'qdd' => $qdd,
        ]);
    }

    public function update(Request $request, FinQdd $qdd): RedirectResponse
    {
        $validated = $request->validate([
            'aa_qdd' => 'required|integer|digits:4|unique:fin_qdd,aa_qdd,'.$qdd->id_qdd.',id_qdd',
        ], [
            'aa_qdd.required' => 'O ano é obrigatório.',
            'aa_qdd.digits' => 'O ano deve ter exatamente 4 dígitos.',
            'aa_qdd.unique' => 'Já existe um QDD para este ano.',
        ]);

        $qdd->update($validated);

        return redirect()->route('orcamento.qdd.index')
            ->with('success', 'QDD atualizado com sucesso.');
    }

    public function destroy(FinQdd $qdd): RedirectResponse
    {
        $qdd->valores()->delete();
        $qdd->delete();

        return redirect()->route('orcamento.qdd.index')
            ->with('success', 'QDD removido com sucesso.');
    }
}
