<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ExpenseTypeController extends Controller
{
    public function index(): Response
    {
        $expenseTypes = ExpenseType::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Administration/ExpenseTypes/Index', [
            'expenseTypes' => $expenseTypes,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Administration/ExpenseTypes/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        ExpenseType::create($validated);

        return redirect()->route('expense-types.index')
            ->with('success', 'Tipo de gasto criado com sucesso.');
    }

    public function show(ExpenseType $expenseType): Response
    {
        return Inertia::render('Administration/ExpenseTypes/Show', [
            'expenseType' => $expenseType,
        ]);
    }

    public function edit(ExpenseType $expenseType): Response
    {
        return Inertia::render('Administration/ExpenseTypes/Edit', [
            'expenseType' => $expenseType,
        ]);
    }

    public function update(Request $request, ExpenseType $expenseType): RedirectResponse
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:20',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $expenseType->update($validated);

        return redirect()->route('expense-types.index')
            ->with('success', 'Tipo de gasto atualizado com sucesso.');
    }

    public function destroy(ExpenseType $expenseType): RedirectResponse
    {
        $expenseType->delete();

        return redirect()->route('expense-types.index')
            ->with('success', 'Tipo de gasto removido com sucesso.');
    }
}
