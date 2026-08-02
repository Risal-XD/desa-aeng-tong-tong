<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AnnouncementStatus;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'user_id',
        'title',
        'slug',
        'content',
        'attachment',
        'status',
        'published_at',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'expired_at' => 'datetime',
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
        return $query->where('status', AnnouncementStatus::PUBLISHED->value)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->where(fn ($q) => $q->whereNull('expired_at')->orWhere('expired_at', '>=', now()));
    }
}
