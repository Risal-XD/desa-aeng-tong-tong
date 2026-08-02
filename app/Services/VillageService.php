<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Village;
use Illuminate\Database\Eloquent\Model;

class VillageService
{
    /**
     * Mengambil desa default (aktif) untuk seluruh modul konten.
     */
    public function getDefaultVillage(): ?Village
    {
        return Village::query()
            ->with(['profile', 'history'])
            ->orderBy('id')
            ->first();
    }

    /**
     * Update atau buat data one-to-one terkait desa (profile/history).
     */
    public function updateHasOne(Model $parent, string $relation, array $data): Model
    {
        $related = $parent->{$relation}()->firstOrNew([$parent->getForeignKey() => $parent->getKey()]);
        $related->fill($data)->save();

        return $related;
    }
}
