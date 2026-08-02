<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

abstract class ResourcePolicy
{
    /**
     * Awalan slug permission, mis. "village", "structure", "potential".
     */
    protected string $prefix = '';

    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole(Role::SUPER_ADMIN) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission($this->prefix.'-view');
    }

    public function view(User $user, $model): bool
    {
        return $user->hasPermission($this->prefix.'-view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission($this->prefix.'-create');
    }

    public function update(User $user, $model): bool
    {
        return $user->hasPermission($this->prefix.'-edit');
    }

    public function delete(User $user, $model): bool
    {
        return $user->hasPermission($this->prefix.'-delete');
    }
}
