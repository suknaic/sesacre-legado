<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PersonalInfoController extends Controller
{
    public function index(): Response
    {
        $personalInfos = PersonalInfo::orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('HR/PersonalInfo/Index', [
            'personalInfos' => $personalInfos,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('HR/PersonalInfo/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
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
            'birth_date' => 'nullable|date',
            'cns_number' => 'nullable|string|max:20',
            'photo_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        PersonalInfo::create($validated);

        return redirect()->route('personal-infos.index')
            ->with('success', 'Dados pessoais criados com sucesso.');
    }

    public function show(PersonalInfo $personalInfo): Response
    {
        return Inertia::render('HR/PersonalInfo/Show', [
            'personalInfo' => $personalInfo,
        ]);
    }

    public function edit(PersonalInfo $personalInfo): Response
    {
        return Inertia::render('HR/PersonalInfo/Edit', [
            'personalInfo' => $personalInfo,
        ]);
    }

    public function update(Request $request, PersonalInfo $personalInfo): RedirectResponse
    {
        $validated = $request->validate([
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
            'birth_date' => 'nullable|date',
            'cns_number' => 'nullable|string|max:20',
            'photo_url' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $personalInfo->update($validated);

        return redirect()->route('personal-infos.index')
            ->with('success', 'Dados pessoais atualizados com sucesso.');
    }

    public function destroy(PersonalInfo $personalInfo): RedirectResponse
    {
        $personalInfo->delete();

        return redirect()->route('personal-infos.index')
            ->with('success', 'Dados pessoais removidos com sucesso.');
    }
}
