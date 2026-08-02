<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\VisionMissionRequest;
use App\Models\Vision;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VisionMissionController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function edit(): View
    {
        $this->authorize('viewAny', Vision::class);

        $village = $this->villageService->getDefaultVillage();
        $visions = $village?->visions()->orderBy('sort_order')->get() ?? collect();
        $missions = $village?->missions()->orderBy('sort_order')->get() ?? collect();

        return view('admin.profile.vision-mission.edit', compact('village', 'visions', 'missions'));
    }

    public function update(VisionMissionRequest $request): RedirectResponse
    {
        $this->authorize('update', Vision::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $village->visions()->delete();
        $village->missions()->delete();

        $village->visions()->create([
            'vision' => $request->validated('vision'),
            'sort_order' => $request->validated('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        foreach ($request->validated('missions', []) as $index => $mission) {
            $village->missions()->create([
                'mission' => $mission,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        $this->activityLog->log('Memperbarui visi & misi desa', 'updated', $village);

        return back()->with('success', 'Visi & misi desa berhasil diperbarui.');
    }
}
