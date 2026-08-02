<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\VillageProfileRequest;
use App\Models\VillageProfile;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VillageProfileController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function edit(): View
    {
        $this->authorize('viewAny', VillageProfile::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.profile.village.edit', compact('village'));
    }

    public function update(VillageProfileRequest $request): RedirectResponse
    {
        $this->authorize('update', VillageProfile::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $this->villageService->updateHasOne($village, 'profile', $request->safe()->all());

        $this->activityLog->log('Memperbarui profil desa', 'updated', $village);

        return back()->with('success', 'Profil desa berhasil diperbarui.');
    }
}
