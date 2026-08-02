<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Village;
use Illuminate\Database\Eloquent\Collection;

class ProfileService
{
    /**
     * Mengambil desa default berikut relasi profil untuk halaman publik.
     */
    public function getPublicVillage(): ?Village
    {
        return Village::query()
            ->with([
                'profile',
                'history',
                'visions' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'missions' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'structures' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'officials' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'potentials' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
            ])
            ->orderBy('id')
            ->first();
    }

    /**
     * Potensi unggulan (featured) untuk beranda.
     */
    public function getFeaturedPotentials(int $limit = 3): Collection
    {
        $village = $this->getPublicVillage();

        if (! $village) {
            return new Collection;
        }

        return $village->potentials
            ->where('is_featured', true)
            ->take($limit)
            ->values();
    }

    /**
     * Struktur organisasi dibentuk sebagai pohon (root → children).
     */
    public function buildStructureTree(Village $village): Collection
    {
        $structures = $village->structures;

        return $structures
            ->where('parent_id', null)
            ->map(function ($root) use ($structures) {
                $root->children = $structures->where('parent_id', $root->id)->values();

                return $root;
            })
            ->values();
    }

    /**
     * Perangkat desa dikelompokkan berdasarkan unit struktur.
     */
    public function groupOfficialsByStructure(Village $village): array
    {
        return $village->officials
            ->groupBy(fn ($official) => $official->structure?->position ?? 'Perangkat Desa')
            ->map(function ($officials, $position) {
                return [
                    'position' => $position,
                    'officials' => $officials->values(),
                ];
            })
            ->values()
            ->all();
    }
}
