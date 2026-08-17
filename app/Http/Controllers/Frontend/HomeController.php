<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Banner;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Statistic;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    private const CACHE_TTL = 300;

    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $banners = Cache::remember('frontend.home.banners', self::CACHE_TTL, fn () => Banner::active()
            ->where('position', 'slider')
            ->orderBy('sort_order')
            ->get());

        $latestNews = Cache::remember('frontend.home.latest_news', self::CACHE_TTL, fn () => News::published()
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get());

        $upcomingAgendas = Cache::remember('frontend.home.agendas', self::CACHE_TTL, fn () => Agenda::published()
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date')
            ->limit(3)
            ->get());

        $latestStatistics = Cache::remember('frontend.home.statistics', self::CACHE_TTL, fn () => Statistic::active()
            ->with('populationStatistics')
            ->orderByDesc('year')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get());

        $heroPhotos = collect(range(1, 9))->map(fn (int $n) => (object) [
            'title' => 'Foto ' . $n,
            'image' => 'foto/card/' . $n . '.jpg',
        ])->values();

        $galleryPhotos = Cache::remember('frontend.home.gallery_photos', self::CACHE_TTL, fn () => Gallery::active()
            ->whereNotNull('image')
            ->orderBy('is_cover', 'desc')
            ->latest('id')
            ->limit(6)
            ->get());

        return view('frontend.home.index', [
            'village' => $this->profileService->getPublicVillage(),
            'featuredPotentials' => $this->profileService->getFeaturedPotentials(3),
            'banners' => $banners,
            'latestNews' => $latestNews,
            'upcomingAgendas' => $upcomingAgendas,
            'latestStatistics' => $latestStatistics,
            'heroPhotos' => $heroPhotos,
            'galleryPhotos' => $galleryPhotos,
        ]);
    }
}
