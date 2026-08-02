<?php

declare(strict_types=1);

namespace App\Policies;

class VideoPolicy extends ResourcePolicy
{
    protected string $prefix = 'video';
}
