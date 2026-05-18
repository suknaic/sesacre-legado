<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\PasResponsible;
use App\Models\PersonalInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PasResponsibleController extends Controller
{
    public function index(): Response
    {
        $responsibles = PasResponsible::with(['personalInfo', 'organization'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PasResponsibles/Index', [
            'responsibles' => $responsibles,
        ]);
    }

    public function create(): Response
    {
        $people = PersonalInfo::orderBy('name')->get(['id', 'name']);
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasResponsibles/Create', [
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

        PasResponsible::create($validated);

        return redirect()->route('pas-responsibles.index')
            ->with('success', 'Responsável PAS vinculado com sucesso.');
    }

    public function show(PasResponsible $pasResponsible): Response
    {
        $pasResponsible->load(['personalInfo', 'organization']);

        return Inertia::render('Planning/PasResponsibles/Show', [
            'responsible' => $pasResponsible,
        ]);
    }

    public function edit(PasResponsible $pasResponsible): Response
    {
        $pasResponsible->load(['personalInfo', 'organization']);
        $people = PersonalInfo::orderBy('name')->get(['id', 'name']);
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/PasResponsibles/Edit', [
            'responsible' => $pasResponsible,
            'people' => $people,
            'organizations' => $organizations,
        ]);
    }

    public function update(Request $request, PasResponsible $pasResponsible): RedirectResponse
    {
        $validated = $request->validate([
            'personal_info_id' => 'required|exists:personal_info,id',
            'organization_id' => 'required|exists:organizations,id',
        ]);

        $pasResponsible->update($validated);

        return redirect()->route('pas-responsibles.index')
            ->with('success', 'Responsável PAS atualizado com sucesso.');
    }

    public function destroy(PasResponsible $pasResponsible): RedirectResponse
    {
        $pasResponsible->delete();

        return redirect()->route('pas-responsibles.index')
            ->with('success', 'Responsável PAS removido com sucesso.');
    }
}
