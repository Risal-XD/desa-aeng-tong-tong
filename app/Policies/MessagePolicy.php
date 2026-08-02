<?php

declare(strict_types=1);

namespace App\Policies;

class MessagePolicy extends ResourcePolicy
{
    protected string $prefix = 'message';
}
