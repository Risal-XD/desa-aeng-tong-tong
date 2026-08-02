<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function __construct(
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::query()
            ->withCount('users')
            ->withCount('permissions')
            ->orderBy('name')
            ->get();

        return view('admin.system.roles.index', compact('roles'));
    }

    public function edit(Role $role): View
    {
        $this->authorize('update', $role);

        $matrix = Permission::query()
            ->orderBy('group')
            ->orderBy('name')
            ->get()
            ->groupBy('group')
            ->map(function ($permissions) {
                return $permissions->mapWithKeys(function ($permission) {
                    $action = substr($permission->slug, strrpos($permission->slug, '-') + 1);

                    return [$action => $permission->slug];
                });
            });

        $rolePermissions = $role->permissions()->pluck('slug')->all();

        return view('admin.system.roles.edit', compact('role', 'matrix', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $this->authorize('update', $role);

        $role->update($request->safe()->only(['name', 'slug']));
        $role->permissions()->sync(
            Permission::whereIn('slug', $request->input('permissions', []))->pluck('id')->all(),
        );

        $this->activityLog->log('Memperbarui role & permission', 'updated', $role, ['name' => $role->name]);

        return back()->with('success', 'Role berhasil diperbarui.');
    }
}
