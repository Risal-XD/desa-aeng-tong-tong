<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Economy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Economy\KerisArtisanRequest;
use App\Models\KerisArtisan;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KerisController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', KerisArtisan::class);

        $artisans = KerisArtisan::query()
            ->with('author')
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.economy.keris.index', compact('artisans'));
    }

    public function create(): View
    {
        $this->authorize('create', KerisArtisan::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.keris.create', compact('village'));
    }

    public function store(KerisArtisanRequest $request): RedirectResponse
    {
        $this->authorize('create', KerisArtisan::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except(['photo', 'specialties']);
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['photo'] = $request->hasFile('photo') ? $this->upload->store($request->file('photo'), 'images/keris') : null;
        $data['specialties'] = $this->normalizeSpecialties($request);
        $data['is_active'] = $request->boolean('is_active', true);

        $artisan = KerisArtisan::create($data);

        $this->activityLog->log('Menambahkan Mpu/empu', 'created', $artisan, ['name' => $artisan->name]);

        return redirect()->route('admin.economy.keris.index')
            ->with('success', 'Data Mpu berhasil ditambahkan.');
    }

    public function edit(KerisArtisan $keris_artisan): View
    {
        $this->authorize('update', $keris_artisan);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.keris.edit', compact('village', 'keris_artisan'));
    }

    public function update(KerisArtisanRequest $request, KerisArtisan $keris_artisan): RedirectResponse
    {
        $this->authorize('update', $keris_artisan);

        $data = $request->safe()->except(['photo', 'specialties']);
        $data['specialties'] = $this->normalizeSpecialties($request);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->upload->replace($keris_artisan->photo, $request->file('photo'), 'images/keris');
        }

        $keris_artisan->update($data);

        $this->activityLog->log('Memperbarui Mpu/empu', 'updated', $keris_artisan, ['name' => $keris_artisan->name]);

        return back()->with('success', 'Data Mpu berhasil diperbarui.');
    }

    public function destroy(KerisArtisan $keris_artisan): RedirectResponse
    {
        $this->authorize('delete', $keris_artisan);

        $name = $keris_artisan->name;

        $this->upload->delete($keris_artisan->photo);
        $keris_artisan->delete();

        $this->activityLog->log('Menghapus Mpu/empu', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.economy.keris.index')
            ->with('success', 'Data Mpu berhasil dihapus.');
    }

    private function normalizeSpecialties(KerisArtisanRequest $request): ?array
    {
        if (! $request->filled('specialties')) {
            return null;
        }

        return collect(explode(',', (string) $request->input('specialties')))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
