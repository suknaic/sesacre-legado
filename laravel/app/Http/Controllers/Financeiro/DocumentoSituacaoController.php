<?php

namespace App\Http\Controllers\Financeiro;

use App\Http\Controllers\Controller;
use App\Models\FinDocumentoSituacao;
use Inertia\Inertia;
use Inertia\Response;

class DocumentoSituacaoController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Financeiro/DocumentoSituacao/Index', [
            'situacoes' => FinDocumentoSituacao::orderBy('id_documento_situacao')->paginate(15),
        ]);
    }

    public function show(int $id): Response
    {
        $situacao = FinDocumentoSituacao::findOrFail($id);

        return Inertia::render('Financeiro/DocumentoSituacao/Show', [
            'situacao' => $situacao,
        ]);
    }
}
