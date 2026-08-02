<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Banner;
use App\Models\News;
use App\Models\Statistic;
use App\Services\ProfileService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $featuredPotentials = $this->profileService->getFeaturedPotentials(3);
        $banners = Banner::active()
            ->where('position', 'slider')
            ->orderBy('sort_order')
            ->get();
        $latestNews = News::published()
            ->with('category')
            ->latest('published_at')
            ->limit(3)
            ->get();
        $upcomingAgendas = Agenda::published()
            ->where('event_date', '>=', now()->startOfDay())
            ->orderBy('event_date')
            ->limit(3)
            ->get();
        $latestStatistics = Statistic::active()
            ->with('populationStatistics')
            ->orderByDesc('year')
            ->orderBy('id', 'desc')
            ->limit(3)
            ->get();

        return view('frontend.home.index', [
            'village' => $village,
            'featuredPotentials' => $featuredPotentials,
            'banners' => $banners,
            'latestNews' => $latestNews,
            'upcomingAgendas' => $upcomingAgendas,
            'latestStatistics' => $latestStatistics,
        ]);
    }
}
