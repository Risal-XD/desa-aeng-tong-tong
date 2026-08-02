<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\GalleryRequest;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Gallery::class);

        $galleries = Gallery::query()
            ->with(['category', 'author'])
            ->orderBy('is_cover', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.media.galleries.index', compact('galleries'));
    }

    public function create(): View
    {
        $this->authorize('create', Gallery::class);

        $village = $this->villageService->getDefaultVillage();
        $categories = GalleryCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.media.galleries.create', compact('village', 'categories'));
    }

    public function store(GalleryRequest $request): RedirectResponse
    {
        $this->authorize('create', Gallery::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except('image');
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['image'] = $this->upload->store($request->file('image'), 'images/galleries');
        $data['is_cover'] = $request->boolean('is_cover', false);
        $data['is_active'] = $request->boolean('is_active', true);

        $gallery = Gallery::create($data);

        $this->activityLog->log('Menambahkan foto galeri', 'created', $gallery, ['title' => $gallery->title]);

        return redirect()->route('admin.media.galleries.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        $this->authorize('update', $gallery);

        $village = $this->villageService->getDefaultVillage();
        $categories = GalleryCategory::where('is_active', true)->orderBy('name')->get();

        return view('admin.media.galleries.edit', compact('village', 'gallery', 'categories'));
    }

    public function update(GalleryRequest $request, Gallery $gallery): RedirectResponse
    {
        $this->authorize('update', $gallery);

        $data = $request->safe()->except('image');
        $data['is_cover'] = $request->boolean('is_cover', false);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload->replace($gallery->image, $request->file('image'), 'images/galleries');
        }

        $gallery->update($data);

        $this->activityLog->log('Memperbarui foto galeri', 'updated', $gallery, ['title' => $gallery->title]);

        return back()->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $this->authorize('delete', $gallery);

        $title = $gallery->title;

        $this->upload->delete($gallery->image);
        $gallery->delete();

        $this->activityLog->log('Menghapus foto galeri', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.media.galleries.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}
