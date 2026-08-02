<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageProfile extends Model
{
    protected $fillable = [
        'village_id',
        'overview',
        'geographic',
        'demographics_summary',
    ];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }
}
