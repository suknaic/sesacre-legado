<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use App\Models\ProcurementModality;
use App\Models\ProcurementObject;
use App\Models\ProcurementSituation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProcurementController extends Controller
{
    public function index(): Response
    {
        $procurements = Procurement::with(['modality', 'object', 'situation'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Purchasing/Procurements/Index', [
            'procurements' => $procurements,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Purchasing/Procurements/Create', [
            'modalities' => ProcurementModality::all(),
            'objects' => ProcurementObject::all(),
            'situations' => ProcurementSituation::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ada_code' => 'nullable|string|max:20',
            'auction_code' => 'nullable|string|max:20',
            'estimated_total' => 'nullable|numeric|min:0',
            'adjudicated_total' => 'nullable|numeric|min:0',
            'process_date' => 'nullable|date',
            'procurement_object_id' => 'nullable|exists:procurement_objects,id',
            'procurement_modality_id' => 'nullable|exists:procurement_modalities,id',
            'procurement_situation_id' => 'nullable|exists:procurement_situations,id',
            'year' => 'nullable|integer',
            'technical_manager' => 'nullable|string|max:255',
        ]);

        Procurement::create($validated);

        return redirect()->route('procurements.index')
            ->with('success', 'Processo criado com sucesso.');
    }

    public function show(Procurement $procurement): Response
    {
        $procurement->load(['modality', 'object', 'situation']);

        return Inertia::render('Purchasing/Procurements/Show', [
            'procurement' => $procurement,
        ]);
    }

    public function edit(Procurement $procurement): Response
    {
        return Inertia::render('Purchasing/Procurements/Edit', [
            'procurement' => $procurement,
            'modalities' => ProcurementModality::all(),
            'objects' => ProcurementObject::all(),
            'situations' => ProcurementSituation::all(),
        ]);
    }

    public function update(Request $request, Procurement $procurement): RedirectResponse
    {
        $validated = $request->validate([
            'ada_code' => 'nullable|string|max:20',
            'auction_code' => 'nullable|string|max:20',
            'estimated_total' => 'nullable|numeric|min:0',
            'adjudicated_total' => 'nullable|numeric|min:0',
            'process_date' => 'nullable|date',
            'procurement_object_id' => 'nullable|exists:procurement_objects,id',
            'procurement_modality_id' => 'nullable|exists:procurement_modalities,id',
            'procurement_situation_id' => 'nullable|exists:procurement_situations,id',
            'year' => 'nullable|integer',
            'technical_manager' => 'nullable|string|max:255',
        ]);

        $procurement->update($validated);

        return redirect()->route('procurements.index')
            ->with('success', 'Processo atualizado com sucesso.');
    }

    public function destroy(Procurement $procurement): RedirectResponse
    {
        $procurement->delete();

        return redirect()->route('procurements.index')
            ->with('success', 'Processo removido com sucesso.');
    }
}
