<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Services\ProfileService;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $agendas = Agenda::published()
            ->with('author')
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->where('event_date', '>=', now()->startOfDay())
            ->paginate(12);

        return view('frontend.agendas.index', compact('village', 'agendas'));
    }
}
