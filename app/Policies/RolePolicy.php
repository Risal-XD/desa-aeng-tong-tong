<?php

declare(strict_types=1);

namespace App\Policies;

class RolePolicy extends ResourcePolicy
{
    protected string $prefix = 'role';
}
