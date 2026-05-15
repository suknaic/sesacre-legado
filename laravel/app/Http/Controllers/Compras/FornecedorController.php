<?php

namespace App\Http\Controllers\Compras;

use App\Http\Controllers\Controller;
use App\Models\FinFornecedor;
use App\Models\ForMaterialConsumo;
use App\Models\ForMaterialPermanente;
use App\Models\ForMedicamento;
use App\Models\ForServico;
use App\Models\SesPessoa;
use App\Models\SesPessoaFisica;
use App\Models\SesPessoaJuridica;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FornecedorController extends Controller
{
    public function index(Request $request): Response
    {
        $query = FinFornecedor::with(['pessoa', 'pessoaFisica', 'pessoaJuridica']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pessoa', function ($q) use ($search) {
                $q->where('nm_pessoa', 'ilike', "%{$search}%")
                    ->orWhere('nr_telefone_celular', 'ilike', "%{$search}%")
                    ->orWhere('nm_email', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('sit_fornecedor')) {
            $query->where('sit_fornecedor', $request->sit_fornecedor);
        }

        $fornecedores = $query->orderBy('id_fornecedor', 'desc')
            ->paginate(15)
            ->through(function ($f) {
                $f->documento = $this->getDocumento($f);
                $f->situacao_label = $f->sit_fornecedor == 1 ? 'Ativo' : 'Inativo';

                return $f;
            });

        return Inertia::render('Compras/Fornecedor/Index', [
            'fornecedores' => $fornecedores,
            'filters' => $request->only(['search', 'sit_fornecedor']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Compras/Fornecedor/Create', [
            'medicamentos' => ForMedicamento::orderBy('nm_medicamento')->get(),
            'servicos' => ForServico::orderBy('nm_servico')->get(),
            'materiaisConsumo' => ForMaterialConsumo::orderBy('nm_material_consumo')->get(),
            'materiaisPermanente' => ForMaterialPermanente::orderBy('nm_material_permanente')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_pessoa' => 'required|string|max:255',
            'nr_cpf_cnpj' => 'required|string|max:20',
            'nr_telefone_celular' => 'nullable|string|max:20',
            'nm_email' => 'nullable|email|max:255',
            'ds_logradouro' => 'nullable|string|max:255',
            'ds_bairro' => 'nullable|string|max:255',
            'nr_cep' => 'nullable|string|max:10',
            'id_cidade' => 'nullable|integer',
            'medicamentos' => 'nullable|array',
            'medicamentos.*' => 'integer|exists:for_medicamento,id_medicamento',
            'servicos' => 'nullable|array',
            'servicos.*' => 'integer|exists:for_servico,id_servico',
            'materiais_consumo' => 'nullable|array',
            'materiais_consumo.*' => 'integer|exists:for_material_consumo,id_material_consumo',
            'materiais_permanente' => 'nullable|array',
            'materiais_permanente.*' => 'integer|exists:for_material_permanente,id_material_permanente',
        ], [
            'nm_pessoa.required' => 'O nome é obrigatório.',
            'nr_cpf_cnpj.required' => 'O CPF/CNPJ é obrigatório.',
        ]);

        $documento = preg_replace('/\D/', '', $validated['nr_cpf_cnpj']);

        $pessoa = SesPessoa::create([
            'nm_pessoa' => $validated['nm_pessoa'],
            'nr_telefone_celular' => $validated['nr_telefone_celular'] ?? null,
            'nm_email' => $validated['nm_email'] ?? null,
            'ds_logradouro' => $validated['ds_logradouro'] ?? null,
            'ds_bairro' => $validated['ds_bairro'] ?? null,
            'nr_cep' => $validated['nr_cep'] ?? null,
            'id_cidade' => $validated['id_cidade'] ?? null,
        ]);

        if (strlen($documento) === 11) {
            SesPessoaFisica::create([
                'id_pessoa' => $pessoa->id_pessoa,
                'nr_cpf' => $documento,
            ]);
        } elseif (strlen($documento) === 14) {
            SesPessoaJuridica::create([
                'id_pessoa' => $pessoa->id_pessoa,
                'nr_cnpj' => $documento,
            ]);
        }

        $fornecedor = FinFornecedor::create([
            'id_pessoa' => $pessoa->id_pessoa,
            'sit_fornecedor' => 1,
        ]);

        if ($request->has('medicamentos')) {
            $fornecedor->medicamentos()->sync($validated['medicamentos']);
        }

        if ($request->has('servicos')) {
            $fornecedor->servicos()->sync($validated['servicos']);
        }

        if ($request->has('materiais_consumo')) {
            $fornecedor->materiaisConsumo()->sync($validated['materiais_consumo']);
        }

        if ($request->has('materiais_permanente')) {
            $fornecedor->materiaisPermanente()->sync($validated['materiais_permanente']);
        }

        return redirect()->route('compras.fornecedores.show', $fornecedor->id_fornecedor)
            ->with('success', 'Fornecedor cadastrado com sucesso.');
    }

    public function show(FinFornecedor $fornecedor): Response
    {
        $fornecedor->load([
            'pessoa',
            'pessoaFisica',
            'pessoaJuridica',
            'contrato',
            'medicamentos',
            'servicos',
            'materiaisConsumo',
            'materiaisPermanente',
        ]);

        $fornecedor->documento = $this->getDocumento($fornecedor);

        return Inertia::render('Compras/Fornecedor/Show', [
            'fornecedor' => $fornecedor,
        ]);
    }

    public function edit(FinFornecedor $fornecedor): Response
    {
        $fornecedor->load([
            'pessoa',
            'pessoaFisica',
            'pessoaJuridica',
            'medicamentos',
            'servicos',
            'materiaisConsumo',
            'materiaisPermanente',
        ]);

        $fornecedor->documento = $this->getDocumento($fornecedor);
        $fornecedor->documento_raw = $fornecedor->pessoaFisica?->nr_cpf ?? $fornecedor->pessoaJuridica?->nr_cnpj ?? '';

        return Inertia::render('Compras/Fornecedor/Edit', [
            'fornecedor' => $fornecedor,
            'medicamentos' => ForMedicamento::orderBy('nm_medicamento')->get(),
            'servicos' => ForServico::orderBy('nm_servico')->get(),
            'materiaisConsumo' => ForMaterialConsumo::orderBy('nm_material_consumo')->get(),
            'materiaisPermanente' => ForMaterialPermanente::orderBy('nm_material_permanente')->get(),
        ]);
    }

    public function update(Request $request, FinFornecedor $fornecedor): RedirectResponse
    {
        $validated = $request->validate([
            'nm_pessoa' => 'required|string|max:255',
            'nr_cpf_cnpj' => 'required|string|max:20',
            'nr_telefone_celular' => 'nullable|string|max:20',
            'nm_email' => 'nullable|email|max:255',
            'ds_logradouro' => 'nullable|string|max:255',
            'ds_bairro' => 'nullable|string|max:255',
            'nr_cep' => 'nullable|string|max:10',
            'id_cidade' => 'nullable|integer',
            'sit_fornecedor' => 'nullable|integer|in:0,1',
            'medicamentos' => 'nullable|array',
            'medicamentos.*' => 'integer|exists:for_medicamento,id_medicamento',
            'servicos' => 'nullable|array',
            'servicos.*' => 'integer|exists:for_servico,id_servico',
            'materiais_consumo' => 'nullable|array',
            'materiais_consumo.*' => 'integer|exists:for_material_consumo,id_material_consumo',
            'materiais_permanente' => 'nullable|array',
            'materiais_permanente.*' => 'integer|exists:for_material_permanente,id_material_permanente',
        ]);

        $pessoa = $fornecedor->pessoa;
        if ($pessoa) {
            $pessoa->update([
                'nm_pessoa' => $validated['nm_pessoa'],
                'nr_telefone_celular' => $validated['nr_telefone_celular'] ?? null,
                'nm_email' => $validated['nm_email'] ?? null,
                'ds_logradouro' => $validated['ds_logradouro'] ?? null,
                'ds_bairro' => $validated['ds_bairro'] ?? null,
                'nr_cep' => $validated['nr_cep'] ?? null,
                'id_cidade' => $validated['id_cidade'] ?? null,
            ]);
        }

        $documento = preg_replace('/\D/', '', $validated['nr_cpf_cnpj']);
        if (strlen($documento) === 11) {
            $fisica = $fornecedor->pessoaFisica;
            if ($fisica) {
                $fisica->update(['nr_cpf' => $documento]);
            } else {
                SesPessoaFisica::create([
                    'id_pessoa' => $pessoa->id_pessoa,
                    'nr_cpf' => $documento,
                ]);
            }
            if ($fornecedor->pessoaJuridica) {
                $fornecedor->pessoaJuridica->delete();
            }
        } elseif (strlen($documento) === 14) {
            $juridica = $fornecedor->pessoaJuridica;
            if ($juridica) {
                $juridica->update(['nr_cnpj' => $documento]);
            } else {
                SesPessoaJuridica::create([
                    'id_pessoa' => $pessoa->id_pessoa,
                    'nr_cnpj' => $documento,
                ]);
            }
            if ($fornecedor->pessoaFisica) {
                $fornecedor->pessoaFisica->delete();
            }
        }

        if ($request->has('sit_fornecedor')) {
            $fornecedor->update(['sit_fornecedor' => $validated['sit_fornecedor']]);
        }

        if ($request->has('medicamentos')) {
            $fornecedor->medicamentos()->sync($validated['medicamentos']);
        }

        if ($request->has('servicos')) {
            $fornecedor->servicos()->sync($validated['servicos']);
        }

        if ($request->has('materiais_consumo')) {
            $fornecedor->materiaisConsumo()->sync($validated['materiais_consumo']);
        }

        if ($request->has('materiais_permanente')) {
            $fornecedor->materiaisPermanente()->sync($validated['materiais_permanente']);
        }

        return redirect()->route('compras.fornecedores.show', $fornecedor->id_fornecedor)
            ->with('success', 'Fornecedor atualizado com sucesso.');
    }

    public function destroy(FinFornecedor $fornecedor): RedirectResponse
    {
        if ($fornecedor->pedidos()->count() > 0) {
            return back()->with('error', 'Não é possível excluir fornecedor com pedidos vinculados.');
        }

        $fornecedor->update(['sit_fornecedor' => 0]);

        return redirect()->route('compras.fornecedores.index')
            ->with('success', 'Fornecedor desativado com sucesso.');
    }

    private function getDocumento(FinFornecedor $fornecedor): string
    {
        $documento = '';
        if ($fornecedor->relationLoaded('pessoaFisica') && $fornecedor->pessoaFisica) {
            $documento = $fornecedor->pessoaFisica->nr_cpf ?? '';
        } elseif ($fornecedor->relationLoaded('pessoaJuridica') && $fornecedor->pessoaJuridica) {
            $documento = $fornecedor->pessoaJuridica->nr_cnpj ?? '';
        }

        if (empty($documento)) {
            $documento = $fornecedor->pessoaFisica?->nr_cpf ?? $fornecedor->pessoaJuridica?->nr_cnpj ?? '';
        }

        return $this->formatDocument($documento);
    }

    private function formatDocument(string $documento): string
    {
        $digits = preg_replace('/\D/', '', $documento);
        if (strlen($digits) === 11) {
            return substr($digits, 0, 3).'.'.substr($digits, 3, 3).'.'.substr($digits, 6, 3).'-'.substr($digits, 9, 2);
        }
        if (strlen($digits) === 14) {
            return substr($digits, 0, 2).'.'.substr($digits, 2, 3).'.'.substr($digits, 5, 3).'/'.substr($digits, 8, 4).'-'.substr($digits, 12, 2);
        }

        return $documento;
    }
}
