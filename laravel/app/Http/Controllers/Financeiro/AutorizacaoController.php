<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinAutorizacao;
use App\Models\FinPedido;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AutorizacaoController extends Controller
{
    public const TIPOS = [
        1 => ['label' => 'Atividade', 'tabela' => 'fin_autoriza_atividade', 'lotacao' => true],
        2 => ['label' => 'Central', 'tabela' => 'fin_autoriza_central', 'lotacao' => true],
        3 => ['label' => 'Orçamento', 'tabela' => 'fin_autoriza_orcamento', 'lotacao' => false],
        4 => ['label' => 'Financeiro', 'tabela' => 'fin_autorizacao_financeiro', 'lotacao' => false],
        5 => ['label' => 'Ordenado', 'tabela' => 'fin_autorizacao_ordenado', 'lotacao' => false],
    ];

    public function index(Request $request): Response
    {
        $query = FinAutorizacao::with(['pedido']);

        if ($request->filled('search')) {
            $query->where('ds_autorizacao', 'ilike', "%{$request->search}%");
        }

        if ($request->filled('st_nivel')) {
            $query->where('st_nivel', $request->st_nivel);
        }

        $autorizacoes = $query->orderBy('id_autorizacao', 'desc')
            ->paginate(15);

        return Inertia::render('Financeiro/Autorizacao/Index', [
            'autorizacoes' => $autorizacoes,
            'filters' => $request->only(['search', 'st_nivel']),
            'tipos' => self::TIPOS,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/Autorizacao/Create', [
            'tipos' => self::TIPOS,
            'pedidos' => FinPedido::whereIn('st_pedido', [10, 11, 12, 13, 14])
                ->orderBy('id_pedido', 'desc')
                ->get(['id_pedido', 'nr_pedido']),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'st_nivel' => 'required|integer|in:'.implode(',', array_keys(self::TIPOS)),
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'ds_autorizacao' => 'nullable|string',
            'dt_autorizacao' => 'required|date',
        ], [
            'st_nivel.required' => 'O nível de autorização é obrigatório.',
            'st_nivel.in' => 'Nível de autorização inválido.',
            'id_pedido.required' => 'O pedido é obrigatório.',
            'dt_autorizacao.required' => 'A data é obrigatória.',
        ]);

        $pedido = FinPedido::findOrFail($validated['id_pedido']);

        FinAutorizacao::create([
            'id_pedido' => $validated['id_pedido'],
            'st_nivel' => $validated['st_nivel'],
            'dt_autorizacao' => $validated['dt_autorizacao'],
            'ds_autorizacao' => $validated['ds_autorizacao'] ?? null,
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('financeiro.autorizacoes.index')
            ->with('success', 'Autorização registrada com sucesso.');
    }

    public function show(int $id): Response
    {
        $autorizacao = FinAutorizacao::with(['pedido'])->findOrFail($id);
        $tipoInfo = self::TIPOS[$autorizacao->st_nivel] ?? null;

        return Inertia::render('Financeiro/Autorizacao/Show', [
            'autorizacao' => $autorizacao,
            'tipoInfo' => $tipoInfo,
        ]);
    }

    public function edit(int $id): Response
    {
        $autorizacao = FinAutorizacao::with(['pedido'])->findOrFail($id);

        return Inertia::render('Financeiro/Autorizacao/Edit', [
            'autorizacao' => $autorizacao,
            'tipos' => self::TIPOS,
            'pedidos' => FinPedido::whereIn('st_pedido', [10, 11, 12, 13, 14])
                ->orderBy('id_pedido', 'desc')
                ->get(['id_pedido', 'nr_pedido']),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $autorizacao = FinAutorizacao::findOrFail($id);

        $validated = $request->validate([
            'st_nivel' => 'required|integer|in:'.implode(',', array_keys(self::TIPOS)),
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'ds_autorizacao' => 'nullable|string',
            'dt_autorizacao' => 'required|date',
        ]);

        $autorizacao->update($validated);

        return redirect()->route('financeiro.autorizacoes.index')
            ->with('success', 'Autorização atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $autorizacao = FinAutorizacao::findOrFail($id);
        $autorizacao->delete();

        return redirect()->route('financeiro.autorizacoes.index')
            ->with('success', 'Autorização removida com sucesso.');
    }
}
