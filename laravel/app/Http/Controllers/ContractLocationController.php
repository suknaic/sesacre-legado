<?php

namespace App\Http\Controllers;

use App\Models\ContractLocation;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ContractLocationController extends Controller
{
    public function index(EmploymentContract $employmentContract): Response
    {
        $locations = $employmentContract->locations()
            ->with(['organization', 'jobFunction'])
            ->orderBy('start_date')
            ->get();

        return Inertia::render('HR/ContractLocations/Index', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'locations' => $locations,
        ]);
    }

    public function create(EmploymentContract $employmentContract): Response
    {
        return Inertia::render('HR/ContractLocations/Create', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
        ]);
    }

    public function store(Request $request, EmploymentContract $employmentContract): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'job_function_id' => 'nullable|exists:job_functions,id',
            'workload' => 'required|integer|min:1|max:40',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ], [
            'organization_id.required' => 'A organização é obrigatória.',
            'workload.required' => 'A carga horária é obrigatória.',
            'workload.max' => 'A carga horária não pode exceder 40 horas.',
            'start_date.required' => 'A data de início é obrigatória.',
            'end_date.after_or_equal' => 'A data de fim deve ser posterior ou igual à data de início.',
        ]);

        $this->validateOverlap($employmentContract, $validated['start_date'], $validated['end_date'] ?? null);
        $this->validateWorkloadSum($employmentContract, (int) $validated['workload']);

        $employmentContract->locations()->create($validated);

        return redirect()->route('employment-contracts.locations.index', $employmentContract)
            ->with('success', 'Lotação cadastrada com sucesso.');
    }

    public function edit(EmploymentContract $employmentContract, ContractLocation $contractLocation): Response
    {
        return Inertia::render('HR/ContractLocations/Edit', [
            'employmentContract' => $employmentContract->load('personalInfo.user'),
            'location' => $contractLocation,
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
        ]);
    }

    public function update(Request $request, EmploymentContract $employmentContract, ContractLocation $contractLocation): RedirectResponse
    {
        $validated = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'job_function_id' => 'nullable|exists:job_functions,id',
            'workload' => 'required|integer|min:1|max:40',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->validateOverlap($employmentContract, $validated['start_date'], $validated['end_date'] ?? null, $contractLocation->id);
        $this->validateWorkloadSum($employmentContract, (int) $validated['workload'], $contractLocation->id);

        $contractLocation->update($validated);

        return redirect()->route('employment-contracts.locations.index', $employmentContract)
            ->with('success', 'Lotação atualizada com sucesso.');
    }

    public function destroy(EmploymentContract $employmentContract, ContractLocation $contractLocation): RedirectResponse
    {
        $contractLocation->delete();

        return redirect()->route('employment-contracts.locations.index', $employmentContract)
            ->with('success', 'Lotação removida com sucesso.');
    }

    private function validateOverlap(EmploymentContract $contract, string $startDate, ?string $endDate, ?int $excludeId = null): void
    {
        $start = Carbon::parse($startDate);
        $end = $endDate ? Carbon::parse($endDate) : null;

        $query = $contract->locations()
            ->where(function ($q) use ($start, $end) {
                if ($end) {
                    $q->where(function ($q) use ($start, $end) {
                        $q->whereDate('start_date', '<=', $end)
                            ->where(function ($q) use ($start) {
                                $q->whereNull('end_date')
                                    ->orWhereDate('end_date', '>=', $start);
                            });
                    });
                } else {
                    $q->whereNull('end_date')
                        ->orWhereDate('end_date', '>=', $start);
                }
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages(['start_date' => 'As datas desta lotação se sobrepõem a uma lotação existente.']);
        }
    }

    private function validateWorkloadSum(EmploymentContract $contract, int $newWorkload, ?int $excludeId = null): void
    {
        $currentWorkload = $contract->locations()
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->sum('workload');

        $total = $currentWorkload + $newWorkload;

        if ($total > ($contract->workload ?? 40)) {
            throw ValidationException::withMessages(['workload' => "A soma das cargas horárias das lotações ($total h) excede a carga horária do contrato ({$contract->workload} h)."]);
        }
    }
}
