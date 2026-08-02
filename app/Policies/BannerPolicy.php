<?php

declare(strict_types=1);

namespace App\Policies;

class BannerPolicy extends ResourcePolicy
{
    protected string $prefix = 'banner';
}
