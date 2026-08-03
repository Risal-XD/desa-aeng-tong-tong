<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Banner;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\KerisArtisan;
use App\Models\News;
use App\Models\Statistic;
use App\Models\TourismDestination;
use App\Models\Umkm;
use App\Models\Video;
use App\Models\Village;
use Illuminate\Support\Facades\Cache;

/**
 * Membersihkan cache halaman depan saat data publik berubah.
 */
class FrontendCacheObserver
{
    /**
     * Handle the model "saved" event.
     */
    public function saved(mixed $model): void
    {
        $this->flush();
    }

    /**
     * Handle the model "deleted" event.
     */
    public function deleted(mixed $model): void
    {
        $this->flush();
    }

    /**
     * Model publik yang ikut memengaruhi cache frontend.
     */
    public static function models(): array
    {
        return [
            News::class,
            Banner::class,
            Agenda::class,
            Statistic::class,
            Village::class,
            Announcement::class,
            Gallery::class,
            Video::class,
            TourismDestination::class,
            KerisArtisan::class,
            Umkm::class,
            Faq::class,
        ];
    }

    private function flush(): void
    {
        Cache::forget('frontend.home.banners');
        Cache::forget('frontend.home.latest_news');
        Cache::forget('frontend.home.agendas');
        Cache::forget('frontend.home.statistics');
    }
}
