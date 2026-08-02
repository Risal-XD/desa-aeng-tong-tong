<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\NewsStatus;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'news_category_id',
        'user_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'thumbnail',
        'source',
        'tags',
        'status',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'views_count' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', NewsStatus::PUBLISHED->value)
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }
}
