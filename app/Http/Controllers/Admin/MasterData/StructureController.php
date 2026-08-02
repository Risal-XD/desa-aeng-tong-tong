<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MasterData\StructureRequest;
use App\Models\OrganizationalStructure;
use App\Models\Village;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StructureController extends Controller
{
    public function __construct(
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', OrganizationalStructure::class);

        $village = Village::query()->orderBy('id')->first();
        $structures = OrganizationalStructure::query()
            ->with('parent')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.master-data.structures.index', compact('village', 'structures'));
    }

    public function create(): View
    {
        $this->authorize('create', OrganizationalStructure::class);

        $village = Village::query()->orderBy('id')->first();
        $parents = OrganizationalStructure::query()
            ->whereKeyNot((int) $this->route('structure')?->getKey())
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.master-data.structures.create', compact('village', 'parents'));
    }

    public function store(StructureRequest $request): RedirectResponse
    {
        $this->authorize('create', OrganizationalStructure::class);

        $village = Village::query()->orderBy('id')->first();

        $data = $request->safe()->except('image');
        $data['village_id'] = $village?->getKey();
        $data['image'] = $request->hasFile('image') ? $this->upload->store($request->file('image'), 'images/structures') : null;
        $data['is_active'] = $request->boolean('is_active', true);

        $structure = OrganizationalStructure::create($data);

        $this->activityLog->log('Menambahkan struktur organisasi', 'created', $structure, ['name' => $structure->name]);

        return redirect()->route('admin.master-data.structures.index')
            ->with('success', 'Struktur organisasi berhasil ditambahkan.');
    }

    public function edit(OrganizationalStructure $structure): View
    {
        $this->authorize('update', $structure);

        $village = Village::query()->orderBy('id')->first();
        $parents = OrganizationalStructure::query()
            ->whereKeyNot($structure->getKey())
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.master-data.structures.edit', compact('village', 'structure', 'parents'));
    }

    public function update(StructureRequest $request, OrganizationalStructure $structure): RedirectResponse
    {
        $this->authorize('update', $structure);

        $data = $request->safe()->except('image');
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload->replace($structure->image, $request->file('image'), 'images/structures');
        }

        $structure->update($data);

        $this->activityLog->log('Memperbarui struktur organisasi', 'updated', $structure, ['name' => $structure->name]);

        return back()->with('success', 'Struktur organisasi berhasil diperbarui.');
    }

    public function destroy(OrganizationalStructure $structure): RedirectResponse
    {
        $this->authorize('delete', $structure);

        $name = $structure->name;

        $this->upload->delete($structure->image);
        $structure->delete();

        $this->activityLog->log('Menghapus struktur organisasi', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.master-data.structures.index')
            ->with('success', 'Struktur organisasi berhasil dihapus.');
    }
}
