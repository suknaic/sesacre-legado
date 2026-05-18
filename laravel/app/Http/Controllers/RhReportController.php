<?php

namespace App\Http\Controllers;

use App\Models\ContractSituation;
use App\Models\EmploymentBond;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\JobPosition;
use App\Models\Organization;
use App\Models\RecruitmentHistory;
use Inertia\Inertia;
use Inertia\Response;

class RhReportController extends Controller
{
    public function diverse(): Response
    {
        $search = request('search');
        $jobPositionId = request('job_position_id');
        $jobFunctionId = request('job_function_id');
        $employmentBondId = request('employment_bond_id');
        $organizationId = request('organization_id');
        $contractSituationId = request('contract_situation_id');

        $contracts = EmploymentContract::with([
            'personalInfo.user',
            'employmentBond',
            'jobPosition',
            'legalEntity',
            'locations.organization',
            'locations.jobFunction',
            'recruitmentHistory.contractSituation',
        ])
            ->when($search, fn ($q, $v) => $q->whereHas('personalInfo.user', fn ($q) => $q->where('name', 'like', "%{$v}%")))
            ->when($jobPositionId, fn ($q, $v) => $q->where('job_position_id', $v))
            ->when($employmentBondId, fn ($q, $v) => $q->where('employment_bond_id', $v))
            ->when($organizationId, fn ($q, $v) => $q->whereHas('locations', fn ($q) => $q->where('organization_id', $v)))
            ->when($contractSituationId, fn ($q, $v) => $q->whereHas('recruitmentHistory', fn ($q) => $q->where('contract_situation_id', $v)))
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('HR/Reports/Diverse', [
            'contracts' => $contracts,
            'jobPositions' => JobPosition::all(),
            'jobFunctions' => JobFunction::all(),
            'employmentBonds' => EmploymentBond::all(),
            'organizations' => Organization::where('is_active', true)->get(),
            'contractSituations' => ContractSituation::all(),
            'filters' => request()->only(['search', 'job_position_id', 'job_function_id', 'employment_bond_id', 'organization_id', 'contract_situation_id']),
        ]);
    }

    public function vacations(): Response
    {
        $search = request('search');
        $contractSituationId = request('contract_situation_id');
        $dateStart = request('date_start');
        $dateEnd = request('date_end');

        $history = RecruitmentHistory::with([
            'employmentContract.personalInfo.user',
            'employmentContract.employmentBond',
            'employmentContract.jobPosition',
            'contractSituation',
            'organization',
            'jobFunction',
        ])
            ->when($search, fn ($q, $v) => $q->whereHas('employmentContract.personalInfo.user', fn ($q) => $q->where('name', 'like', "%{$v}%")))
            ->when($contractSituationId, fn ($q, $v) => $q->where('contract_situation_id', $v))
            ->when($dateStart, fn ($q, $v) => $q->whereDate('start_date', '>=', $v))
            ->when($dateEnd, fn ($q, $v) => $q->whereDate('end_date', '<=', $v))
            ->orderBy('start_date', 'desc')
            ->get();

        return Inertia::render('HR/Reports/Vacations', [
            'history' => $history,
            'contractSituations' => ContractSituation::all(),
            'filters' => request()->only(['search', 'contract_situation_id', 'date_start', 'date_end']),
        ]);
    }
}
