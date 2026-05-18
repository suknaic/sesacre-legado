<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiariasPerfilAcessoController extends Controller
{
    public function index(): Response
    {
        $users = User::with('roles')
            ->orderBy('name')
            ->paginate(15);

        return Inertia::render('Diarias/PerfilAcesso/Index', [
            'users' => $users,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'can_access_diarias' => 'boolean',
        ]);

        $user->update($validated);

        return redirect()->route('diarias-perfil-acesso.index')
            ->with('success', "Acesso do usuário '{$user->name}' atualizado.");
    }
}
