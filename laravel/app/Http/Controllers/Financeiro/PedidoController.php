<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinAutorizacao;
use App\Models\FinCentralLiberacaoTrans;
use App\Models\FinConvenio;
use App\Models\FinDespesa;
use App\Models\FinDespesaElemento;
use App\Models\FinFonte;
use App\Models\FinFornecedor;
use App\Models\FinPedido;
use App\Models\FinPedidoAnotacao;
use App\Models\FinPortaria;
use App\Models\FinProgramaTrabalho;
use App\Models\FinQddValor;
use App\Models\FinTipoSolicitacao;
use App\Models\PerDiemRequest;
use App\Models\PlaTipoGasto;
use App\Models\SesLotacao;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PedidoController extends Controller
{
    public const STATUS_MAP = [
        0 => 'Cancelado',
        9 => 'Aguardando Finalizar Pré-Ordem',
        10 => 'Aguardando Autorização do Responsável Imediato',
        11 => 'Aguardando Autorização do Responsável da Central',
        12 => 'Aguardando Autorização de Orçamentário',
        13 => 'Aguardando Autorização Financeiro',
        14 => 'Aguardando Autorização Ordenador de Despesa',
        15 => 'Aguardando Empenho',
        16 => 'Aguardando Ordem',
        17 => 'Aguardando Execução',
        18 => 'Aguardando Finalizar Execução',
        19 => 'Aguardando Entrega',
        20 => 'Aguardando Finalizar Entrega',
        21 => 'Aguardando Liquidação',
        22 => 'Aguardando Pagamento',
        23 => 'Finalizado',
        24 => 'Aguardando Finalizar Ordenado',
        25 => 'Aguardando Finalizar Liquidação',
        26 => 'Aguardando Finalizar Pagamento',
    ];

    public const STATUS_COLORS = [
        0 => 'red',
        9 => 'yellow',
        10 => 'orange',
        11 => 'orange',
        12 => 'orange',
        13 => 'orange',
        14 => 'orange',
        15 => 'blue',
        16 => 'blue',
        17 => 'indigo',
        18 => 'indigo',
        19 => 'indigo',
        20 => 'indigo',
        21 => 'purple',
        22 => 'purple',
        23 => 'green',
        24 => 'yellow',
        25 => 'purple',
        26 => 'purple',
    ];

    public const CANCELAVEIS = [9, 10, 11, 12, 13, 14];

    public function index(Request $request): Response
    {
        $query = FinPedido::with([
            'tipoSolicitacao', 'fornecedor', 'fonte', 'programaTrabalho',
            'despesaElemento', 'despesa', 'pedidoSituacao',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nr_pedido', 'ilike', "%{$search}%")
                    ->orWhere('ds_pedido', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('nr_pedido')) {
            $query->where('nr_pedido', 'ilike', "%{$request->nr_pedido}%");
        }

        if ($request->filled('id_lotacao')) {
            $query->where('id_lotacao', $request->id_lotacao);
        }

        if ($request->filled('id_tipo_gasto')) {
            $query->where('id_tipo_gasto', $request->id_tipo_gasto);
        }

        if ($request->filled('id_fornecedor')) {
            $query->where('id_fornecedor', $request->id_fornecedor);
        }

        if ($request->filled('ano')) {
            $query->whereYear('dt_pedido', $request->ano);
        }

        if ($request->filled('st_pedido')) {
            $query->where('st_pedido', $request->st_pedido);
        }

        $pedidos = $query->orderBy('id_pedido', 'desc')
            ->paginate(15)
            ->through(function ($pedido) {
                $pedido->status_label = self::STATUS_MAP[$pedido->st_pedido] ?? 'Desconhecido';
                $pedido->status_color = self::STATUS_COLORS[$pedido->st_pedido] ?? 'gray';
                $pedido->pode_cancelar = in_array($pedido->st_pedido, self::CANCELAVEIS);

                return $pedido;
            });

        return Inertia::render('Financeiro/Pedido/Index', [
            'pedidos' => $pedidos,
            'filters' => $request->only(['search', 'nr_pedido', 'id_lotacao', 'id_tipo_gasto', 'id_fornecedor', 'ano', 'st_pedido']),
            'statusList' => self::STATUS_MAP,
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        $nextNumber = $this->getNextNumber();

        return Inertia::render('Financeiro/Pedido/Create', [
            'nextNumber' => $nextNumber,
            'tiposSolicitacao' => FinTipoSolicitacao::orderBy('nm_tipo_solicitacao')->get(),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa', 'fin_fornecedor.id_contrato')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'fontes' => FinFonte::where('st_fonte', 1)->orderBy('nr_fonte')->get(),
            'programasTrabalho' => FinProgramaTrabalho::where('st_ativo', 1)->orderBy('cd_programa_trabalho')->get(),
            'despesas' => FinDespesa::where('st_ativo', 1)->orderBy('cd_despesa')->get(),
            'despesasElemento' => FinDespesaElemento::where('st_ativo', 1)->orderBy('cd_despesa_elemento')->get(),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'portarias' => FinPortaria::where('st_portaria', 1)->orderBy('nm_portaria')->get(),
            'convenios' => FinConvenio::orderBy('nm_convenio')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_tipo_solicitacao' => 'required|exists:fin_tipo_solicitacao,id_tipo_solicitacao',
            'id_fornecedor' => 'nullable|exists:fin_fornecedor,id_fornecedor',
            'id_portatia' => 'nullable|exists:fin_portaria,id_portaria',
            'id_convenio' => 'nullable|exists:fin_convenio,id_convenio',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_despesa_elemento' => 'required|exists:fin_despesa_elemento,id_despesa_elemento',
            'id_despesa' => 'required|exists:fin_despesa,id_despesa',
            'id_tipo_gasto' => 'required|integer',
            'id_lotacao' => 'required|integer',
            'ds_pedido' => 'required|string',
            'vl_pedido' => 'required|numeric|min:0.01',
            'dt_pedido' => 'required|date',
        ], [
            'id_tipo_solicitacao.required' => 'O tipo de solicitação é obrigatório.',
            'id_fonte.required' => 'A fonte é obrigatória.',
            'id_programa_trabalho.required' => 'O programa de trabalho é obrigatório.',
            'id_despesa_elemento.required' => 'O elemento de despesa é obrigatório.',
            'id_despesa.required' => 'A despesa é obrigatória.',
            'id_tipo_gasto.required' => 'O tipo de gasto é obrigatório.',
            'id_lotacao.required' => 'A lotação é obrigatória.',
            'ds_pedido.required' => 'A descrição é obrigatória.',
            'vl_pedido.required' => 'O valor é obrigatório.',
            'vl_pedido.min' => 'O valor deve ser maior que zero.',
            'dt_pedido.required' => 'A data é obrigatória.',
        ]);

        $nrPedido = $this->getNextNumber();

        $saldoDisponivel = $this->verificarSaldoLiberacao(
            $validated['id_fonte'],
            $validated['id_programa_trabalho'],
            $validated['id_despesa_elemento'],
            $validated['id_tipo_gasto'],
            $validated['id_lotacao']
        );

        if ($saldoDisponivel < (float) $validated['vl_pedido']) {
            return back()->withErrors([
                'vl_pedido' => 'Saldo de liberação insuficiente. Saldo disponível: R$ '.number_format($saldoDisponivel, 2, ',', '.'),
            ]);
        }

        if ($request->filled('id_fornecedor')) {
            $stPedido = 9;
        } else {
            $stPedido = 11;
        }

        $pedido = FinPedido::create([
            'nr_pedido' => $nrPedido,
            'id_tipo_solicitacao' => $validated['id_tipo_solicitacao'],
            'id_fornecedor' => $validated['id_fornecedor'] ?? null,
            'id_portatia' => $validated['id_portatia'] ?? null,
            'id_convenio' => $validated['id_convenio'] ?? null,
            'id_fonte' => $validated['id_fonte'],
            'id_programa_trabalho' => $validated['id_programa_trabalho'],
            'id_despesa_elemento' => $validated['id_despesa_elemento'],
            'id_despesa' => $validated['id_despesa'],
            'id_tipo_gasto' => $validated['id_tipo_gasto'],
            'id_lotacao' => $validated['id_lotacao'],
            'ds_pedido' => $validated['ds_pedido'],
            'vl_pedido' => $validated['vl_pedido'],
            'dt_pedido' => $validated['dt_pedido'],
            'st_pedido' => $stPedido,
        ]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Pedido criado com status: '.(self::STATUS_MAP[$stPedido] ?? $stPedido),
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        if ((int) $validated['id_tipo_gasto'] === 13) {
            // Auto-link with PerDiemRequest (tipo_gasto == 13 = diárias)
            PerDiemRequest::where('id_pedido', $pedido->id_pedido)->orWhereNull('id_pedido');
        }

        return redirect()->route('financeiro.pedidos.show', $pedido->id_pedido)
            ->with('success', 'Pedido nº '.$nrPedido.' criado com sucesso.');
    }

    public function show(FinPedido $pedido): Response
    {
        $pedido->load([
            'tipoSolicitacao', 'fornecedor', 'fonte', 'programaTrabalho',
            'despesaElemento.despesa', 'despesa', 'pedidoSituacao',
            'anotacoes', 'preOrdens', 'empenhos', 'ordens', 'documentosFiscais',
        ]);

        $pedido->status_label = self::STATUS_MAP[$pedido->st_pedido] ?? 'Desconhecido';
        $pedido->status_color = self::STATUS_COLORS[$pedido->st_pedido] ?? 'gray';
        $pedido->pode_cancelar = in_array($pedido->st_pedido, self::CANCELAVEIS);

        $lotacao = SesLotacao::find($pedido->id_lotacao);
        $tipoGasto = PlaTipoGasto::find($pedido->id_tipo_gasto);

        return Inertia::render('Financeiro/Pedido/Show', [
            'pedido' => $pedido,
            'lotacao' => $lotacao,
            'tipoGasto' => $tipoGasto,
        ]);
    }

    public function edit(FinPedido $pedido): Response
    {
        if (! in_array($pedido->st_pedido, self::CANCELAVEIS)) {
            return redirect()->route('financeiro.pedidos.show', $pedido->id_pedido)
                ->with('error', 'Este pedido não pode ser editado pois está em um status avançado.');
        }

        $pedido->load(['tipoSolicitacao', 'fornecedor', 'fonte', 'programaTrabalho', 'despesaElemento', 'despesa']);

        return Inertia::render('Financeiro/Pedido/Edit', [
            'pedido' => $pedido,
            'tiposSolicitacao' => FinTipoSolicitacao::orderBy('nm_tipo_solicitacao')->get(),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'fontes' => FinFonte::where('st_fonte', 1)->orderBy('nr_fonte')->get(),
            'programasTrabalho' => FinProgramaTrabalho::where('st_ativo', 1)->orderBy('cd_programa_trabalho')->get(),
            'despesas' => FinDespesa::where('st_ativo', 1)->orderBy('cd_despesa')->get(),
            'despesasElemento' => FinDespesaElemento::where('st_ativo', 1)->orderBy('cd_despesa_elemento')->get(),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
            'portarias' => FinPortaria::where('st_portaria', 1)->orderBy('nm_portaria')->get(),
            'convenios' => FinConvenio::orderBy('nm_convenio')->get(),
        ]);
    }

    public function update(Request $request, FinPedido $pedido): RedirectResponse
    {
        if (! in_array($pedido->st_pedido, self::CANCELAVEIS)) {
            return redirect()->route('financeiro.pedidos.show', $pedido->id_pedido)
                ->with('error', 'Este pedido não pode ser editado.');
        }

        $validated = $request->validate([
            'id_tipo_solicitacao' => 'required|exists:fin_tipo_solicitacao,id_tipo_solicitacao',
            'id_fornecedor' => 'nullable|exists:fin_fornecedor,id_fornecedor',
            'id_portatia' => 'nullable|exists:fin_portaria,id_portaria',
            'id_convenio' => 'nullable|exists:fin_convenio,id_convenio',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_despesa_elemento' => 'required|exists:fin_despesa_elemento,id_despesa_elemento',
            'id_despesa' => 'required|exists:fin_despesa,id_despesa',
            'id_tipo_gasto' => 'required|integer',
            'id_lotacao' => 'required|integer',
            'ds_pedido' => 'required|string',
            'vl_pedido' => 'required|numeric|min:0.01',
            'dt_pedido' => 'required|date',
        ]);

        $pedido->update($validated);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Pedido atualizado.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('financeiro.pedidos.show', $pedido->id_pedido)
            ->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(FinPedido $pedido): RedirectResponse
    {
        if (! in_array($pedido->st_pedido, self::CANCELAVEIS)) {
            return redirect()->route('financeiro.pedidos.show', $pedido->id_pedido)
                ->with('error', 'Este pedido não pode ser cancelado pois já está em empenho ou status posterior.');
        }

        $pedido->update(['st_pedido' => 0]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Pedido cancelado.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        return redirect()->route('financeiro.pedidos.index')
            ->with('success', 'Pedido cancelado com sucesso.');
    }

    public function autorizarImediato(Request $request, FinPedido $pedido): RedirectResponse
    {
        if ($pedido->st_pedido !== 10) {
            return back()->with('error', 'Status inválido para esta autorização.');
        }

        $pedido->update(['st_pedido' => 11]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Autorizado pelo Responsável Imediato.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        FinAutorizacao::create([
            'id_pedido' => $pedido->id_pedido,
            'st_nivel' => 1,
            'dt_autorizacao' => now(),
            'ds_autorizacao' => $request->input('ds_autorizacao'),
            'id_pessoa' => auth()->id(),
        ]);

        return back()->with('success', 'Autorização do responsável imediato registrada.');
    }

    public function autorizarCentral(Request $request, FinPedido $pedido): RedirectResponse
    {
        if ($pedido->st_pedido !== 11) {
            return back()->with('error', 'Status inválido para esta autorização.');
        }

        $pedido->update(['st_pedido' => 12]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Autorizado pelo Responsável da Central.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        FinAutorizacao::create([
            'id_pedido' => $pedido->id_pedido,
            'st_nivel' => 2,
            'dt_autorizacao' => now(),
            'ds_autorizacao' => $request->input('ds_autorizacao'),
            'id_pessoa' => auth()->id(),
        ]);

        return back()->with('success', 'Autorização do responsável da central registrada.');
    }

    public function autorizarOrcamentario(Request $request, FinPedido $pedido): RedirectResponse
    {
        if ($pedido->st_pedido !== 12) {
            return back()->with('error', 'Status inválido para esta autorização.');
        }

        $pedido->update(['st_pedido' => 13]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Autorizado pelo Orçamentário.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        FinAutorizacao::create([
            'id_pedido' => $pedido->id_pedido,
            'st_nivel' => 3,
            'dt_autorizacao' => now(),
            'ds_autorizacao' => $request->input('ds_autorizacao'),
            'id_pessoa' => auth()->id(),
        ]);

        return back()->with('success', 'Autorização orçamentária registrada.');
    }

    public function autorizarFinanceiro(Request $request, FinPedido $pedido): RedirectResponse
    {
        if ($pedido->st_pedido !== 13) {
            return back()->with('error', 'Status inválido para esta autorização.');
        }

        $pedido->update(['st_pedido' => 14]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Autorizado pelo Financeiro.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        FinAutorizacao::create([
            'id_pedido' => $pedido->id_pedido,
            'st_nivel' => 4,
            'dt_autorizacao' => now(),
            'ds_autorizacao' => $request->input('ds_autorizacao'),
            'id_pessoa' => auth()->id(),
        ]);

        return back()->with('success', 'Autorização financeira registrada.');
    }

    public function autorizarOrdenador(Request $request, FinPedido $pedido): RedirectResponse
    {
        if ($pedido->st_pedido !== 14) {
            return back()->with('error', 'Status inválido para esta autorização.');
        }

        $pedido->update(['st_pedido' => 15]);

        FinPedidoAnotacao::create([
            'id_pedido' => $pedido->id_pedido,
            'ds_pedido_anotacao' => 'Autorizado pelo Ordenador de Despesa.',
            'dh_pedido_anotacao' => now(),
            'id_pessoa' => auth()->id(),
        ]);

        FinAutorizacao::create([
            'id_pedido' => $pedido->id_pedido,
            'st_nivel' => 5,
            'dt_autorizacao' => now(),
            'ds_autorizacao' => $request->input('ds_autorizacao'),
            'id_pessoa' => auth()->id(),
        ]);

        return back()->with('success', 'Autorização do ordenador de despesa registrada.');
    }

    public function dashboardQuantidades(): Response
    {
        $quantidades = FinPedido::selectRaw('st_pedido, count(*) as total')
            ->groupBy('st_pedido')
            ->pluck('total', 'st_pedido');

        $statusCount = [];
        foreach (self::STATUS_MAP as $key => $label) {
            $statusCount[] = [
                'st_pedido' => $key,
                'label' => $label,
                'total' => $quantidades->get($key, 0),
                'color' => self::STATUS_COLORS[$key] ?? 'gray',
            ];
        }

        return Inertia::render('Financeiro/Pedido/Dashboard', [
            'statusCount' => $statusCount,
        ]);
    }

    private function getNextNumber(): string
    {
        $year = now()->year;
        $last = FinPedido::whereYear('dt_pedido', $year)
            ->orderBy('nr_pedido', 'desc')
            ->first();

        if ($last && $last->nr_pedido) {
            $parts = explode('/', $last->nr_pedido);
            $seq = ((int) ($parts[0] ?? 0)) + 1;
        } else {
            $seq = 1;
        }

        return str_pad((string) $seq, 4, '0', STR_PAD_LEFT).'/'.$year;
    }

    private function verificarSaldoLiberacao(
        int $idFonte,
        int $idProgramaTrabalho,
        int $idDespesaElemento,
        int $idTipoGasto,
        int $idLotacao
    ): float {
        $qddValor = FinQddValor::where('id_fonte', $idFonte)
            ->where('id_programa_trabalho', $idProgramaTrabalho)
            ->where('id_despesa_elemento', $idDespesaElemento)
            ->first();

        if (! $qddValor) {
            return 0;
        }

        $saldo = (float) $qddValor->vl_saldo;

        $totalLiberado = (float) FinCentralLiberacaoTrans::whereHas('centralLiberacao', function ($q) use ($idLotacao) {
            $q->where('id_lotacao', $idLotacao)->where('st_central_liberacao', 1);
        })
            ->where('id_qdd_valor', $qddValor->id_qdd_valor)
            ->sum('vl_central_liberacao_trans');

        $totalPedidos = (float) FinPedido::where('id_fonte', $idFonte)
            ->where('id_programa_trabalho', $idProgramaTrabalho)
            ->where('id_despesa_elemento', $idDespesaElemento)
            ->whereNotIn('st_pedido', [0])
            ->sum('vl_pedido');

        return $totalLiberado - $totalPedidos;
    }
}
