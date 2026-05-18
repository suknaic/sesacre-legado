<?php

namespace App\Http\Controllers;

use App\Models\ContractSituation;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\Organization;
use App\Models\RecruitmentHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FeriasLicencasController extends Controller
{
    public function index(): Response
    {
        $search = request('search');
        $contractSituationId = request('contract_situation_id');
        $dateStart = request('date_start');
        $dateEnd = request('date_end');
        $contractId = request('employment_contract_id');

        $history = RecruitmentHistory::query()
            ->with([
                'employmentContract.personalInfo.user',
                'contractSituation',
                'organization',
                'jobFunction',
            ])
            ->when($search, function ($q, $search) {
                $q->whereHas('employmentContract.personalInfo.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            })
            ->when($contractSituationId, function ($q, $id) {
                $q->where('contract_situation_id', $id);
            })
            ->when($dateStart, function ($q, $date) {
                $q->where(function ($q) use ($date) {
                    $q->whereNull('end_date')
                        ->orWhereDate('end_date', '>=', $date);
                });
            })
            ->when($dateEnd, function ($q, $date) {
                $q->whereDate('start_date', '<=', $date);
            })
            ->when($contractId, function ($q, $id) {
                $q->where('employment_contract_id', $id);
            })
            ->orderBy('history_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('HR/FeriasLicencas/Index', [
            'history' => $history,
            'contractSituations' => ContractSituation::all(),
            'filters' => request()->only(['search', 'contract_situation_id', 'date_start', 'date_end', 'employment_contract_id']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/FeriasLicencas/Create', $this->getFormOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employment_contract_id' => 'required|exists:employment_contracts,id',
            'contract_situation_id' => 'nullable|exists:contract_situations,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'job_function_id' => 'nullable|exists:job_functions,id',
            'history_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observation' => 'nullable|string',
        ], [
            'employment_contract_id.required' => 'O contrato é obrigatório.',
            'history_date.required' => 'A data do histórico é obrigatória.',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início.',
        ]);

        RecruitmentHistory::create($validated);

        return redirect()->route('ferias-licencas.index')
            ->with('success', 'Registro cadastrado com sucesso.');
    }

    public function show(RecruitmentHistory $recruitmentHistory): Response
    {
        $recruitmentHistory->load([
            'employmentContract.personalInfo.user',
            'employmentContract.employmentBond',
            'employmentContract.jobPosition',
            'contractSituation',
            'organization',
            'jobFunction',
        ]);

        return Inertia::render('HR/FeriasLicencas/Show', [
            'recruitmentHistory' => $recruitmentHistory,
        ]);
    }

    public function edit(RecruitmentHistory $recruitmentHistory): Response
    {
        $recruitmentHistory->load(['employmentContract.personalInfo.user']);

        return Inertia::render('HR/FeriasLicencas/Edit', array_merge(
            ['recruitmentHistory' => $recruitmentHistory],
            $this->getFormOptions()
        ));
    }

    public function update(Request $request, RecruitmentHistory $recruitmentHistory): RedirectResponse
    {
        $validated = $request->validate([
            'contract_situation_id' => 'nullable|exists:contract_situations,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'job_function_id' => 'nullable|exists:job_functions,id',
            'history_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observation' => 'nullable|string',
        ]);

        $recruitmentHistory->update($validated);

        return redirect()->route('ferias-licencas.index')
            ->with('success', 'Registro atualizado com sucesso.');
    }

    public function destroy(RecruitmentHistory $recruitmentHistory): RedirectResponse
    {
        $recruitmentHistory->delete();

        return redirect()->route('ferias-licencas.index')
            ->with('success', 'Registro removido com sucesso.');
    }

    private function getFormOptions(): array
    {
        return [
            'employmentContracts' => EmploymentContract::with('personalInfo.user')
                ->whereHas('personalInfo.user')->get()
                ->map(fn ($c) => ['id' => $c->id, 'name' => $c->personalInfo->user->name.' ('.($c->registration_number ?: '#'.$c->id).')']),
            'contractSituations' => ContractSituation::all(),
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
        ];
    }
}
