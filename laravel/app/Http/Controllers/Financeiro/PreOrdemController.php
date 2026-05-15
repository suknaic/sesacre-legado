<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinContItens;
use App\Models\FinContrato;
use App\Models\FinFornecedor;
use App\Models\FinPedido;
use App\Models\FinPreOrdem;
use App\Models\PlaTipoGasto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PreOrdemController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinPreOrdem::with(['pedido', 'fornecedor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pedido', function ($q) use ($search) {
                $q->where('nr_pedido', 'ilike', "%{$search}%");
            });
        }

        $preOrdens = $query->orderBy('id_pre_ordem', 'desc')
            ->paginate(15);

        return Inertia::render('Financeiro/PreOrdem/Index', [
            'preOrdens' => $preOrdens,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/PreOrdem/Create', [
            'pedidos' => FinPedido::whereIn('st_pedido', [9])
                ->orderBy('id_pedido', 'desc')
                ->get(['id_pedido', 'nr_pedido']),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'contratos' => FinContrato::where('st_ativo', 1)->orderBy('nr_contrato')->get(),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'id_fornecedor' => 'required|exists:fin_fornecedor,id_fornecedor',
            'id_cont_itens' => 'nullable|exists:fin_cont_itens,id_cont_itens',
            'qt_itens_pre' => 'nullable|integer|min:1',
            'vl_itens_pre' => 'nullable|numeric|min:0',
        ], [
            'id_pedido.required' => 'O pedido é obrigatório.',
            'id_fornecedor.required' => 'O fornecedor é obrigatório.',
        ]);

        $pedido = FinPedido::findOrFail($validated['id_pedido']);

        if ($pedido->st_pedido !== 9) {
            return back()->with('error', 'O pedido deve estar em "Aguardando Finalizar Pré-Ordem" para criar uma pré-ordem.');
        }

        $vlTotal = 0;
        if ($request->filled('id_cont_itens')) {
            $item = FinContItens::find($validated['id_cont_itens']);
            if ($item) {
                $qtde = $validated['qt_itens_pre'] ?? $item->qt_itens;
                $vlUnit = $item->vl_itens / max($item->qt_itens, 1);
                $vlTotal = $qtde * $vlUnit;
            }
        } elseif ($request->filled('vl_itens_pre')) {
            $vlTotal = (float) $validated['vl_itens_pre'];
        } else {
            $vlTotal = (float) $pedido->vl_pedido;
        }

        FinPreOrdem::create([
            'id_pedido' => $validated['id_pedido'],
            'id_fornecedor' => $validated['id_fornecedor'],
            'id_cont_itens' => $validated['id_cont_itens'] ?? null,
            'qt_itens_pre' => $validated['qt_itens_pre'] ?? null,
            'vl_itens_pre' => $validated['vl_itens_pre'] ?? $vlTotal,
            'vl_total' => $vlTotal,
        ]);

        $pedido->update(['st_pedido' => 10]);

        return redirect()->route('financeiro.pre-ordens.index')
            ->with('success', 'Pré-ordem criada com sucesso. Pedido encaminhado para autorização.');
    }

    public function show(int $id): Response
    {
        $preOrdem = FinPreOrdem::with(['pedido.tipoSolicitacao', 'fornecedor', 'ordemItens'])->findOrFail($id);

        return Inertia::render('Financeiro/PreOrdem/Show', [
            'preOrdem' => $preOrdem,
        ]);
    }

    public function edit(int $id): Response
    {
        $preOrdem = FinPreOrdem::findOrFail($id);

        return Inertia::render('Financeiro/PreOrdem/Edit', [
            'preOrdem' => $preOrdem,
            'pedidos' => FinPedido::orderBy('id_pedido', 'desc')->get(['id_pedido', 'nr_pedido']),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
        ]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $preOrdem = FinPreOrdem::findOrFail($id);

        $validated = $request->validate([
            'id_pedido' => 'required|exists:fin_pedido,id_pedido',
            'id_fornecedor' => 'required|exists:fin_fornecedor,id_fornecedor',
            'qt_itens_pre' => 'nullable|integer|min:1',
            'vl_itens_pre' => 'nullable|numeric|min:0',
        ]);

        $vlTotal = (float) ($validated['vl_itens_pre'] ?? $preOrdem->vl_total);
        $validated['vl_total'] = $vlTotal;

        $preOrdem->update($validated);

        return redirect()->route('financeiro.pre-ordens.index')
            ->with('success', 'Pré-ordem atualizada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $preOrdem = FinPreOrdem::findOrFail($id);
        $preOrdem->delete();

        return redirect()->route('financeiro.pre-ordens.index')
            ->with('success', 'Pré-ordem removida com sucesso.');
    }
}
