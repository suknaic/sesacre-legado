<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\Procurement;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $stats = [
            'totalUsers' => DB::table('users')->count(),
            'totalBudgets' => DB::table('fin_programa_trabalho')->count(),
            'totalContracts' => DB::table('ses_contrato')->count(),
            'totalPurchaseRequests' => PurchaseRequest::count(),
            'totalCommitments' => Commitment::count(),
            'totalProcurements' => Procurement::count(),
        ];

        $chartData = [
            'purchaseRequestBySituation' => PurchaseRequest::select('purchase_request_situation_id', DB::raw('count(*) as total'))
                ->groupBy('purchase_request_situation_id')
                ->get(),
            'commitmentsByStatus' => Commitment::select('commitment_status_id', DB::raw('count(*) as total'))
                ->groupBy('commitment_status_id')
                ->get(),
            'procurementsByModality' => Procurement::select('procurement_modality_id', DB::raw('count(*) as total'))
                ->groupBy('procurement_modality_id')
                ->get(),
        ];

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'chartData' => $chartData,
        ]);
    }
}
