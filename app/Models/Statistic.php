<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\StatisticCategory;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Statistic extends Model
{
    use HasSlug;

    protected $fillable = [
        'village_id',
        'name',
        'slug',
        'category',
        'year',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'category' => StatisticCategory::class,
            'year' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function populationStatistics(): HasMany
    {
        return $this->hasMany(PopulationStatistic::class, 'statistics_id')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
