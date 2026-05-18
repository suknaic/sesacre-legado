<?php

namespace App\Http\Controllers;

use App\Models\BudgetSourceRelease;
use App\Models\FinFonte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BudgetSourceReleaseController extends Controller
{
    public function index(): Response
    {
        $releases = BudgetSourceRelease::orderBy('year', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/BudgetSourceReleases/Index', [
            'releases' => $releases,
        ]);
    }

    public function create(): Response
    {
        try {
            $fontes = FinFonte::orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);
        } catch (\Exception $e) {
            $fontes = [];
        }

        return Inertia::render('Planning/BudgetSourceReleases/Create', [
            'fontes' => $fontes,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fonte_id' => 'required|integer',
            'year' => 'required|integer|min:1900|max:2200',
            'total_amount' => 'required|numeric|min:0',
        ]);

        BudgetSourceRelease::create($validated);

        return redirect()->route('budget-source-releases.index')
            ->with('success', 'Liberação de fonte criada com sucesso.');
    }

    public function show(BudgetSourceRelease $budgetSourceRelease): Response
    {
        return Inertia::render('Planning/BudgetSourceReleases/Show', [
            'release' => $budgetSourceRelease,
        ]);
    }

    public function edit(BudgetSourceRelease $budgetSourceRelease): Response
    {
        try {
            $fontes = FinFonte::orderBy('nr_fonte')->get(['id_fonte', 'nr_fonte']);
        } catch (\Exception $e) {
            $fontes = [];
        }

        return Inertia::render('Planning/BudgetSourceReleases/Edit', [
            'release' => $budgetSourceRelease,
            'fontes' => $fontes,
        ]);
    }

    public function update(Request $request, BudgetSourceRelease $budgetSourceRelease): RedirectResponse
    {
        $validated = $request->validate([
            'fonte_id' => 'required|integer',
            'year' => 'required|integer|min:1900|max:2200',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $budgetSourceRelease->update($validated);

        return redirect()->route('budget-source-releases.index')
            ->with('success', 'Liberação de fonte atualizada com sucesso.');
    }

    public function destroy(BudgetSourceRelease $budgetSourceRelease): RedirectResponse
    {
        $budgetSourceRelease->delete();

        return redirect()->route('budget-source-releases.index')
            ->with('success', 'Liberação de fonte removida com sucesso.');
    }
}
