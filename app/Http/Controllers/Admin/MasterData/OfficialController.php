<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MasterData\OfficialRequest;
use App\Models\OrganizationalStructure;
use App\Models\Village;
use App\Models\VillageOfficial;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OfficialController extends Controller
{
    public function __construct(
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', VillageOfficial::class);

        $village = Village::query()->orderBy('id')->first();
        $officials = VillageOfficial::query()
            ->with('structure')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.master-data.officials.index', compact('village', 'officials'));
    }

    public function create(): View
    {
        $this->authorize('create', VillageOfficial::class);

        $village = Village::query()->orderBy('id')->first();
        $structures = OrganizationalStructure::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.master-data.officials.create', compact('village', 'structures'));
    }

    public function store(OfficialRequest $request): RedirectResponse
    {
        $this->authorize('create', VillageOfficial::class);

        $village = Village::query()->orderBy('id')->first();

        $data = $request->safe()->except('photo');
        $data['village_id'] = $village?->getKey();
        $data['photo'] = $request->hasFile('photo') ? $this->upload->store($request->file('photo'), 'images/officials') : null;
        $data['is_active'] = $request->boolean('is_active', true);

        $official = VillageOfficial::create($data);

        $this->activityLog->log('Menambahkan perangkat desa', 'created', $official, ['name' => $official->name]);

        return redirect()->route('admin.master-data.officials.index')
            ->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function edit(VillageOfficial $official): View
    {
        $this->authorize('update', $official);

        $village = Village::query()->orderBy('id')->first();
        $structures = OrganizationalStructure::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admin.master-data.officials.edit', compact('village', 'official', 'structures'));
    }

    public function update(OfficialRequest $request, VillageOfficial $official): RedirectResponse
    {
        $this->authorize('update', $official);

        $data = $request->safe()->except('photo');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->upload->replace($official->photo, $request->file('photo'), 'images/officials');
        }

        $official->update($data);

        $this->activityLog->log('Memperbarui perangkat desa', 'updated', $official, ['name' => $official->name]);

        return back()->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    public function destroy(VillageOfficial $official): RedirectResponse
    {
        $this->authorize('delete', $official);

        $name = $official->name;

        $this->upload->delete($official->photo);
        $official->delete();

        $this->activityLog->log('Menghapus perangkat desa', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.master-data.officials.index')
            ->with('success', 'Perangkat desa berhasil dihapus.');
    }
}
