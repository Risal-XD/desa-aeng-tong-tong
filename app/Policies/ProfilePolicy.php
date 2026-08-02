<?php

declare(strict_types=1);

namespace App\Policies;

class ProfilePolicy extends ResourcePolicy
{
    protected string $prefix = 'profile';
}
