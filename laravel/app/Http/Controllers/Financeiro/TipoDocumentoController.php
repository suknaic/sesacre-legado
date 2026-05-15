<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinTipoDocumento;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TipoDocumentoController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Financeiro/TipoDocumento/Index', [
            'tipos' => FinTipoDocumento::orderBy('nm_tipo_documento')->paginate(15),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financeiro/TipoDocumento/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nm_tipo_documento' => 'required|string|max:100|unique:fin_tipo_documento,nm_tipo_documento',
            'ds_tipo_documento' => 'nullable|string',
            'st_tipo_documento' => 'nullable|boolean',
        ], [
            'nm_tipo_documento.required' => 'O nome do tipo de documento é obrigatório.',
            'nm_tipo_documento.unique' => 'Este tipo de documento já existe.',
        ]);

        FinTipoDocumento::create([
            'nm_tipo_documento' => $validated['nm_tipo_documento'],
            'ds_tipo_documento' => $validated['ds_tipo_documento'] ?? null,
            'st_tipo_documento' => $validated['st_tipo_documento'] ?? 1,
        ]);

        return redirect()->route('financeiro.tipos-documento.index')
            ->with('success', 'Tipo de documento cadastrado com sucesso.');
    }

    public function show(FinTipoDocumento $tipoDocumento): Response
    {
        return Inertia::render('Financeiro/TipoDocumento/Show', [
            'tipo' => $tipoDocumento,
        ]);
    }

    public function edit(FinTipoDocumento $tipoDocumento): Response
    {
        return Inertia::render('Financeiro/TipoDocumento/Edit', [
            'tipo' => $tipoDocumento,
        ]);
    }

    public function update(Request $request, FinTipoDocumento $tipoDocumento): RedirectResponse
    {
        $validated = $request->validate([
            'nm_tipo_documento' => 'required|string|max:100|unique:fin_tipo_documento,nm_tipo_documento,'.$tipoDocumento->id_tipo_documento.',id_tipo_documento',
            'ds_tipo_documento' => 'nullable|string',
            'st_tipo_documento' => 'nullable|boolean',
        ]);

        $tipoDocumento->update($validated);

        return redirect()->route('financeiro.tipos-documento.index')
            ->with('success', 'Tipo de documento atualizado com sucesso.');
    }

    public function destroy(FinTipoDocumento $tipoDocumento): RedirectResponse
    {
        if ($tipoDocumento->documentosFiscais()->count() > 0) {
            return back()->with('error', 'Este tipo de documento possui vínculos e não pode ser removido.');
        }

        $tipoDocumento->delete();

        return redirect()->route('financeiro.tipos-documento.index')
            ->with('success', 'Tipo de documento removido com sucesso.');
    }
}
