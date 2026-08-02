<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MasterData\VillageRequest;
use App\Models\Village;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VillageController extends Controller
{
    public function __construct(
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Village::class);

        $villages = Village::query()
            ->withCount(['potentials', 'officials'])
            ->orderBy('id')
            ->paginate(10);

        return view('admin.master-data.villages.index', compact('villages'));
    }

    public function create(): View
    {
        $this->authorize('create', Village::class);

        return view('admin.master-data.villages.create');
    }

    public function store(VillageRequest $request): RedirectResponse
    {
        $this->authorize('create', Village::class);

        $data = $request->safe()->except(['logo', 'cover_image']);

        $data['logo'] = $request->hasFile('logo') ? $this->upload->store($request->file('logo'), 'images/villages') : null;
        $data['cover_image'] = $request->hasFile('cover_image') ? $this->upload->store($request->file('cover_image'), 'images/villages') : null;

        $village = Village::create($data);

        $this->activityLog->log('Menambahkan data desa', 'created', $village, ['name' => $village->name]);

        return redirect()->route('admin.master-data.villages.index')
            ->with('success', 'Data desa berhasil ditambahkan.');
    }

    public function edit(Village $village): View
    {
        $this->authorize('update', $village);

        return view('admin.master-data.villages.edit', compact('village'));
    }

    public function update(VillageRequest $request, Village $village): RedirectResponse
    {
        $this->authorize('update', $village);

        $data = $request->safe()->except(['logo', 'cover_image']);

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->upload->replace($village->logo, $request->file('logo'), 'images/villages');
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->upload->replace($village->cover_image, $request->file('cover_image'), 'images/villages');
        }

        $village->update($data);

        $this->activityLog->log('Memperbarui data desa', 'updated', $village, ['name' => $village->name]);

        return back()->with('success', 'Data desa berhasil diperbarui.');
    }

    public function destroy(Village $village): RedirectResponse
    {
        $this->authorize('delete', $village);

        $name = $village->name;

        $this->upload->delete($village->logo);
        $this->upload->delete($village->cover_image);

        $village->delete();

        $this->activityLog->log('Menghapus data desa', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.master-data.villages.index')
            ->with('success', 'Data desa berhasil dihapus.');
    }
}
