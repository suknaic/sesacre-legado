<?php

namespace App\Http\Controllers;

use App\Models\PesPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PesPlanController extends Controller
{
    public function index(): Response
    {
        $pesPlans = PesPlan::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PesPlans/Index', [
            'pesPlans' => $pesPlans,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/PesPlans/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        PesPlan::create($validated);

        return redirect()->route('pes-plans.index')
            ->with('success', 'PES criado com sucesso.');
    }

    public function show(PesPlan $pesPlan): Response
    {
        return Inertia::render('Planning/PesPlans/Show', [
            'pesPlan' => $pesPlan,
        ]);
    }

    public function edit(PesPlan $pesPlan): Response
    {
        return Inertia::render('Planning/PesPlans/Edit', [
            'pesPlan' => $pesPlan,
        ]);
    }

    public function update(Request $request, PesPlan $pesPlan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2200',
            'end_year' => 'required|integer|min:1900|max:2200|gte:start_year',
            'is_active' => 'boolean',
        ]);

        $pesPlan->update($validated);

        return redirect()->route('pes-plans.index')
            ->with('success', 'PES atualizado com sucesso.');
    }

    public function destroy(PesPlan $pesPlan): RedirectResponse
    {
        $pesPlan->delete();

        return redirect()->route('pes-plans.index')
            ->with('success', 'PES removido com sucesso.');
    }
}
