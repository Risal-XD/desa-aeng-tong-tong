<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MediaSeeder extends Seeder
{
    /**
     * Seed contoh media desa.
     */
    public function run(): void
    {
        $village = Village::first();
        $author = User::query()->whereHas('roles', fn ($q) => $q->where('slug', 'editor'))->first() ?? User::first();

        if ($village === null || $author === null) {
            return;
        }

        $this->seedGalleryCategories();
        $this->seedVideoCategories();
        $this->seedGalleries($village, $author);
        $this->seedVideos($village, $author);
        $this->seedBanners($village, $author);
    }

    private function seedGalleryCategories(): void
    {
        foreach (['Kegiatan Desa', 'Wisata', 'Budaya', 'UMKM'] as $name) {
            GalleryCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true],
            );
        }
    }

    private function seedVideoCategories(): void
    {
        foreach (['Profil Desa', 'Dokumentasi', 'Pembelajaran'] as $name) {
            VideoCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true],
            );
        }
    }

    private function seedGalleries(Village $village, User $author): void
    {
        $titles = [
            ['title' => 'Festival Keris 2026', 'category' => 'Budaya'],
            ['title' => 'Suasana Pantai Aeng Tong-Tong', 'category' => 'Wisata'],
            ['title' => 'Kegiatan Posyandu', 'category' => 'Kegiatan Desa'],
            ['title' => 'Pameran Produk UMKM', 'category' => 'UMKM'],
        ];

        foreach ($titles as $i => $item) {
            $category = GalleryCategory::where('name', $item['category'])->first();

            Gallery::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'gallery_category_id' => $category?->getKey(),
                    'user_id' => $author->getKey(),
                    'image' => null,
                    'description' => null,
                    'is_cover' => $i === 0,
                    'sort_order' => $i,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedVideos(Village $village, User $author): void
    {
        $items = [
            ['title' => 'Profil Desa Aeng Tong-Tong', 'category' => 'Profil Desa', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'platform' => 'youtube'],
            ['title' => 'Dokumentasi Festival Keris', 'category' => 'Dokumentasi', 'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', 'platform' => 'youtube'],
        ];

        foreach ($items as $item) {
            $category = VideoCategory::where('name', $item['category'])->first();

            Video::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'video_category_id' => $category?->getKey(),
                    'user_id' => $author->getKey(),
                    'video_url' => $item['video_url'],
                    'thumbnail' => null,
                    'platform' => $item['platform'],
                    'description' => null,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedBanners(Village $village, User $author): void
    {
        $items = [
            ['title' => 'Selamat Datang di Desa Aeng Tong-Tong', 'description' => 'Desa dengan potensi wisata dan budaya yang luar biasa.', 'position' => 'slider', 'sort_order' => 1],
            ['title' => 'Festival Keris 2026', 'description' => 'Saksikan kemegahan budaya keris di desa kami.', 'position' => 'slider', 'sort_order' => 2],
        ];

        foreach ($items as $item) {
            Banner::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'image' => null,
                    'link' => null,
                    'description' => $item['description'],
                    'position' => $item['position'],
                    'sort_order' => $item['sort_order'],
                    'status' => 'active',
                    'started_at' => null,
                    'ended_at' => null,
                ],
            );
        }
    }
}
