<?php

namespace App\Http\Controllers;

use App\Models\EducationFormation;
use App\Models\EmploymentContract;
use App\Models\MaritalStatus;
use App\Models\PersonalInfo;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PersonalInfoController extends Controller
{
    public function index(): Response
    {
        $search = request('search');

        $personalInfos = PersonalInfo::query()
            ->with('user')
            ->when($search, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('cpf', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('HR/PersonalInfo/Index', [
            'personalInfos' => $personalInfos,
            'filters' => request()->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/PersonalInfo/Create', $this->getFormOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email',
            'cpf' => 'required|string|max:14',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'city_id' => 'nullable|exists:cities,id',
            'user_id' => 'nullable|exists:users,id',

            'gender' => 'nullable|string|max:10',
            'rg' => 'nullable|string|max:20',
            'issuing_agency' => 'nullable|string|max:50',
            'issuing_state_id' => 'nullable|exists:states,id',
            'marital_status_id' => 'nullable|exists:marital_statuses,id',
            'education_formation_id' => 'nullable|exists:education_formations,id',
            'skills' => 'nullable|string',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'cns_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'birth_date.before' => 'A data de nascimento deve ser no passado.',
        ]);

        $cpf = $this->cleanCpf($validated['cpf']);
        $this->validateCpf($cpf);
        $this->checkUniqueCpf($cpf, $validated['user_id'] ?? null);

        if (! empty($validated['user_id'])) {
            $user = User::findOrFail($validated['user_id']);
            $user->update([
                'name' => $validated['name'],
                'cpf' => $cpf,
                'phone' => $validated['phone'] ?? $user->phone,
                'mobile' => $validated['mobile'] ?? $user->mobile,
                'address' => $validated['address'] ?? $user->address,
                'neighborhood' => $validated['neighborhood'] ?? $user->neighborhood,
                'zip_code' => $validated['zip_code'] ?? $user->zip_code,
                'city_id' => $validated['city_id'] ?? $user->city_id,
            ]);
        } else {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make('12345678'),
                'cpf' => $cpf,
                'phone' => $validated['phone'] ?? null,
                'mobile' => $validated['mobile'] ?? null,
                'address' => $validated['address'] ?? null,
                'neighborhood' => $validated['neighborhood'] ?? null,
                'zip_code' => $validated['zip_code'] ?? null,
                'city_id' => $validated['city_id'] ?? null,
            ]);
        }

        $personalInfo = PersonalInfo::create([
            'user_id' => $user->id,
            'gender' => $validated['gender'] ?? null,
            'rg' => $validated['rg'] ?? null,
            'issuing_agency' => $validated['issuing_agency'] ?? null,
            'issuing_state_id' => $validated['issuing_state_id'] ?? null,
            'marital_status_id' => $validated['marital_status_id'] ?? null,
            'education_formation_id' => $validated['education_formation_id'] ?? null,
            'skills' => $validated['skills'] ?? null,
            'father_name' => $validated['father_name'] ?? null,
            'mother_name' => $validated['mother_name'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'cns_number' => $validated['cns_number'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        return redirect()->route('personal-info.show', $personalInfo->id)
            ->with('success', 'Funcionário cadastrado com sucesso.');
    }

    public function show(PersonalInfo $personalInfo): Response
    {
        $personalInfo->load([
            'user.city',
            'maritalStatus',
            'educationFormation',
            'issuingState',
        ]);

        $contracts = EmploymentContract::where('personal_info_id', $personalInfo->id)
            ->with(['employmentBond', 'jobPosition', 'legalEntity', 'locations.organization'])
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('HR/PersonalInfo/Show', [
            'personalInfo' => $personalInfo,
            'contracts' => $contracts,
        ]);
    }

    public function edit(PersonalInfo $personalInfo): Response
    {
        $personalInfo->load('user.city');

        return Inertia::render('HR/PersonalInfo/Edit', array_merge(
            ['personalInfo' => $personalInfo],
            $this->getFormOptions()
        ));
    }

    public function update(Request $request, PersonalInfo $personalInfo): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($personalInfo->user_id),
            ],
            'cpf' => 'required|string|max:14',
            'phone' => 'nullable|string|max:20',
            'mobile' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'neighborhood' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:10',
            'city_id' => 'nullable|exists:cities,id',

            'gender' => 'nullable|string|max:10',
            'rg' => 'nullable|string|max:20',
            'issuing_agency' => 'nullable|string|max:50',
            'issuing_state_id' => 'nullable|exists:states,id',
            'marital_status_id' => 'nullable|exists:marital_statuses,id',
            'education_formation_id' => 'nullable|exists:education_formations,id',
            'skills' => 'nullable|string',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'cns_number' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'email.unique' => 'Este e-mail já está em uso.',
            'birth_date.before' => 'A data de nascimento deve ser no passado.',
        ]);

        $cpf = $this->cleanCpf($validated['cpf']);
        $this->validateCpf($cpf);
        $this->checkUniqueCpf($cpf, $personalInfo->user_id);

        $personalInfo->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? $personalInfo->user->email,
            'cpf' => $cpf,
            'phone' => $validated['phone'] ?? $personalInfo->user->phone,
            'mobile' => $validated['mobile'] ?? $personalInfo->user->mobile,
            'address' => $validated['address'] ?? $personalInfo->user->address,
            'neighborhood' => $validated['neighborhood'] ?? $personalInfo->user->neighborhood,
            'zip_code' => $validated['zip_code'] ?? $personalInfo->user->zip_code,
            'city_id' => $validated['city_id'] ?? $personalInfo->user->city_id,
        ]);

        $personalInfo->update([
            'gender' => $validated['gender'] ?? $personalInfo->gender,
            'rg' => $validated['rg'] ?? $personalInfo->rg,
            'issuing_agency' => $validated['issuing_agency'] ?? $personalInfo->issuing_agency,
            'issuing_state_id' => $validated['issuing_state_id'] ?? $personalInfo->issuing_state_id,
            'marital_status_id' => $validated['marital_status_id'] ?? $personalInfo->marital_status_id,
            'education_formation_id' => $validated['education_formation_id'] ?? $personalInfo->education_formation_id,
            'skills' => $validated['skills'] ?? $personalInfo->skills,
            'father_name' => $validated['father_name'] ?? $personalInfo->father_name,
            'mother_name' => $validated['mother_name'] ?? $personalInfo->mother_name,
            'birth_date' => $validated['birth_date'] ?? $personalInfo->birth_date,
            'cns_number' => $validated['cns_number'] ?? $personalInfo->cns_number,
            'is_active' => $validated['is_active'] ?? $personalInfo->is_active,
        ]);

        return redirect()->route('personal-info.show', $personalInfo->id)
            ->with('success', 'Funcionário atualizado com sucesso.');
    }

    public function destroy(PersonalInfo $personalInfo): RedirectResponse
    {
        $personalInfo->delete();

        return redirect()->route('personal-info.index')
            ->with('success', 'Funcionário removido com sucesso.');
    }

    private function cleanCpf(?string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf ?? '');
    }

    private function validateCpf(string $cpf): void
    {
        if (strlen($cpf) !== 11) {
            throw ValidationException::withMessages(['cpf' => 'CPF deve conter exatamente 11 dígitos.']);
        }

        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            throw ValidationException::withMessages(['cpf' => 'CPF inválido (todos os dígitos iguais).']);
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += (int) $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int) $cpf[$t] !== $d) {
                throw ValidationException::withMessages(['cpf' => 'CPF inválido.']);
            }
        }
    }

    private function checkUniqueCpf(string $cpf, ?int $ignoreUserId = null): void
    {
        $query = User::where('cpf', $cpf);
        if ($ignoreUserId) {
            $query->where('id', '!=', $ignoreUserId);
        }
        if ($query->exists()) {
            throw ValidationException::withMessages(['cpf' => 'Este CPF já está cadastrado.']);
        }
    }

    private function getFormOptions(): array
    {
        return [
            'maritalStatuses' => MaritalStatus::all(),
            'educationFormations' => EducationFormation::all(),
            'states' => State::all(),
            'cities' => [],
        ];
    }
}
