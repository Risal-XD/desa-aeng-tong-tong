<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Media;

use App\Enums\VideoPlatform;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Media\VideoRequest;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Video::class);

        $videos = Video::query()
            ->with(['category', 'author'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.media.videos.index', compact('videos'));
    }

    public function create(): View
    {
        $this->authorize('create', Video::class);

        $village = $this->villageService->getDefaultVillage();
        $categories = VideoCategory::where('is_active', true)->orderBy('name')->get();
        $platforms = VideoPlatform::options();

        return view('admin.media.videos.create', compact('village', 'categories', 'platforms'));
    }

    public function store(VideoRequest $request): RedirectResponse
    {
        $this->authorize('create', Video::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except('thumbnail');
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['thumbnail'] = $request->hasFile('thumbnail') ? $this->upload->store($request->file('thumbnail'), 'images/videos') : null;
        $data['is_active'] = $request->boolean('is_active', true);

        $video = Video::create($data);

        $this->activityLog->log('Menambahkan video', 'created', $video, ['title' => $video->title]);

        return redirect()->route('admin.media.videos.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function edit(Video $video): View
    {
        $this->authorize('update', $video);

        $village = $this->villageService->getDefaultVillage();
        $categories = VideoCategory::where('is_active', true)->orderBy('name')->get();
        $platforms = VideoPlatform::options();

        return view('admin.media.videos.edit', compact('village', 'video', 'categories', 'platforms'));
    }

    public function update(VideoRequest $request, Video $video): RedirectResponse
    {
        $this->authorize('update', $video);

        $data = $request->safe()->except('thumbnail');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->upload->replace($video->thumbnail, $request->file('thumbnail'), 'images/videos');
        }

        $video->update($data);

        $this->activityLog->log('Memperbarui video', 'updated', $video, ['title' => $video->title]);

        return back()->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(Video $video): RedirectResponse
    {
        $this->authorize('delete', $video);

        $title = $video->title;

        $this->upload->delete($video->thumbnail);
        $video->delete();

        $this->activityLog->log('Menghapus video', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.media.videos.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
