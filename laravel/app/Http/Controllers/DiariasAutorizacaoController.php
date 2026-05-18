<?php

namespace App\Http\Controllers;

use App\Models\PerDiemRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiariasAutorizacaoController extends Controller
{
    public function index(): Response
    {
        $pending = PerDiemRequest::with(['travelType', 'transportType', 'decreeType', 'travelClass'])
            ->where(function ($q) {
                $q->whereNull('stage')->orWhere('stage', '<', 5);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Diarias/Autorizacoes/Index', [
            'pending' => $pending,
        ]);
    }

    public function approve(PerDiemRequest $perDiemRequest): RedirectResponse
    {
        $nextStage = min(($perDiemRequest->stage ?? 1) + 1, 5);
        $perDiemRequest->update(['stage' => $nextStage]);

        return redirect()->route('diarias-autorizacoes.index')
            ->with('success', "Solicitação #{$perDiemRequest->id} avançou para etapa {$nextStage}.");
    }

    public function reject(PerDiemRequest $perDiemRequest): RedirectResponse
    {
        $perDiemRequest->update(['stage' => -1]);

        return redirect()->route('diarias-autorizacoes.index')
            ->with('success', "Solicitação #{$perDiemRequest->id} rejeitada.");
    }

    public function reset(PerDiemRequest $perDiemRequest): RedirectResponse
    {
        $perDiemRequest->update(['stage' => 1]);

        return redirect()->route('diarias-autorizacoes.index')
            ->with('success', "Solicitação #{$perDiemRequest->id} retornada para etapa 1.");
    }
}
