<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\OrganizationCategory;
use App\Models\OrganizationDetail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationDetailController extends Controller
{
    public function index(): Response
    {
        $details = OrganizationDetail::with(['parent', 'category', 'city', 'manager'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/OrganizationDetails/Index', [
            'details' => $details,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/OrganizationDetails/Create', $this->getFormOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:organization_details,id',
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
            'manager_id' => 'nullable|exists:users,id',
            'is_principal' => 'boolean',
            'is_active' => 'boolean',
        ]);

        OrganizationDetail::create($validated);

        return redirect()->route('organization-details.index')
            ->with('success', 'Detalhe de organização criado com sucesso.');
    }

    public function show(OrganizationDetail $organizationDetail): Response
    {
        $organizationDetail->load(['parent', 'category', 'city', 'manager']);

        return Inertia::render('HR/OrganizationDetails/Show', [
            'organizationDetail' => $organizationDetail,
        ]);
    }

    public function edit(OrganizationDetail $organizationDetail): Response
    {
        return Inertia::render('HR/OrganizationDetails/Edit', array_merge(
            ['organizationDetail' => $organizationDetail],
            $this->getFormOptions()
        ));
    }

    public function update(Request $request, OrganizationDetail $organizationDetail): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:organization_details,id',
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
            'manager_id' => 'nullable|exists:users,id',
            'is_principal' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $organizationDetail->update($validated);

        return redirect()->route('organization-details.index')
            ->with('success', 'Detalhe de organização atualizado com sucesso.');
    }

    public function destroy(OrganizationDetail $organizationDetail): RedirectResponse
    {
        $organizationDetail->delete();

        return redirect()->route('organization-details.index')
            ->with('success', 'Detalhe de organização removido com sucesso.');
    }

    private function getFormOptions(): array
    {
        return [
            'parents' => OrganizationDetail::whereNull('parent_id')->get(),
            'categories' => OrganizationCategory::all(),
            'cities' => City::all(),
            'managers' => User::all(),
        ];
    }
}
