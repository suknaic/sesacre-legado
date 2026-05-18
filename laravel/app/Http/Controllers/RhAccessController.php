<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RhAccessController extends Controller
{
    public function index(): Response
    {
        $rhRoles = Role::whereHas('system', fn ($q) => $q->where('name', 'RH'))->pluck('id');

        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(20)
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cpf' => $user->cpf,
                'is_active' => $user->is_active,
                'roles' => $user->roles->map(fn ($r) => ['id' => $r->id, 'name' => $r->name]),
                'has_rh_access' => $user->roles->whereIn('id', $rhRoles)->isNotEmpty(),
            ]);

        return Inertia::render('HR/AccessControl/Index', [
            'users' => $users,
            'rhRoles' => Role::whereHas('system', fn ($q) => $q->where('name', 'RH'))->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'grant' => 'required|boolean',
        ]);

        if ($validated['grant']) {
            $user->roles()->syncWithoutDetaching([$validated['role_id']]);
        } else {
            $user->roles()->detach($validated['role_id']);
        }

        return redirect()->route('rh-access.index')
            ->with('success', 'Acesso atualizado com sucesso.');
    }
}
