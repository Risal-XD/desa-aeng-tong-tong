<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\StatisticRequest;
use App\Models\Statistic;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Statistic::class);

        $statistics = Statistic::query()
            ->withCount('populationStatistics')
            ->orderBy('year', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.data-report.statistics.index', compact('statistics'));
    }

    public function create(): View
    {
        $this->authorize('create', Statistic::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.data-report.statistics.create', compact('village'));
    }

    public function store(StatisticRequest $request): RedirectResponse
    {
        $this->authorize('create', Statistic::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $statistic = Statistic::create(array_merge(
            $request->safe()->except(['population']),
            [
                'village_id' => $village->getKey(),
                'is_active' => $request->boolean('is_active', true),
            ],
        ));

        $this->syncPopulation($statistic, $request);

        $this->activityLog->log('Menambahkan statistik desa', 'created', $statistic, ['name' => $statistic->name]);

        return redirect()->route('admin.data-report.statistics.index')
            ->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function edit(Statistic $statistic): View
    {
        $this->authorize('update', $statistic);

        $statistic->load('populationStatistics');

        return view('admin.data-report.statistics.edit', compact('statistic'));
    }

    public function update(StatisticRequest $request, Statistic $statistic): RedirectResponse
    {
        $this->authorize('update', $statistic);

        $statistic->update(array_merge(
            $request->safe()->except(['population']),
            ['is_active' => $request->boolean('is_active', true)],
        ));

        $this->syncPopulation($statistic, $request);

        $this->activityLog->log('Memperbarui statistik desa', 'updated', $statistic, ['name' => $statistic->name]);

        return back()->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(Statistic $statistic): RedirectResponse
    {
        $this->authorize('delete', $statistic);

        $name = $statistic->name;

        $statistic->delete();

        $this->activityLog->log('Menghapus statistik desa', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.data-report.statistics.index')
            ->with('success', 'Statistik berhasil dihapus.');
    }

    private function syncPopulation(Statistic $statistic, Request $request): void
    {
        $rows = collect($request->input('population', []))
            ->filter(fn (array $row): bool => filled($row['label'] ?? null))
            ->values();

        $statistic->populationStatistics()->delete();

        $statistic->populationStatistics()->createMany(
            $rows->map(fn (array $row, int $index): array => [
                'label' => $row['label'],
                'value' => $row['value'] ?? 0,
                'unit' => $row['unit'] ?? null,
                'sort_order' => $index,
            ])->all(),
        );
    }
}
