<?php

namespace App\Http\Controllers;

use App\Models\PermissionGroup;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PermissionGroupController extends Controller
{
    public function index(): Response
    {
        $groups = PermissionGroup::withCount('resources', 'users')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Permissions/PermissionGroups/Index', [
            'groups' => $groups,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Permissions/PermissionGroups/Create', [
            'resources' => Resource::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'resources' => 'nullable|array',
            'resources.*.id' => 'required|exists:resources,id',
            'resources.*.can_create' => 'boolean',
            'resources.*.can_edit' => 'boolean',
            'resources.*.can_delete' => 'boolean',
        ]);

        $group = PermissionGroup::create([
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (! empty($validated['resources'])) {
            $syncData = [];
            foreach ($validated['resources'] as $res) {
                $syncData[$res['id']] = [
                    'can_create' => $res['can_create'] ?? false,
                    'can_edit' => $res['can_edit'] ?? false,
                    'can_delete' => $res['can_delete'] ?? false,
                ];
            }
            $group->resources()->sync($syncData);
        }

        return redirect()->route('permission-groups.index')
            ->with('success', 'Grupo de permissões criado com sucesso.');
    }

    public function show(PermissionGroup $permissionGroup): Response
    {
        $permissionGroup->load('resources');

        return Inertia::render('Permissions/PermissionGroups/Show', [
            'group' => $permissionGroup,
        ]);
    }

    public function edit(PermissionGroup $permissionGroup): Response
    {
        $permissionGroup->load('resources');

        return Inertia::render('Permissions/PermissionGroups/Edit', [
            'group' => $permissionGroup,
            'resources' => Resource::where('is_active', true)->get(),
        ]);
    }

    public function update(Request $request, PermissionGroup $permissionGroup): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'resources' => 'nullable|array',
            'resources.*.id' => 'required|exists:resources,id',
            'resources.*.can_create' => 'boolean',
            'resources.*.can_edit' => 'boolean',
            'resources.*.can_delete' => 'boolean',
        ]);

        $permissionGroup->update([
            'name' => $validated['name'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        if (isset($validated['resources'])) {
            $syncData = [];
            foreach ($validated['resources'] as $res) {
                $syncData[$res['id']] = [
                    'can_create' => $res['can_create'] ?? false,
                    'can_edit' => $res['can_edit'] ?? false,
                    'can_delete' => $res['can_delete'] ?? false,
                ];
            }
            $permissionGroup->resources()->sync($syncData);
        }

        return redirect()->route('permission-groups.index')
            ->with('success', 'Grupo de permissões atualizado com sucesso.');
    }

    public function destroy(PermissionGroup $permissionGroup): RedirectResponse
    {
        $permissionGroup->delete();

        return redirect()->route('permission-groups.index')
            ->with('success', 'Grupo de permissões removido com sucesso.');
    }
}
