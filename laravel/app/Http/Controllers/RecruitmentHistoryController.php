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

class RecruitmentHistoryController extends Controller
{
    public function index(EmploymentContract $employmentContract): Response
    {
        $history = $employmentContract->recruitmentHistory()
            ->with(['contractSituation', 'organization', 'jobFunction'])
            ->orderBy('history_date', 'desc')
            ->get();

        return Inertia::render('HR/RecruitmentHistory/Index', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'history' => $history,
        ]);
    }

    public function create(EmploymentContract $employmentContract): Response
    {
        return Inertia::render('HR/RecruitmentHistory/Create', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'contractSituations' => ContractSituation::all(),
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
        ]);
    }

    public function store(Request $request, EmploymentContract $employmentContract): RedirectResponse
    {
        $validated = $request->validate([
            'contract_situation_id' => 'nullable|exists:contract_situations,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'job_function_id' => 'nullable|exists:job_functions,id',
            'history_date' => 'required|date',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'observation' => 'nullable|string',
        ], [
            'history_date.required' => 'A data do histórico é obrigatória.',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início.',
        ]);

        $employmentContract->recruitmentHistory()->create($validated);

        return redirect()->route('employment-contracts.recruitment-history.index', $employmentContract)
            ->with('success', 'Histórico cadastrado com sucesso.');
    }

    public function edit(EmploymentContract $employmentContract, RecruitmentHistory $recruitmentHistory): Response
    {
        return Inertia::render('HR/RecruitmentHistory/Edit', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'recruitmentHistory' => $recruitmentHistory,
            'contractSituations' => ContractSituation::all(),
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
        ]);
    }

    public function update(Request $request, EmploymentContract $employmentContract, RecruitmentHistory $recruitmentHistory): RedirectResponse
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

        return redirect()->route('employment-contracts.recruitment-history.index', $employmentContract)
            ->with('success', 'Histórico atualizado com sucesso.');
    }

    public function destroy(EmploymentContract $employmentContract, RecruitmentHistory $recruitmentHistory): RedirectResponse
    {
        $recruitmentHistory->delete();

        return redirect()->route('employment-contracts.recruitment-history.index', $employmentContract)
            ->with('success', 'Histórico removido com sucesso.');
    }
}
