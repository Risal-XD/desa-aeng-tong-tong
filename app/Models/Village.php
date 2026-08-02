<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Village extends Model
{
    protected $fillable = [
        'name',
        'code',
        'district',
        'regency',
        'province',
        'address',
        'latitude',
        'longitude',
        'area',
        'total_hamlet',
        'description',
        'logo',
        'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'area' => 'decimal:2',
            'total_hamlet' => 'integer',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(VillageProfile::class);
    }

    public function history(): HasOne
    {
        return $this->hasOne(VillageHistory::class);
    }

    public function visions(): HasMany
    {
        return $this->hasMany(Vision::class);
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    public function structures(): HasMany
    {
        return $this->hasMany(OrganizationalStructure::class);
    }

    public function officials(): HasMany
    {
        return $this->hasMany(VillageOfficial::class);
    }

    public function potentials(): HasMany
    {
        return $this->hasMany(VillagePotential::class);
    }

    public function getFullAddressAttribute(): string
    {
        return trim(implode(', ', array_filter([$this->address, $this->district, $this->regency, $this->province])), ', ');
    }
}
