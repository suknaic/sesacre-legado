<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\System;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResourceController extends Controller
{
    public function index(): Response
    {
        $resources = Resource::with('system')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Permissions/Resources/Index', [
            'resources' => $resources,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Permissions/Resources/Create', [
            'systems' => System::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'system_id' => 'nullable|exists:systems,id',
            'name' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Resource::create($validated);

        return redirect()->route('resources.index')
            ->with('success', 'Recurso criado com sucesso.');
    }

    public function show(Resource $resource): Response
    {
        $resource->load('system');

        return Inertia::render('Permissions/Resources/Show', [
            'resource' => $resource,
        ]);
    }

    public function edit(Resource $resource): Response
    {
        return Inertia::render('Permissions/Resources/Edit', [
            'resource' => $resource,
            'systems' => System::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, Resource $resource): RedirectResponse
    {
        $validated = $request->validate([
            'system_id' => 'nullable|exists:systems,id',
            'name' => 'required|string|max:255',
            'route' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $resource->update($validated);

        return redirect()->route('resources.index')
            ->with('success', 'Recurso atualizado com sucesso.');
    }

    public function destroy(Resource $resource): RedirectResponse
    {
        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'Recurso removido com sucesso.');
    }
}
