<?php

namespace App\Http\Controllers;

use App\Models\CentralDemand;
use App\Models\Organization;
use App\Models\PersonalInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CentralDemandController extends Controller
{
    public function index(): Response
    {
        $demands = CentralDemand::with(['personalInfo', 'organization'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/CentralDemands/Index', [
            'demands' => $demands,
        ]);
    }

    public function create(): Response
    {
        $people = PersonalInfo::orderBy('name')->get(['id', 'name']);
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/CentralDemands/Create', [
            'people' => $people,
            'organizations' => $organizations,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'personal_info_id' => 'required|exists:personal_info,id',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        CentralDemand::create($validated);

        return redirect()->route('central-demands.index')
            ->with('success', 'Central de demanda vinculada com sucesso.');
    }

    public function show(CentralDemand $centralDemand): Response
    {
        $centralDemand->load(['personalInfo', 'organization']);

        return Inertia::render('Planning/CentralDemands/Show', [
            'demand' => $centralDemand,
        ]);
    }

    public function edit(CentralDemand $centralDemand): Response
    {
        $centralDemand->load(['personalInfo', 'organization']);
        $people = PersonalInfo::orderBy('name')->get(['id', 'name']);
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/CentralDemands/Edit', [
            'demand' => $centralDemand,
            'people' => $people,
            'organizations' => $organizations,
        ]);
    }

    public function update(Request $request, CentralDemand $centralDemand): RedirectResponse
    {
        $validated = $request->validate([
            'personal_info_id' => 'required|exists:personal_info,id',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $centralDemand->update($validated);

        return redirect()->route('central-demands.index')
            ->with('success', 'Central de demanda atualizada com sucesso.');
    }

    public function destroy(CentralDemand $centralDemand): RedirectResponse
    {
        $centralDemand->delete();

        return redirect()->route('central-demands.index')
            ->with('success', 'Central de demanda removida com sucesso.');
    }
}
