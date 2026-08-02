<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enums\StatisticCategory;
use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Services\ProfileService;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $categories = StatisticCategory::cases();

        $years = Statistic::active()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $statistics = Statistic::active()
            ->with('populationStatistics')
            ->orderByDesc('year')
            ->orderBy('category')
            ->get();

        return view('frontend.statistics.index', compact('village', 'categories', 'years', 'statistics'));
    }

    public function show(Statistic $statistic): View
    {
        abort_unless($statistic->is_active, 404);

        $village = $this->profileService->getPublicVillage();
        $statistic->load('populationStatistics');

        return view('frontend.statistics.show', compact('village', 'statistic'));
    }
}
