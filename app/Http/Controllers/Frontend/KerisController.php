<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\KerisArtisan;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class KerisController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $artisans = KerisArtisan::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        $heroImage = Cache::remember('frontend.keris.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->first()?->image);

        return view('frontend.keris.index', compact('village', 'artisans', 'heroImage'));
    }

    public function show(KerisArtisan $keris_artisan): View
    {
        abort_unless($keris_artisan->is_active, 404);

        $village = $this->profileService->getPublicVillage();

        return view('frontend.keris.show', compact('village', 'keris_artisan'));
    }
}
