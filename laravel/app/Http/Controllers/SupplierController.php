<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SupplierController extends Controller
{
    public function index(): Response
    {
        $suppliers = Supplier::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Purchasing/Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Purchasing/Suppliers/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'legal_entity_id' => 'nullable|exists:legal_entities,id',
            'situation' => 'nullable|integer',
        ]);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Fornecedor criado com sucesso.');
    }

    public function show(Supplier $supplier): Response
    {
        return Inertia::render('Purchasing/Suppliers/Show', [
            'supplier' => $supplier,
        ]);
    }

    public function edit(Supplier $supplier): Response
    {
        return Inertia::render('Purchasing/Suppliers/Edit', [
            'supplier' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'legal_entity_id' => 'nullable|exists:legal_entities,id',
            'situation' => 'nullable|integer',
        ]);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Fornecedor atualizado com sucesso.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Fornecedor removido com sucesso.');
    }
}
