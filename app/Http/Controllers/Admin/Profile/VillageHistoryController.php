<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\HistoryRequest;
use App\Models\VillageHistory;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VillageHistoryController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function edit(): View
    {
        $this->authorize('viewAny', VillageHistory::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.profile.history.edit', compact('village'));
    }

    public function update(HistoryRequest $request): RedirectResponse
    {
        $this->authorize('update', new VillageHistory);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $this->villageService->updateHasOne($village, 'history', $request->safe()->all());

        $this->activityLog->log('Memperbarui sejarah desa', 'updated', $village);

        return back()->with('success', 'Sejarah desa berhasil diperbarui.');
    }
}
