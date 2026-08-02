<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::creating(function (Model $model): void {
            if (empty($model->slug)) {
                $model->slug = $model->generateUniqueSlug();
            }
        });
    }

    /**
     * Membuat slug unik dari sumber slug model.
     */
    public function generateUniqueSlug(): string
    {
        $base = slug_unik((string) $this->slugSource());
        $slug = $base;
        $suffix = 2;

        while (static::query()->where('slug', $slug)->exists()) {
            $slug = "{$base}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * Sumber teks untuk pembuatan slug. Override bila kolom berbeda.
     */
    public function slugSource(): string
    {
        return (string) ($this->title ?? $this->name ?? '');
    }
}
