<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Content;

use App\Enums\NewsStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\NewsRequest;
use App\Models\News;
use App\Models\NewsCategory;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', News::class);

        $news = News::query()
            ->with(['category', 'author'])
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.content.news.index', compact('news'));
    }

    public function create(): View
    {
        $this->authorize('create', News::class);

        $village = $this->villageService->getDefaultVillage();
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        $statuses = NewsStatus::options();

        return view('admin.content.news.create', compact('village', 'categories', 'statuses'));
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        $this->authorize('create', News::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except(['cover_image', 'thumbnail', 'tags']);
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['tags'] = $this->normalizeTags($request);
        $data['cover_image'] = $request->hasFile('cover_image') ? $this->upload->store($request->file('cover_image'), 'images/news') : null;
        $data['thumbnail'] = $request->hasFile('thumbnail') ? $this->upload->store($request->file('thumbnail'), 'images/news') : null;
        $data['published_at'] = $request->filled('published_at') ? $request->input('published_at') : now();

        $news = News::create($data);

        $this->activityLog->log('Menambahkan berita', 'created', $news, ['title' => $news->title]);

        return redirect()->route('admin.content.news.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news): View
    {
        $this->authorize('update', $news);

        $village = $this->villageService->getDefaultVillage();
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        $statuses = NewsStatus::options();

        return view('admin.content.news.edit', compact('village', 'news', 'categories', 'statuses'));
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        $this->authorize('update', $news);

        $data = $request->safe()->except(['cover_image', 'thumbnail', 'tags']);
        $data['tags'] = $this->normalizeTags($request);
        $data['published_at'] = $request->filled('published_at') ? $request->input('published_at') : $news->published_at ?? now();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload->replace($news->cover_image, $request->file('cover_image'), 'images/news');
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->upload->replace($news->thumbnail, $request->file('thumbnail'), 'images/news');
        }

        $news->update($data);

        $this->activityLog->log('Memperbarui berita', 'updated', $news, ['title' => $news->title]);

        return back()->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news): RedirectResponse
    {
        $this->authorize('delete', $news);

        $title = $news->title;

        $this->upload->delete($news->cover_image);
        $this->upload->delete($news->thumbnail);
        $news->delete();

        $this->activityLog->log('Menghapus berita', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.content.news.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function normalizeTags(NewsRequest $request): ?array
    {
        if (! $request->filled('tags')) {
            return null;
        }

        return collect(explode(',', (string) $request->input('tags')))
            ->map(fn (string $tag): string => trim($tag))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
