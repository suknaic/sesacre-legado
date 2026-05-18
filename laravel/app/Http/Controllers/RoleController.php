<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Role;
use App\Models\System;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    public function index(): Response
    {
        $roles = Role::with('system')
            ->withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Permissions/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Permissions/Roles/Create', [
            'systems' => System::where('is_active', true)->get(),
            'resources' => Resource::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'system_id' => 'nullable|exists:systems,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $role = Role::create([
            'system_id' => $validated['system_id'] ?? null,
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (! empty($validated['user_ids'])) {
            $role->users()->sync($validated['user_ids']);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Perfil de acesso criado com sucesso.');
    }

    public function show(Role $role): Response
    {
        $role->load('system', 'users');

        return Inertia::render('Permissions/Roles/Show', [
            'role' => $role,
        ]);
    }

    public function edit(Role $role): Response
    {
        $role->load('users');

        return Inertia::render('Permissions/Roles/Edit', [
            'role' => $role,
            'systems' => System::where('is_active', true)->get(),
            'resources' => Resource::where('is_active', true)->get(),
            'users' => User::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $validated = $request->validate([
            'system_id' => 'nullable|exists:systems,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $role->update([
            'system_id' => $validated['system_id'] ?? null,
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (isset($validated['user_ids'])) {
            $role->users()->sync($validated['user_ids']);
        }

        return redirect()->route('roles.index')
            ->with('success', 'Perfil de acesso atualizado com sucesso.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Perfil de acesso removido com sucesso.');
    }
}
