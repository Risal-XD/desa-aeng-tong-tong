<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Economy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Economy\UmkmRequest;
use App\Models\Umkm;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UmkmController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Umkm::class);

        $umkms = Umkm::query()
            ->with('author')
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.economy.umkms.index', compact('umkms'));
    }

    public function create(): View
    {
        $this->authorize('create', Umkm::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.umkms.create', compact('village'));
    }

    public function store(UmkmRequest $request): RedirectResponse
    {
        $this->authorize('create', Umkm::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except(['logo', 'cover_image']);
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['logo'] = $request->hasFile('logo') ? $this->upload->store($request->file('logo'), 'images/umkms') : null;
        $data['cover_image'] = $request->hasFile('cover_image') ? $this->upload->store($request->file('cover_image'), 'images/umkms') : null;
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        $umkm = Umkm::create($data);

        $this->activityLog->log('Menambahkan UMKM', 'created', $umkm, ['name' => $umkm->name]);

        return redirect()->route('admin.economy.umkms.index')
            ->with('success', 'UMKM berhasil ditambahkan.');
    }

    public function edit(Umkm $umkm): View
    {
        $this->authorize('update', $umkm);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.umkms.edit', compact('village', 'umkm'));
    }

    public function update(UmkmRequest $request, Umkm $umkm): RedirectResponse
    {
        $this->authorize('update', $umkm);

        $data = $request->safe()->except(['logo', 'cover_image']);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->upload->replace($umkm->logo, $request->file('logo'), 'images/umkms');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload->replace($umkm->cover_image, $request->file('cover_image'), 'images/umkms');
        }

        $umkm->update($data);

        $this->activityLog->log('Memperbarui UMKM', 'updated', $umkm, ['name' => $umkm->name]);

        return back()->with('success', 'UMKM berhasil diperbarui.');
    }

    public function destroy(Umkm $umkm): RedirectResponse
    {
        $this->authorize('delete', $umkm);

        $name = $umkm->name;

        $this->upload->delete($umkm->logo);
        $this->upload->delete($umkm->cover_image);
        $umkm->delete();

        $this->activityLog->log('Menghapus UMKM', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.economy.umkms.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }
}
