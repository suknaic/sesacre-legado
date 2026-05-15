<?php

namespace App\Http\Controllers;

use App\Models\Commitment;
use App\Models\CommitmentStatus;
use App\Models\CommitmentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CommitmentController extends Controller
{
    public function index(): Response
    {
        $commitments = Commitment::with(['type', 'status'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Financial/Commitments/Index', [
            'commitments' => $commitments,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Financial/Commitments/Create', [
            'types' => CommitmentType::where('is_active', true)->get(),
            'statuses' => CommitmentStatus::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:255',
            'commitment_type_id' => 'nullable|exists:commitment_types,id',
            'commitment_status_id' => 'nullable|exists:commitment_statuses,id',
            'amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'system_date' => 'nullable|date',
            'external_date' => 'nullable|date',
        ]);

        Commitment::create($validated);

        return redirect()->route('commitments.index')
            ->with('success', 'Empenho criado com sucesso.');
    }

    public function show(Commitment $commitment): Response
    {
        $commitment->load(['type', 'status', 'history.situation', 'history.status', 'notes']);

        return Inertia::render('Financial/Commitments/Show', [
            'commitment' => $commitment,
        ]);
    }

    public function edit(Commitment $commitment): Response
    {
        return Inertia::render('Financial/Commitments/Edit', [
            'commitment' => $commitment,
            'types' => CommitmentType::where('is_active', true)->get(),
            'statuses' => CommitmentStatus::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Commitment $commitment): RedirectResponse
    {
        $validated = $request->validate([
            'number' => 'nullable|string|max:255',
            'commitment_type_id' => 'nullable|exists:commitment_types,id',
            'commitment_status_id' => 'nullable|exists:commitment_statuses,id',
            'amount' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'system_date' => 'nullable|date',
            'external_date' => 'nullable|date',
        ]);

        $commitment->update($validated);

        return redirect()->route('commitments.index')
            ->with('success', 'Empenho atualizado com sucesso.');
    }

    public function destroy(Commitment $commitment): RedirectResponse
    {
        $commitment->delete();

        return redirect()->route('commitments.index')
            ->with('success', 'Empenho removido com sucesso.');
    }
}
