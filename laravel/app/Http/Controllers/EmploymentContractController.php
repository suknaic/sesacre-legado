<?php

namespace App\Http\Controllers;

use App\Models\EmploymentBond;
use App\Models\EmploymentContract;
use App\Models\JobFunction;
use App\Models\JobPosition;
use App\Models\LegalEntity;
use App\Models\Organization;
use App\Models\PersonalInfo;
use App\Models\RecruitmentHistory;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class EmploymentContractController extends Controller
{
    public function index(): Response
    {
        $search = request('search');
        $isActive = request('is_active');

        $employmentContracts = EmploymentContract::query()
            ->with(['personalInfo.user', 'employmentBond', 'jobPosition'])
            ->when($search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('registration_number', 'like', "%{$search}%")
                        ->orWhereHas('personalInfo.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($isActive !== null && $isActive !== '', function ($q) use ($isActive) {
                $q->where('is_active', filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('HR/EmploymentContracts/Index', [
            'employmentContracts' => $employmentContracts,
            'filters' => request()->only(['search', 'is_active']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/EmploymentContracts/Create', $this->getFormOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'registration_number' => 'nullable|string|max:20',
            'personal_info_id' => 'required|exists:personal_info,id',
            'employment_bond_id' => 'nullable|exists:employment_bonds,id',
            'job_position_id' => 'nullable|exists:job_positions,id',
            'legal_entity_id' => 'nullable|exists:legal_entities,id',
            'admission_date' => 'required|date',
            'termination_date' => 'nullable|date|after:admission_date',
            'workload' => 'required|integer|min:1|max:40',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'contract_locations' => 'nullable|array',
            'contract_locations.*.organization_id' => 'required_with:contract_locations|exists:organizations,id',
            'contract_locations.*.job_function_id' => 'nullable|exists:job_functions,id',
            'contract_locations.*.workload' => 'required_with:contract_locations|integer|min:1|max:40',
            'contract_locations.*.start_date' => 'required_with:contract_locations|date',
            'contract_locations.*.end_date' => 'nullable|date|after_or_equal:contract_locations.*.start_date',
        ], [
            'personal_info_id.required' => 'O funcionário é obrigatório.',
            'admission_date.required' => 'A data de admissão é obrigatória.',
            'admission_date.date' => 'Informe uma data de admissão válida.',
            'termination_date.after' => 'A data de término deve ser posterior à data de admissão.',
            'workload.required' => 'A carga horária é obrigatória.',
            'workload.min' => 'A carga horária deve ser maior que 0.',
            'workload.max' => 'A carga horária não pode exceder 40 horas.',
            'contract_locations.*.organization_id.required_with' => 'A organização é obrigatória para cada lotação.',
            'contract_locations.*.workload.required_with' => 'A carga horária é obrigatória para cada lotação.',
            'contract_locations.*.workload.max' => 'A carga horária da lotação não pode exceder 40 horas.',
            'contract_locations.*.start_date.required_with' => 'A data de início é obrigatória para cada lotação.',
        ]);

        $personalInfo = PersonalInfo::with('user')->findOrFail($validated['personal_info_id']);

        $this->validateCpf($personalInfo);
        $this->checkDuplicateActiveContract($validated['personal_info_id']);
        $this->validateAgeAtAdmission($personalInfo, $validated['admission_date']);

        if (!empty($validated['contract_locations'])) {
            $this->validateContractLocations($validated['contract_locations'], $validated['workload']);
        }

        $contract = EmploymentContract::create($validated);

        if (!empty($validated['contract_locations'])) {
            foreach ($validated['contract_locations'] as $location) {
                $contract->locations()->create($location);
            }
        }

        RecruitmentHistory::create([
            'employment_contract_id' => $contract->id,
            'history_date' => now(),
            'start_date' => $validated['admission_date'],
            'observation' => 'Cadastro do contrato',
        ]);

        return redirect()->route('employment-contracts.index')
            ->with('success', 'Contrato criado com sucesso.');
    }

    public function show(EmploymentContract $employmentContract): Response
    {
        $employmentContract->load([
            'personalInfo.user',
            'employmentBond',
            'jobPosition',
            'legalEntity',
            'locations.organization',
            'locations.jobFunction',
            'recruitmentHistory.contractSituation',
            'recruitmentHistory.organization',
            'recruitmentHistory.jobFunction',
        ]);

        return Inertia::render('HR/EmploymentContracts/Show', [
            'employmentContract' => $employmentContract,
        ]);
    }

    public function edit(EmploymentContract $employmentContract): Response
    {
        $employmentContract->load(['locations']);

        return Inertia::render('HR/EmploymentContracts/Edit', array_merge(
            ['employmentContract' => $employmentContract],
            $this->getFormOptions()
        ));
    }

    public function update(Request $request, EmploymentContract $employmentContract): RedirectResponse
    {
        $validated = $request->validate([
            'registration_number' => 'nullable|string|max:20',
            'personal_info_id' => 'required|exists:personal_info,id',
            'employment_bond_id' => 'nullable|exists:employment_bonds,id',
            'job_position_id' => 'nullable|exists:job_positions,id',
            'legal_entity_id' => 'nullable|exists:legal_entities,id',
            'admission_date' => 'required|date',
            'termination_date' => 'nullable|date|after:admission_date',
            'workload' => 'required|integer|min:1|max:40',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
            'contract_locations' => 'nullable|array',
            'contract_locations.*.organization_id' => 'required_with:contract_locations|exists:organizations,id',
            'contract_locations.*.job_function_id' => 'nullable|exists:job_functions,id',
            'contract_locations.*.workload' => 'required_with:contract_locations|integer|min:1|max:40',
            'contract_locations.*.start_date' => 'required_with:contract_locations|date',
            'contract_locations.*.end_date' => 'nullable|date|after_or_equal:contract_locations.*.start_date',
        ], [
            'personal_info_id.required' => 'O funcionário é obrigatório.',
            'admission_date.required' => 'A data de admissão é obrigatória.',
            'admission_date.date' => 'Informe uma data de admissão válida.',
            'termination_date.after' => 'A data de término deve ser posterior à data de admissão.',
            'workload.required' => 'A carga horária é obrigatória.',
            'workload.min' => 'A carga horária deve ser maior que 0.',
            'workload.max' => 'A carga horária não pode exceder 40 horas.',
        ]);

        $personalInfo = PersonalInfo::with('user')->findOrFail($validated['personal_info_id']);

        $this->validateCpf($personalInfo);
        $this->validateAgeAtAdmission($personalInfo, $validated['admission_date']);

        if (!empty($validated['contract_locations'])) {
            $this->validateContractLocations($validated['contract_locations'], $validated['workload']);
        }

        $employmentContract->update($validated);

        if (isset($validated['contract_locations'])) {
            $employmentContract->locations()->delete();
            foreach ($validated['contract_locations'] as $location) {
                $employmentContract->locations()->create($location);
            }
        }

        return redirect()->route('employment-contracts.index')
            ->with('success', 'Contrato atualizado com sucesso.');
    }

    public function destroy(EmploymentContract $employmentContract): RedirectResponse
    {
        if ($employmentContract->locations()->whereNull('end_date')->count() > 0) {
            return redirect()->route('employment-contracts.index')
                ->with('error', 'Não é possível remover o contrato pois existem lotações ativas vinculadas.');
        }

        $employmentContract->delete();

        return redirect()->route('employment-contracts.index')
            ->with('success', 'Contrato removido com sucesso.');
    }

    private function validateCpf(PersonalInfo $personalInfo): void
    {
        $cpf = preg_replace('/\D/', '', $personalInfo->user?->cpf ?? '');

        if (strlen($cpf) !== 11) {
            throw ValidationException::withMessages(['personal_info_id' => 'CPF do funcionário deve conter exatamente 11 dígitos.']);
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            throw ValidationException::withMessages(['personal_info_id' => 'CPF inválido (todos os dígitos iguais).']);
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                throw ValidationException::withMessages(['personal_info_id' => 'CPF do funcionário é inválido.']);
            }
        }
    }

    private function checkDuplicateActiveContract(int $personalInfoId): void
    {
        $exists = EmploymentContract::where('personal_info_id', $personalInfoId)
            ->where('is_active', true)
            ->whereNull('termination_date')
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages(['personal_info_id' => 'Já existe um contrato ativo para este funcionário.']);
        }
    }

    private function validateAgeAtAdmission(PersonalInfo $personalInfo, string $admissionDate): void
    {
        $birthDate = $personalInfo->birth_date;
        if (!$birthDate) {
            return;
        }

        $birth = Carbon::parse($birthDate);
        $admission = Carbon::parse($admissionDate);
        $minAgeDate = $birth->copy()->addYears(16);

        if ($admission->lessThan($minAgeDate)) {
            throw ValidationException::withMessages(['admission_date' => 'A data de admissão deve ser posterior a ' . $birth->format('d/m/Y') . ' (16 anos completos).']);
        }
    }

    private function validateContractLocations(array $locations, int $contractWorkload): void
    {
        $totalWorkload = 0;

        foreach ($locations as $i => $loc) {
            $start = Carbon::parse($loc['start_date']);
            $end = isset($loc['end_date']) ? Carbon::parse($loc['end_date']) : null;

            if ($end && $end->lessThan($start)) {
                throw ValidationException::withMessages(['contract_locations.' . $i . '.end_date' => 'A data de fim não pode ser anterior à data de início.']);
            }

            foreach ($locations as $j => $other) {
                if ($i === $j) {
                    continue;
                }

                $otherStart = Carbon::parse($other['start_date']);
                $otherEnd = isset($other['end_date']) ? Carbon::parse($other['end_date']) : null;

                if ($end && $otherEnd) {
                    if ($start->lessThanOrEqualTo($otherEnd) && $end->greaterThanOrEqualTo($otherStart)) {
                        throw ValidationException::withMessages(['contract_locations.' . $i . '.start_date' => 'As datas não podem se sobrepor com a lotação #' . ($j + 1) . '.']);
                    }
                } elseif (!$end && !$otherEnd) {
                    throw ValidationException::withMessages(['contract_locations.' . $i . '.end_date' => 'Não pode haver mais de uma lotação sem data de fim.']);
                } elseif (!$end && $otherEnd) {
                    if ($start->lessThanOrEqualTo($otherEnd)) {
                        throw ValidationException::withMessages(['contract_locations.' . $i . '.start_date' => 'As datas não podem se sobrepor com a lotação #' . ($j + 1) . '.']);
                    }
                } elseif ($end && !$otherEnd) {
                    if ($otherStart->lessThanOrEqualTo($end)) {
                        throw ValidationException::withMessages(['contract_locations.' . $i . '.start_date' => 'As datas não podem se sobrepor com a lotação #' . ($j + 1) . '.']);
                    }
                }
            }

            $totalWorkload += (int) $loc['workload'];
        }

        if ($totalWorkload > $contractWorkload) {
            throw ValidationException::withMessages(['workload' => 'A soma das cargas horárias das lotações (' . $totalWorkload . 'h) excede a carga horária do contrato (' . $contractWorkload . 'h).']);
        }

        if ($totalWorkload < $contractWorkload) {
            throw ValidationException::withMessages(['workload' => 'A soma das cargas horárias das lotações (' . $totalWorkload . 'h) é inferior à carga horária do contrato (' . $contractWorkload . 'h). Complete a carga horária.']);
        }
    }

    private function getFormOptions(): array
    {
        return [
            'personalInfos' => PersonalInfo::with('user')->whereHas('user')->get()->map(fn ($p) => [
                'id' => $p->id,
                'name' => $p->user?->name,
                'cpf' => $p->user?->cpf,
            ]),
            'employmentBonds' => EmploymentBond::all(),
            'jobPositions' => JobPosition::all(),
            'legalEntities' => LegalEntity::all(),
            'organizations' => Organization::where('is_active', true)->get(),
            'jobFunctions' => JobFunction::all(),
            'contractSituations' => \App\Models\ContractSituation::all(),
        ];
    }
}
