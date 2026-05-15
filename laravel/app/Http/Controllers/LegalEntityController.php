<?php

namespace App\Http\Controllers;

use App\Models\LegalEntity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LegalEntityController extends Controller
{
    public function index(): Response
    {
        $legalEntities = LegalEntity::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Administration/LegalEntities/Index', [
            'legalEntities' => $legalEntities,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Administration/LegalEntities/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        LegalEntity::create($validated);

        return redirect()->route('legal-entities.index')
            ->with('success', 'Pessoa jurídica criada com sucesso.');
    }

    public function show(LegalEntity $legalEntity): Response
    {
        return Inertia::render('Administration/LegalEntities/Show', [
            'legalEntity' => $legalEntity,
        ]);
    }

    public function edit(LegalEntity $legalEntity): Response
    {
        return Inertia::render('Administration/LegalEntities/Edit', [
            'legalEntity' => $legalEntity,
        ]);
    }

    public function update(Request $request, LegalEntity $legalEntity): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $legalEntity->update($validated);

        return redirect()->route('legal-entities.index')
            ->with('success', 'Pessoa jurídica atualizada com sucesso.');
    }

    public function destroy(LegalEntity $legalEntity): RedirectResponse
    {
        $legalEntity->delete();

        return redirect()->route('legal-entities.index')
            ->with('success', 'Pessoa jurídica removida com sucesso.');
    }
}
