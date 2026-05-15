<?php

namespace App\Http\Controllers;

use App\Models\ContractSituation;
use App\Models\RecruitmentHistory;
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
}
