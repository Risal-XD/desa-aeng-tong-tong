<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Economy;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Economy\TourismDestinationRequest;
use App\Models\TourismDestination;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TourismController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', TourismDestination::class);

        $destinations = TourismDestination::query()
            ->with('author')
            ->orderBy('is_featured', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.economy.tourism.index', compact('destinations'));
    }

    public function create(): View
    {
        $this->authorize('create', TourismDestination::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.tourism.create', compact('village'));
    }

    public function store(TourismDestinationRequest $request): RedirectResponse
    {
        $this->authorize('create', TourismDestination::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->except(['image', 'gallery']);
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['image'] = $request->hasFile('image') ? $this->upload->store($request->file('image'), 'images/tourism') : null;
        $data['gallery'] = $this->uploadGallery($request);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        $destination = TourismDestination::create($data);

        $this->activityLog->log('Menambahkan destinasi wisata', 'created', $destination, ['title' => $destination->title]);

        return redirect()->route('admin.economy.tourism.index')
            ->with('success', 'Destinasi wisata berhasil ditambahkan.');
    }

    public function edit(TourismDestination $tourism_destination): View
    {
        $this->authorize('update', $tourism_destination);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.economy.tourism.edit', compact('village', 'tourism_destination'));
    }

    public function update(TourismDestinationRequest $request, TourismDestination $tourism_destination): RedirectResponse
    {
        $this->authorize('update', $tourism_destination);

        $data = $request->safe()->except(['image', 'gallery']);
        $data['is_featured'] = $request->boolean('is_featured', false);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload->replace($tourism_destination->image, $request->file('image'), 'images/tourism');
        }

        if ($request->hasFile('gallery')) {
            $this->uploadGallery($request, $tourism_destination);
        }

        $tourism_destination->update($data);

        $this->activityLog->log('Memperbarui destinasi wisata', 'updated', $tourism_destination, ['title' => $tourism_destination->title]);

        return back()->with('success', 'Destinasi wisata berhasil diperbarui.');
    }

    public function destroy(TourismDestination $tourism_destination): RedirectResponse
    {
        $this->authorize('delete', $tourism_destination);

        $title = $tourism_destination->title;

        $this->upload->delete($tourism_destination->image);
        $tourism_destination->delete();

        $this->activityLog->log('Menghapus destinasi wisata', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.economy.tourism.index')
            ->with('success', 'Destinasi wisata berhasil dihapus.');
    }

    private function uploadGallery(TourismDestinationRequest $request, ?TourismDestination $destination = null): ?array
    {
        if (! $request->hasFile('gallery')) {
            return $destination?->gallery ?? null;
        }

        $paths = [];

        foreach ($request->file('gallery') as $file) {
            $paths[] = $this->upload->store($file, 'images/tourism/gallery');
        }

        $existing = $destination?->gallery ?? [];

        return array_values(array_merge($existing, $paths));
    }
}
