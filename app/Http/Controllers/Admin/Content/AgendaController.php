<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Content;

use App\Enums\AgendaStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\AgendaRequest;
use App\Models\Agenda;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Agenda::class);

        $agendas = Agenda::query()
            ->with('author')
            ->orderBy('event_date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.content.agendas.index', compact('agendas'));
    }

    public function create(): View
    {
        $this->authorize('create', Agenda::class);

        $village = $this->villageService->getDefaultVillage();
        $statuses = AgendaStatus::options();

        return view('admin.content.agendas.create', compact('village', 'statuses'));
    }

    public function store(AgendaRequest $request): RedirectResponse
    {
        $this->authorize('create', Agenda::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->all();
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured', false);

        $agenda = Agenda::create($data);

        $this->activityLog->log('Menambahkan agenda', 'created', $agenda, ['title' => $agenda->title]);

        return redirect()->route('admin.content.agendas.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda): View
    {
        $this->authorize('update', $agenda);

        $village = $this->villageService->getDefaultVillage();
        $statuses = AgendaStatus::options();

        return view('admin.content.agendas.edit', compact('village', 'agenda', 'statuses'));
    }

    public function update(AgendaRequest $request, Agenda $agenda): RedirectResponse
    {
        $this->authorize('update', $agenda);

        $data = $request->safe()->all();
        $data['is_featured'] = $request->boolean('is_featured', false);

        $agenda->update($data);

        $this->activityLog->log('Memperbarui agenda', 'updated', $agenda, ['title' => $agenda->title]);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $this->authorize('delete', $agenda);

        $title = $agenda->title;

        $agenda->delete();

        $this->activityLog->log('Menghapus agenda', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.content.agendas.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}
