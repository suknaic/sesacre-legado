<?php

namespace App\Http\Controllers;

use App\Models\EmploymentBond;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmploymentBondController extends Controller
{
    public function index(): Response
    {
        $employmentBonds = EmploymentBond::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/EmploymentBonds/Index', [
            'employmentBonds' => $employmentBonds,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/EmploymentBonds/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        EmploymentBond::create($validated);

        return redirect()->route('employment-bonds.index')
            ->with('success', 'Vínculo criado com sucesso.');
    }

    public function show(EmploymentBond $employmentBond): Response
    {
        return Inertia::render('HR/EmploymentBonds/Show', [
            'employmentBond' => $employmentBond,
        ]);
    }

    public function edit(EmploymentBond $employmentBond): Response
    {
        return Inertia::render('HR/EmploymentBonds/Edit', [
            'employmentBond' => $employmentBond,
        ]);
    }

    public function update(Request $request, EmploymentBond $employmentBond): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $employmentBond->update($validated);

        return redirect()->route('employment-bonds.index')
            ->with('success', 'Vínculo atualizado com sucesso.');
    }

    public function destroy(EmploymentBond $employmentBond): RedirectResponse
    {
        $employmentBond->delete();

        return redirect()->route('employment-bonds.index')
            ->with('success', 'Vínculo removido com sucesso.');
    }
}
