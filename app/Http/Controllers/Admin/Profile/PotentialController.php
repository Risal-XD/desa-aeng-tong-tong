<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\PotentialRequest;
use App\Models\VillagePotential;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PotentialController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', VillagePotential::class);

        $village = $this->villageService->getDefaultVillage();
        $potentials = VillagePotential::query()
            ->with('author')
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.profile.potentials.index', compact('village', 'potentials'));
    }

    public function create(): View
    {
        $this->authorize('create', VillagePotential::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.profile.potentials.create', compact('village'));
    }

    public function store(PotentialRequest $request): RedirectResponse
    {
        $this->authorize('create', VillagePotential::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except('image');
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['image'] = $request->hasFile('image') ? $this->upload->store($request->file('image'), 'images/potentials') : null;
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        $potential = VillagePotential::create($data);

        $this->activityLog->log('Menambahkan potensi desa', 'created', $potential, ['title' => $potential->title]);

        return redirect()->route('admin.profile.potentials.index')
            ->with('success', 'Potensi desa berhasil ditambahkan.');
    }

    public function edit(VillagePotential $potential): View
    {
        $this->authorize('update', $potential);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.profile.potentials.edit', compact('village', 'potential'));
    }

    public function update(PotentialRequest $request, VillagePotential $potential): RedirectResponse
    {
        $this->authorize('update', $potential);

        $data = $request->safe()->except('image');
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload->replace($potential->image, $request->file('image'), 'images/potentials');
        }

        $potential->update($data);

        $this->activityLog->log('Memperbarui potensi desa', 'updated', $potential, ['title' => $potential->title]);

        return back()->with('success', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(VillagePotential $potential): RedirectResponse
    {
        $this->authorize('delete', $potential);

        $title = $potential->title;

        $this->upload->delete($potential->image);
        $potential->delete();

        $this->activityLog->log('Menghapus potensi desa', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.profile.potentials.index')
            ->with('success', 'Potensi desa berhasil dihapus.');
    }
}
