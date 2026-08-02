<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\ApbdesRequest;
use App\Models\Apbdes;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApbdesController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Apbdes::class);

        $items = Apbdes::query()
            ->with('author')
            ->orderBy('year', 'desc')
            ->orderBy('type')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.data-report.apbdes.index', compact('items'));
    }

    public function create(): View
    {
        $this->authorize('create', Apbdes::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.data-report.apbdes.create', compact('village'));
    }

    public function store(ApbdesRequest $request): RedirectResponse
    {
        $this->authorize('create', Apbdes::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $item = Apbdes::create(array_merge(
            $request->safe()->all(),
            [
                'village_id' => $village->getKey(),
                'user_id' => auth()->id(),
                'is_active' => $request->boolean('is_active', true),
            ],
        ));

        $this->activityLog->log('Menambahkan pos APBDes', 'created', $item, ['name' => $item->name]);

        return redirect()->route('admin.data-report.apbdes.index')
            ->with('success', 'Pos APBDes berhasil ditambahkan.');
    }

    public function edit(Apbdes $apbdes): View
    {
        $this->authorize('update', $apbdes);

        return view('admin.data-report.apbdes.edit', compact('apbdes'));
    }

    public function update(ApbdesRequest $request, Apbdes $apbdes): RedirectResponse
    {
        $this->authorize('update', $apbdes);

        $apbdes->update(array_merge(
            $request->safe()->all(),
            ['is_active' => $request->boolean('is_active', true)],
        ));

        $this->activityLog->log('Memperbarui pos APBDes', 'updated', $apbdes, ['name' => $apbdes->name]);

        return back()->with('success', 'Pos APBDes berhasil diperbarui.');
    }

    public function destroy(Apbdes $apbdes): RedirectResponse
    {
        $this->authorize('delete', $apbdes);

        $name = $apbdes->name;

        $apbdes->delete();

        $this->activityLog->log('Menghapus pos APBDes', 'deleted', null, ['name' => $name]);

        return redirect()->route('admin.data-report.apbdes.index')
            ->with('success', 'Pos APBDes berhasil dihapus.');
    }
}
