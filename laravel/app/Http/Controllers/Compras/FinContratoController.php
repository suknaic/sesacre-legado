<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\FinContrato;
use App\Models\FinFonte;
use App\Models\FinFornecedor;
use App\Models\FinModalidade;
use App\Models\FinProgramaTrabalho;
use App\Models\PlaTipoGasto;
use App\Models\SesLotacao;
use App\Models\SesPessoa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FinContratoController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinContrato::with([
            'programaTrabalho',
            'fonte',
            'fornecedor.pessoa',
            'fornecedorPessoa',
            'modalidade',
            'tipoGasto',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nr_contrato', 'ilike', "%{$search}%")
                    ->orWhere('ds_objeto', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('st_ativo')) {
            $query->where('st_ativo', $request->st_ativo);
        }

        if ($request->filled('id_fornecedor')) {
            $query->where('id_fornecedor', $request->id_fornecedor);
        }

        if ($request->filled('tp_contrato')) {
            $query->where('tp_contrato', $request->tp_contrato);
        }

        $contratos = $query->orderBy('id_contrato', 'desc')
            ->paginate(15)
            ->through(function ($c) {
                $c->vl_formatado = number_format((float) $c->vl_contrato, 2, ',', '.');
                $c->fornecedor_nome = $c->fornecedor?->pessoa?->nm_pessoa
                    ?? $c->fornecedorPessoa?->nm_pessoa
                    ?? 'N/D';
                $c->ativo_label = $c->st_ativo == 1 ? 'Ativo' : 'Inativo';

                return $c;
            });

        return Inertia::render('Compras/Contrato/Index', [
            'contratos' => $contratos,
            'filters' => $request->only(['search', 'st_ativo', 'id_fornecedor', 'tp_contrato']),
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/Contrato/Create', [
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa', 'ses_pessoa.id_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'programasTrabalho' => FinProgramaTrabalho::where('st_ativo', 1)->orderBy('cd_programa_trabalho')->get(),
            'fontes' => FinFonte::where('st_fonte', 1)->orderBy('nr_fonte')->get(),
            'modalidades' => FinModalidade::orderBy('id_modalidade')->get(),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
            'pessoas' => SesPessoa::where('st_ativo', 1)->orderBy('nm_pessoa')->get(['id_pessoa', 'nm_pessoa']),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nr_contrato' => 'required|string|max:255',
            'id_fornecedor' => 'required|exists:fin_fornecedor,id_fornecedor',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_modalidade' => 'nullable|exists:fin_modalidade,id_modalidade',
            'id_tipo_gasto' => 'required|integer',
            'ds_objeto' => 'required|string',
            'vl_contrato' => 'required|numeric|min:0.01',
            'dt_ini_vigencia_contrato' => 'required|date',
            'dt_fim_vigencia_contrato' => 'required|date|after_or_equal:dt_ini_vigencia_contrato',
            'dt_assinatura' => 'nullable|date',
            'dt_publicacao' => 'nullable|date',
            'tp_contrato' => 'nullable|string|max:50',
            'nr_prazo_entrega' => 'nullable|integer',
            'ds_obs_contrato' => 'nullable|string',
            'ds_area_abrangencia' => 'nullable|string',
            'ds_unidade_contemplada' => 'nullable|string',
            'fl_servico_continuado' => 'nullable|boolean',
            'fl_carona' => 'nullable|boolean',
            'id_pessoa_gestor_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_gestor_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_fiscal_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_fiscal_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_sub_fiscal_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_sub_fiscal_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_lotacao_central' => 'nullable|integer',
        ], [
            'nr_contrato.required' => 'O número do contrato é obrigatório.',
            'id_fornecedor.required' => 'O fornecedor é obrigatório.',
            'id_programa_trabalho.required' => 'O programa de trabalho é obrigatório.',
            'id_fonte.required' => 'A fonte é obrigatória.',
            'id_tipo_gasto.required' => 'O tipo de gasto é obrigatório.',
            'ds_objeto.required' => 'O objeto é obrigatório.',
            'vl_contrato.required' => 'O valor é obrigatório.',
            'dt_ini_vigencia_contrato.required' => 'A data de início da vigência é obrigatória.',
            'dt_fim_vigencia_contrato.required' => 'A data de fim da vigência é obrigatória.',
            'dt_fim_vigencia_contrato.after_or_equal' => 'A data de fim deve ser posterior à data de início.',
        ]);

        $fornecedor = FinFornecedor::with('pessoa')->findOrFail($validated['id_fornecedor']);

        $contrato = FinContrato::create([
            'nr_contrato' => $validated['nr_contrato'],
            'id_fornecedor' => $validated['id_fornecedor'],
            'id_pessoa_fornecedor' => $fornecedor->id_pessoa,
            'id_programa_trabalho' => $validated['id_programa_trabalho'],
            'id_fonte' => $validated['id_fonte'],
            'id_modalidade' => $validated['id_modalidade'] ?? null,
            'id_tipo_gasto' => $validated['id_tipo_gasto'],
            'ds_objeto' => $validated['ds_objeto'],
            'vl_contrato' => $validated['vl_contrato'],
            'dt_ini_vigencia_contrato' => $validated['dt_ini_vigencia_contrato'],
            'dt_fim_vigencia_contrato' => $validated['dt_fim_vigencia_contrato'],
            'dt_assinatura' => $validated['dt_assinatura'] ?? null,
            'dt_publicacao' => $validated['dt_publicacao'] ?? null,
            'tp_contrato' => $validated['tp_contrato'] ?? null,
            'nr_prazo_entrega' => $validated['nr_prazo_entrega'] ?? null,
            'ds_obs_contrato' => $validated['ds_obs_contrato'] ?? null,
            'ds_area_abrangencia' => $validated['ds_area_abrangencia'] ?? null,
            'ds_unidade_contemplada' => $validated['ds_unidade_contemplada'] ?? null,
            'fl_servico_continuado' => $validated['fl_servico_continuado'] ?? 0,
            'fl_carona' => $validated['fl_carona'] ?? 0,
            'st_ativo' => 1,
            'id_pessoa_gestor_titular' => $validated['id_pessoa_gestor_titular'] ?? null,
            'id_pessoa_gestor_substituto' => $validated['id_pessoa_gestor_substituto'] ?? null,
            'id_pessoa_fiscal_titular' => $validated['id_pessoa_fiscal_titular'] ?? null,
            'id_pessoa_fiscal_substituto' => $validated['id_pessoa_fiscal_substituto'] ?? null,
            'id_pessoa_sub_fiscal_titular' => $validated['id_pessoa_sub_fiscal_titular'] ?? null,
            'id_pessoa_sub_fiscal_substituto' => $validated['id_pessoa_sub_fiscal_substituto'] ?? null,
            'id_lotacao_central' => $validated['id_lotacao_central'] ?? null,
        ]);

        return redirect()->route('compras.contratos.show', $contrato->id_contrato)
            ->with('success', 'Contrato nº '.$validated['nr_contrato'].' criado com sucesso.');
    }

    public function show(FinContrato $contrato): Response
    {
        $contrato->load([
            'programaTrabalho',
            'fonte',
            'fornecedor.pessoa',
            'fornecedorPessoa',
            'modalidade',
            'tipoGasto',
            'gestorTitular',
            'gestorSubstituto',
            'fiscalTitular',
            'fiscalSubstituto',
            'subFiscalTitular',
            'subFiscalSubstituto',
        ]);

        $contrato->vl_formatado = number_format((float) $contrato->vl_contrato, 2, ',', '.');
        $contrato->fornecedor_nome = $contrato->fornecedor?->pessoa?->nm_pessoa
            ?? $contrato->fornecedorPessoa?->nm_pessoa
            ?? 'N/D';

        return Inertia::render('Compras/Contrato/Show', [
            'contrato' => $contrato,
        ]);
    }

    public function edit(FinContrato $contrato): Response
    {
        $contrato->load([
            'fornecedor.pessoa',
            'gestorTitular',
            'gestorSubstituto',
            'fiscalTitular',
            'fiscalSubstituto',
            'subFiscalTitular',
            'subFiscalSubstituto',
        ]);

        return Inertia::render('Compras/Contrato/Edit', [
            'contrato' => $contrato,
            'fornecedores' => FinFornecedor::query()
                ->join('ses_pessoa', 'fin_fornecedor.id_pessoa', '=', 'ses_pessoa.id_pessoa')
                ->select('fin_fornecedor.id_fornecedor', 'ses_pessoa.nm_pessoa', 'ses_pessoa.id_pessoa')
                ->orderBy('ses_pessoa.nm_pessoa')
                ->get(),
            'programasTrabalho' => FinProgramaTrabalho::where('st_ativo', 1)->orderBy('cd_programa_trabalho')->get(),
            'fontes' => FinFonte::where('st_fonte', 1)->orderBy('nr_fonte')->get(),
            'modalidades' => FinModalidade::orderBy('id_modalidade')->get(),
            'tiposGasto' => PlaTipoGasto::orderBy('nm_tipo_gasto')->get(),
            'pessoas' => SesPessoa::where('st_ativo', 1)->orderBy('nm_pessoa')->get(['id_pessoa', 'nm_pessoa']),
            'lotacoes' => SesLotacao::where('st_ativo', 1)->orderBy('nm_lotacao')->get(['id_lotacao', 'nm_lotacao']),
        ]);
    }

    public function update(Request $request, FinContrato $contrato): RedirectResponse
    {
        $validated = $request->validate([
            'nr_contrato' => 'required|string|max:255',
            'id_fornecedor' => 'required|exists:fin_fornecedor,id_fornecedor',
            'id_programa_trabalho' => 'required|exists:fin_programa_trabalho,id_programa_trabalho',
            'id_fonte' => 'required|exists:fin_fonte,id_fonte',
            'id_modalidade' => 'nullable|exists:fin_modalidade,id_modalidade',
            'id_tipo_gasto' => 'required|integer',
            'ds_objeto' => 'required|string',
            'vl_contrato' => 'required|numeric|min:0.01',
            'dt_ini_vigencia_contrato' => 'required|date',
            'dt_fim_vigencia_contrato' => 'required|date|after_or_equal:dt_ini_vigencia_contrato',
            'dt_assinatura' => 'nullable|date',
            'dt_publicacao' => 'nullable|date',
            'tp_contrato' => 'nullable|string|max:50',
            'nr_prazo_entrega' => 'nullable|integer',
            'st_ativo' => 'nullable|integer|in:0,1',
            'ds_obs_contrato' => 'nullable|string',
            'ds_area_abrangencia' => 'nullable|string',
            'ds_unidade_contemplada' => 'nullable|string',
            'fl_servico_continuado' => 'nullable|boolean',
            'fl_carona' => 'nullable|boolean',
            'id_pessoa_gestor_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_gestor_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_fiscal_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_fiscal_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_sub_fiscal_titular' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_pessoa_sub_fiscal_substituto' => 'nullable|exists:ses_pessoa,id_pessoa',
            'id_lotacao_central' => 'nullable|integer',
        ]);

        $fornecedor = FinFornecedor::with('pessoa')->findOrFail($validated['id_fornecedor']);

        $contrato->update([
            'nr_contrato' => $validated['nr_contrato'],
            'id_fornecedor' => $validated['id_fornecedor'],
            'id_pessoa_fornecedor' => $fornecedor->id_pessoa,
            'id_programa_trabalho' => $validated['id_programa_trabalho'],
            'id_fonte' => $validated['id_fonte'],
            'id_modalidade' => $validated['id_modalidade'] ?? null,
            'id_tipo_gasto' => $validated['id_tipo_gasto'],
            'ds_objeto' => $validated['ds_objeto'],
            'vl_contrato' => $validated['vl_contrato'],
            'dt_ini_vigencia_contrato' => $validated['dt_ini_vigencia_contrato'],
            'dt_fim_vigencia_contrato' => $validated['dt_fim_vigencia_contrato'],
            'dt_assinatura' => $validated['dt_assinatura'] ?? null,
            'dt_publicacao' => $validated['dt_publicacao'] ?? null,
            'tp_contrato' => $validated['tp_contrato'] ?? null,
            'nr_prazo_entrega' => $validated['nr_prazo_entrega'] ?? null,
            'st_ativo' => $validated['st_ativo'] ?? $contrato->st_ativo,
            'ds_obs_contrato' => $validated['ds_obs_contrato'] ?? null,
            'ds_area_abrangencia' => $validated['ds_area_abrangencia'] ?? null,
            'ds_unidade_contemplada' => $validated['ds_unidade_contemplada'] ?? null,
            'fl_servico_continuado' => $validated['fl_servico_continuado'] ?? 0,
            'fl_carona' => $validated['fl_carona'] ?? 0,
            'id_pessoa_gestor_titular' => $validated['id_pessoa_gestor_titular'] ?? null,
            'id_pessoa_gestor_substituto' => $validated['id_pessoa_gestor_substituto'] ?? null,
            'id_pessoa_fiscal_titular' => $validated['id_pessoa_fiscal_titular'] ?? null,
            'id_pessoa_fiscal_substituto' => $validated['id_pessoa_fiscal_substituto'] ?? null,
            'id_pessoa_sub_fiscal_titular' => $validated['id_pessoa_sub_fiscal_titular'] ?? null,
            'id_pessoa_sub_fiscal_substituto' => $validated['id_pessoa_sub_fiscal_substituto'] ?? null,
            'id_lotacao_central' => $validated['id_lotacao_central'] ?? null,
        ]);

        return redirect()->route('compras.contratos.show', $contrato->id_contrato)
            ->with('success', 'Contrato atualizado com sucesso.');
    }

    public function destroy(FinContrato $contrato): RedirectResponse
    {
        $contrato->update(['st_ativo' => 0]);

        return redirect()->route('compras.contratos.index')
            ->with('success', 'Contrato desativado com sucesso.');
    }
}
