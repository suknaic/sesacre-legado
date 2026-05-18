<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DeliveryOrderController extends Controller
{
    public function index(): Response
    {
        $orders = DeliveryOrder::with('organization')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Planning/DeliveryOrders/Index', [
            'orders' => $orders,
        ]);
    }

    public function create(): Response
    {
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/DeliveryOrders/Create', [
            'organizations' => $organizations,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_date' => 'required|date',
            'material_description' => 'required|string|max:255',
            'quantity_ordered' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'ordered';
        $validated['quantity_received'] = 0;

        DeliveryOrder::create($validated);

        return redirect()->route('delivery-orders.index')
            ->with('success', 'Ordem de entrega criada com sucesso.');
    }

    public function show(DeliveryOrder $deliveryOrder): Response
    {
        $deliveryOrder->load('organization');

        return Inertia::render('Planning/DeliveryOrders/Show', [
            'order' => $deliveryOrder,
        ]);
    }

    public function edit(DeliveryOrder $deliveryOrder): Response
    {
        $deliveryOrder->load('organization');
        $organizations = Organization::orderBy('name')->get(['id', 'name']);

        return Inertia::render('Planning/DeliveryOrders/Edit', [
            'order' => $deliveryOrder,
            'organizations' => $organizations,
        ]);
    }

    public function update(Request $request, DeliveryOrder $deliveryOrder): RedirectResponse
    {
        $validated = $request->validate([
            'order_date' => 'required|date',
            'material_description' => 'required|string|max:255',
            'quantity_ordered' => 'required|numeric|min:0',
            'quantity_received' => 'required|numeric|min:0',
            'organization_id' => 'required|exists:organizations,id',
            'status' => 'required|in:ordered,partially_received,received',
            'receipt_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $deliveryOrder->update($validated);

        return redirect()->route('delivery-orders.index')
            ->with('success', 'Ordem de entrega atualizada com sucesso.');
    }

    public function destroy(DeliveryOrder $deliveryOrder): RedirectResponse
    {
        $deliveryOrder->delete();

        return redirect()->route('delivery-orders.index')
            ->with('success', 'Ordem de entrega removida com sucesso.');
    }

    public function receive(Request $request, DeliveryOrder $deliveryOrder): RedirectResponse
    {
        $validated = $request->validate([
            'quantity_received' => 'required|numeric|min:0|max:' . $deliveryOrder->quantity_ordered,
            'receipt_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['receipt_date'] ??= now()->toDateString();
        $validated['status'] = $validated['quantity_received'] >= $deliveryOrder->quantity_ordered
            ? 'received'
            : 'partially_received';

        $deliveryOrder->update($validated);

        return redirect()->route('delivery-orders.show', $deliveryOrder)
            ->with('success', 'Recebimento registrado com sucesso.');
    }
}
