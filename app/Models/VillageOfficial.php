<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageOfficial extends Model
{
    protected $fillable = [
        'village_id',
        'structure_id',
        'name',
        'position',
        'nip',
        'photo',
        'email',
        'phone',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function structure(): BelongsTo
    {
        return $this->belongsTo(OrganizationalStructure::class, 'structure_id');
    }
}
