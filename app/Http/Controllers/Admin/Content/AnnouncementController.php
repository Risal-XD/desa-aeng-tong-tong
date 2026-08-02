<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Content;

use App\Enums\AnnouncementStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AnnouncementRequest;
use App\Models\Announcement;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Announcement::class);

        $announcements = Announcement::query()
            ->with('author')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.content.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        $this->authorize('create', Announcement::class);

        $village = $this->villageService->getDefaultVillage();
        $statuses = AnnouncementStatus::options();

        return view('admin.content.announcements.create', compact('village', 'statuses'));
    }

    public function store(AnnouncementRequest $request): RedirectResponse
    {
        $this->authorize('create', Announcement::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except('attachment');
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['attachment'] = $request->hasFile('attachment') ? $this->upload->store($request->file('attachment'), 'documents/announcements') : null;
        $data['published_at'] = $request->filled('published_at') ? $request->input('published_at') : now();

        $announcement = Announcement::create($data);

        $this->activityLog->log('Menambahkan pengumuman', 'created', $announcement, ['title' => $announcement->title]);

        return redirect()->route('admin.content.announcements.index')
            ->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function edit(Announcement $announcement): View
    {
        $this->authorize('update', $announcement);

        $village = $this->villageService->getDefaultVillage();
        $statuses = AnnouncementStatus::options();

        return view('admin.content.announcements.edit', compact('village', 'announcement', 'statuses'));
    }

    public function update(AnnouncementRequest $request, Announcement $announcement): RedirectResponse
    {
        $this->authorize('update', $announcement);

        $data = $request->safe()->except('attachment');
        $data['published_at'] = $request->filled('published_at') ? $request->input('published_at') : $announcement->published_at ?? now();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $this->upload->replace($announcement->attachment, $request->file('attachment'), 'documents/announcements');
        }

        $announcement->update($data);

        $this->activityLog->log('Memperbarui pengumuman', 'updated', $announcement, ['title' => $announcement->title]);

        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $this->authorize('delete', $announcement);

        $title = $announcement->title;

        $this->upload->delete($announcement->attachment);
        $announcement->delete();

        $this->activityLog->log('Menghapus pengumuman', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.content.announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }
}
