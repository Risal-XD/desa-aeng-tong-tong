<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Media;

use App\Enums\CommonStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\BannerRequest;
use App\Models\Banner;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Banner::class);

        $banners = Banner::query()
            ->with('author')
            ->orderBy('sort_order')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.media.banners.index', compact('banners'));
    }

    public function create(): View
    {
        $this->authorize('create', Banner::class);

        $village = $this->villageService->getDefaultVillage();
        $statuses = CommonStatus::options();

        return view('admin.media.banners.create', compact('village', 'statuses'));
    }

    public function store(BannerRequest $request): RedirectResponse
    {
        $this->authorize('create', Banner::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except('image');
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['image'] = $this->upload->store($request->file('image'), 'images/banners');

        $banner = Banner::create($data);

        $this->activityLog->log('Menambahkan banner', 'created', $banner, ['title' => $banner->title]);

        return redirect()->route('admin.media.banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    public function edit(Banner $banner): View
    {
        $this->authorize('update', $banner);

        $village = $this->villageService->getDefaultVillage();
        $statuses = CommonStatus::options();

        return view('admin.media.banners.edit', compact('village', 'banner', 'statuses'));
    }

    public function update(BannerRequest $request, Banner $banner): RedirectResponse
    {
        $this->authorize('update', $banner);

        $data = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload->replace($banner->image, $request->file('image'), 'images/banners');
        }

        $banner->update($data);

        $this->activityLog->log('Memperbarui banner', 'updated', $banner, ['title' => $banner->title]);

        return back()->with('success', 'Banner berhasil diperbarui.');
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $this->authorize('delete', $banner);

        $title = $banner->title;

        $this->upload->delete($banner->image);
        $banner->delete();

        $this->activityLog->log('Menghapus banner', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.media.banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }
}
