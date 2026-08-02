<?php

declare(strict_types=1);

namespace App\Policies;

class SettingPolicy extends ResourcePolicy
{
    protected string $prefix = 'setting';
}
