<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApbdesType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apbdes extends Model
{
    protected $fillable = [
        'village_id',
        'user_id',
        'year',
        'type',
        'name',
        'category',
        'budget_amount',
        'realization_amount',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'type' => ApbdesType::class,
            'year' => 'integer',
            'budget_amount' => 'decimal:2',
            'realization_amount' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
