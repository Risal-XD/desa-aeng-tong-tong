<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserPolicy
{
    /**
     * Super Admin melewati seluruh pemeriksaan izin.
     */
    public function before(User $user, string $ability): ?bool
    {
        return $user->hasRole(Role::SUPER_ADMIN) ? true : null;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('user-view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->hasPermission('user-view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('user-create');
    }

    public function update(User $user, User $model): bool
    {
        return $user->hasPermission('user-edit');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->hasPermission('user-delete') && $user->getKey() !== $model->getKey();
    }
}
