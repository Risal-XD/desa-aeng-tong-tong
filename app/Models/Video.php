<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\VideoPlatform;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasSlug;

    protected $fillable = [
        'village_id',
        'video_category_id',
        'user_id',
        'title',
        'slug',
        'video_url',
        'thumbnail',
        'platform',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VideoCategory::class, 'video_category_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        $platform = VideoPlatform::tryFrom((string) $this->platform) ?? VideoPlatform::YOUTUBE;

        return match ($platform) {
            VideoPlatform::YOUTUBE => $this->youtubeEmbedUrl(),
            VideoPlatform::VIMEO => $this->vimeoEmbedUrl(),
            VideoPlatform::OTHER => $this->video_url,
        };
    }

    private function youtubeEmbedUrl(): ?string
    {
        if (preg_match('/youtu\.be\/([\w-]+)/', (string) $this->video_url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}";
        }

        if (preg_match('/[?&]v=([\w-]+)/', (string) $this->video_url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}";
        }

        if (preg_match('/youtube\.com\/embed\/([\w-]+)/', (string) $this->video_url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}";
        }

        return $this->video_url;
    }

    private function vimeoEmbedUrl(): ?string
    {
        if (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', (string) $this->video_url, $m)) {
            return "https://player.vimeo.com/video/{$m[1]}";
        }

        return $this->video_url;
    }
}
