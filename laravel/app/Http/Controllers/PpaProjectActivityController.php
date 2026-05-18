<?php

namespace App\Http\Controllers;

use App\Models\PpaProjectActivity;
use App\Models\StrategicPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PpaProjectActivityController extends Controller
{
    public function index(Request $request): Response
    {
        $strategicPlanId = $request->get('strategic_plan_id');

        $items = PpaProjectActivity::with('strategicPlan')
            ->when($strategicPlanId, fn ($q, $v) => $q->where('strategic_plan_id', $v))
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/PpaProjectActivities/Index', [
            'items' => $items,
            'strategicPlans' => StrategicPlan::orderBy('name')->get(),
            'filters' => ['strategic_plan_id' => $strategicPlanId],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Planning/PpaProjectActivities/Create', [
            'strategicPlans' => StrategicPlan::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'strategic_plan_id' => 'required|exists:strategic_plans,id',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|in:P,A',
            'is_active' => 'boolean',
        ]);

        PpaProjectActivity::create($validated);

        return redirect()->route('ppa-project-activities.index')
            ->with('success', 'Projeto/Atividade criado com sucesso.');
    }

    public function show(PpaProjectActivity $ppaProjectActivity): Response
    {
        $ppaProjectActivity->load('strategicPlan');

        return Inertia::render('Planning/PpaProjectActivities/Show', [
            'ppaProjectActivity' => $ppaProjectActivity,
        ]);
    }

    public function edit(PpaProjectActivity $ppaProjectActivity): Response
    {
        $ppaProjectActivity->load('strategicPlan');

        return Inertia::render('Planning/PpaProjectActivities/Edit', [
            'ppaProjectActivity' => $ppaProjectActivity,
            'strategicPlans' => StrategicPlan::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, PpaProjectActivity $ppaProjectActivity): RedirectResponse
    {
        $validated = $request->validate([
            'strategic_plan_id' => 'required|exists:strategic_plans,id',
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'type' => 'required|in:P,A',
            'is_active' => 'boolean',
        ]);

        $ppaProjectActivity->update($validated);

        return redirect()->route('ppa-project-activities.index')
            ->with('success', 'Projeto/Atividade atualizado com sucesso.');
    }

    public function destroy(PpaProjectActivity $ppaProjectActivity): RedirectResponse
    {
        $ppaProjectActivity->delete();

        return redirect()->route('ppa-project-activities.index')
            ->with('success', 'Projeto/Atividade removido com sucesso.');
    }
}
