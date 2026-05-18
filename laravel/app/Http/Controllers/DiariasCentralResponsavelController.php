<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiariasCentralResponsavelController extends Controller
{
    public function index(): Response
    {
        $organizations = Organization::orderBy('name')
            ->paginate(15);

        return Inertia::render('Diarias/CentralResponsavel/Index', [
            'organizations' => $organizations,
        ]);
    }

    public function toggle(Organization $organization): RedirectResponse
    {
        $organization->update(['is_active' => !$organization->is_active]);

        return redirect()->route('diarias-central-responsavel.index')
            ->with('success', "Central '{$organization->name}' atualizada.");
    }
}
