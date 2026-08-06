<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Umkm;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class UmkmController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $umkms = Umkm::active()
            ->orderBy('is_featured', 'desc')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12);
        $heroImage = 'images/kerisbg.png';

        return view('frontend.umkms.index', compact('village', 'umkms', 'heroImage'));
    }

    public function show(Umkm $umkm): View
    {
        abort_unless($umkm->is_active, 404);

        $village = $this->profileService->getPublicVillage();

        return view('frontend.umkms.show', compact('village', 'umkm'));
    }
}
