<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AgendaStatus;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'user_id',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'is_featured' => 'boolean',
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

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', AgendaStatus::PUBLISHED->value);
    }
}
