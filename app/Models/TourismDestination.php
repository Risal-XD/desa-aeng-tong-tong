<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourismDestination extends Model
{
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'user_id',
        'title',
        'slug',
        'description',
        'image',
        'gallery',
        'address',
        'latitude',
        'longitude',
        'open_hours',
        'entrance_fee',
        'category',
        'is_featured',
        'views_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
            'is_featured' => 'boolean',
            'views_count' => 'integer',
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
