<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enums\ApbdesType;
use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use App\Services\ProfileService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $types = ApbdesType::cases();

        $years = Apbdes::active()
            ->select('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        $items = Apbdes::active()
            ->orderByDesc('year')
            ->orderBy('type')
            ->get();

        $summary = $this->buildSummary($items);

        return view('frontend.apbdes.index', compact('village', 'types', 'years', 'items', 'summary'));
    }

    /**
     * @param  Collection<int, Apbdes>  $items
     * @return array<string, array<string, array{budget: float, realization: float}>>
     */
    private function buildSummary($items): array
    {
        $summary = [];

        foreach ($items as $item) {
            $year = (string) $item->year;
            $type = $item->type->value;

            $summary[$year][$type]['budget'] = ($summary[$year][$type]['budget'] ?? 0) + (float) $item->budget_amount;
            $summary[$year][$type]['realization'] = ($summary[$year][$type]['realization'] ?? 0) + (float) $item->realization_amount;
        }

        return $summary;
    }
}
