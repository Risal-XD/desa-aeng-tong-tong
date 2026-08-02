<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DocumentStatus;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasSlug;
    use SoftDeletes;

    protected $fillable = [
        'village_id',
        'user_id',
        'title',
        'slug',
        'category',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'description',
        'download_count',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => DocumentStatus::class,
            'download_count' => 'integer',
            'published_at' => 'datetime',
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

    public function downloads(): HasMany
    {
        return $this->hasMany(Download::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', DocumentStatus::PUBLISHED)
            ->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }
}
