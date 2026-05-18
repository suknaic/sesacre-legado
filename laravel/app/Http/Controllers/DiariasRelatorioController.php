<?php

namespace App\Http\Controllers;

use App\Models\DecreeType;
use App\Models\PerDiemRequest;
use App\Models\TravelType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiariasRelatorioController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Diarias/Relatorios/Index', [
            'travelTypes' => TravelType::all(),
            'decreeTypes' => DecreeType::all(),
        ]);
    }

    public function gerar(Request $request): Response
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'travel_type_id' => 'nullable|exists:travel_types,id',
            'decree_type_id' => 'nullable|exists:decree_types,id',
            'stage' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $query = PerDiemRequest::with(['travelType', 'transportType', 'decreeType', 'travelClass']);

        if (!empty($validated['date_from'])) {
            $query->whereDate('created_at', '>=', $validated['date_from']);
        }
        if (!empty($validated['date_to'])) {
            $query->whereDate('created_at', '<=', $validated['date_to']);
        }
        if (!empty($validated['travel_type_id'])) {
            $query->where('travel_type_id', $validated['travel_type_id']);
        }
        if (!empty($validated['decree_type_id'])) {
            $query->where('decree_type_id', $validated['decree_type_id']);
        }
        if (isset($validated['stage'])) {
            $query->where('stage', $validated['stage']);
        }
        if (isset($validated['is_active'])) {
            $query->where('is_active', $validated['is_active']);
        }

        $results = $query->orderBy('created_at', 'desc')->get();

        return Inertia::render('Diarias/Relatorios/Index', [
            'results' => $results,
            'filters' => $validated,
            'travelTypes' => TravelType::all(),
            'decreeTypes' => DecreeType::all(),
        ]);
    }
}
