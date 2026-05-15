<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestSituation;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseRequestController extends Controller
{
    public function index(): Response
    {
        $purchaseRequests = PurchaseRequest::with(['supplier', 'situation'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Purchasing/PurchaseRequests/Index', [
            'purchaseRequests' => $purchaseRequests,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Purchasing/PurchaseRequests/Create', [
            'suppliers' => Supplier::where('situation', 1)->get(),
            'situations' => PurchaseRequestSituation::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_request_situation_id' => 'nullable|exists:purchase_request_situations,id',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'request_date' => 'nullable|date',
        ]);

        PurchaseRequest::create($validated);

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Pedido criado com sucesso.');
    }

    public function show(PurchaseRequest $purchaseRequest): Response
    {
        $purchaseRequest->load(['supplier', 'situation']);

        return Inertia::render('Purchasing/PurchaseRequests/Show', [
            'purchaseRequest' => $purchaseRequest,
        ]);
    }

    public function edit(PurchaseRequest $purchaseRequest): Response
    {
        return Inertia::render('Purchasing/PurchaseRequests/Edit', [
            'purchaseRequest' => $purchaseRequest,
            'suppliers' => Supplier::where('situation', 1)->get(),
            'situations' => PurchaseRequestSituation::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:255',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'purchase_request_situation_id' => 'nullable|exists:purchase_request_situations,id',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'request_date' => 'nullable|date',
        ]);

        $purchaseRequest->update($validated);

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Pedido atualizado com sucesso.');
    }

    public function destroy(PurchaseRequest $purchaseRequest): RedirectResponse
    {
        $purchaseRequest->delete();

        return redirect()->route('purchase-requests.index')
            ->with('success', 'Pedido removido com sucesso.');
    }
}
