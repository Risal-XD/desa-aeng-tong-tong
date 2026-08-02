<?php

declare(strict_types=1);

namespace App\Policies;

class NewsPolicy extends ResourcePolicy
{
    protected string $prefix = 'news';
}
