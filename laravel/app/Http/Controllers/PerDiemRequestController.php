<?php

namespace App\Http\Controllers;

use App\Models\DecreeType;
use App\Models\PerDiemRequest;
use App\Models\TransportType;
use App\Models\TravelClass;
use App\Models\TravelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PerDiemRequestController extends Controller
{
    public function index(): Response
    {
        $perDiemRequests = PerDiemRequest::with(['travelType'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Diarias/PerDiemRequests/Index', [
            'perDiemRequests' => $perDiemRequests,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Diarias/PerDiemRequests/Create', [
            'travelTypes' => TravelType::all(),
            'transportTypes' => TransportType::where('is_active', true)->get(),
            'decreeTypes' => DecreeType::where('is_active', true)->get(),
            'travelClasses' => TravelClass::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'travel_type_id' => 'nullable|exists:travel_types,id',
            'transport_type_id' => 'nullable|exists:transport_types,id',
            'decree_type_id' => 'nullable|exists:decree_types,id',
            'travel_class_id' => 'nullable|exists:travel_classes,id',
            'applicant_person_id' => 'nullable|integer',
            'service_description' => 'nullable|string',
            'locations' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PerDiemRequest::create($validated);

        return redirect()->route('per-diem-requests.index')
            ->with('success', 'Solicitação de diária criada com sucesso.');
    }

    public function show(PerDiemRequest $perDiemRequest): Response
    {
        $perDiemRequest->load(['travelType', 'transportType', 'decreeType', 'travelClass']);

        return Inertia::render('Diarias/PerDiemRequests/Show', [
            'perDiemRequest' => $perDiemRequest,
        ]);
    }

    public function edit(PerDiemRequest $perDiemRequest): Response
    {
        return Inertia::render('Diarias/PerDiemRequests/Edit', [
            'perDiemRequest' => $perDiemRequest,
            'travelTypes' => TravelType::all(),
            'transportTypes' => TransportType::where('is_active', true)->get(),
            'decreeTypes' => DecreeType::where('is_active', true)->get(),
            'travelClasses' => TravelClass::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, PerDiemRequest $perDiemRequest): RedirectResponse
    {
        $validated = $request->validate([
            'travel_type_id' => 'nullable|exists:travel_types,id',
            'transport_type_id' => 'nullable|exists:transport_types,id',
            'decree_type_id' => 'nullable|exists:decree_types,id',
            'travel_class_id' => 'nullable|exists:travel_classes,id',
            'applicant_person_id' => 'nullable|integer',
            'service_description' => 'nullable|string',
            'locations' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $perDiemRequest->update($validated);

        return redirect()->route('per-diem-requests.index')
            ->with('success', 'Solicitação de diária atualizada com sucesso.');
    }

    public function destroy(PerDiemRequest $perDiemRequest): RedirectResponse
    {
        $perDiemRequest->delete();

        return redirect()->route('per-diem-requests.index')
            ->with('success', 'Solicitação de diária removida com sucesso.');
    }
}
