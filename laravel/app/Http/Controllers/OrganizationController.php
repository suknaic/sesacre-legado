<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationController extends Controller
{
    public function index(): Response
    {
        $organizations = Organization::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Administration/Organizations/Index', [
            'organizations' => $organizations,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Administration/Organizations/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:organizations,id',
            'category_id' => 'nullable|exists:organization_categories,id',
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string',
            'neighborhood' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'manager_id' => 'nullable|integer',
            'is_principal' => 'boolean',
            'is_active' => 'boolean',
        ]);

        Organization::create($validated);

        return redirect()->route('organizations.index')
            ->with('success', 'Organização criada com sucesso.');
    }

    public function show(Organization $organization): Response
    {
        return Inertia::render('Administration/Organizations/Show', [
            'organization' => $organization,
        ]);
    }

    public function edit(Organization $organization): Response
    {
        return Inertia::render('Administration/Organizations/Edit', [
            'organization' => $organization,
        ]);
    }

    public function update(Request $request, Organization $organization): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:organizations,id',
            'category_id' => 'nullable|exists:organization_categories,id',
            'name' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'city_id' => 'nullable|exists:cities,id',
            'address' => 'nullable|string',
            'neighborhood' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:10',
            'email' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'manager_id' => 'nullable|integer',
            'is_principal' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $organization->update($validated);

        return redirect()->route('organizations.index')
            ->with('success', 'Organização atualizada com sucesso.');
    }

    public function destroy(Organization $organization): RedirectResponse
    {
        $organization->delete();

        return redirect()->route('organizations.index')
            ->with('success', 'Organização removida com sucesso.');
    }
}
