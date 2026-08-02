<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRolesAndPermissions
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permission');
    }

    public function hasRole(string ...$slugs): bool
    {
        return $this->roles()->whereIn('slug', $slugs)->exists();
    }

    /**
     * Cek apakah user memiliki permission, baik langsung maupun melalui role.
     */
    public function hasPermission(string $slug): bool
    {
        $direct = $this->permissions()->where('slug', $slug)->exists();

        if ($direct) {
            return true;
        }

        return $this->roles()->whereHas('permissions', function (Builder $query) use ($slug) {
            $query->where('slug', $slug);
        })->exists();
    }

    public function assignRole(string $slug): self
    {
        $role = Role::where('slug', $slug)->firstOrFail();

        $this->roles()->syncWithoutDetaching([$role->id]);

        return $this;
    }

    public function removeRole(string $slug): self
    {
        $role = Role::where('slug', $slug)->firstOrFail();

        $this->roles()->detach($role->id);

        return $this;
    }

    public function syncRoles(array $slugs): self
    {
        $roleIds = Role::whereIn('slug', $slugs)->pluck('id')->all();

        $this->roles()->sync($roleIds);

        return $this;
    }

    public function givePermissionTo(string $slug): self
    {
        $permission = Permission::where('slug', $slug)->firstOrFail();

        $this->permissions()->syncWithoutDetaching([$permission->id]);

        return $this;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
