<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function sejarah(): View
    {
        $village = $this->profileService->getPublicVillage();
        $heroImage = 'images/kerisbg.png';

        return view('frontend.about.sejarah', compact('village', 'heroImage'));
    }

    public function visiMisi(): View
    {
        $village = $this->profileService->getPublicVillage();
        $heroImage = Cache::remember('frontend.visi_misi.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->first()?->image);

        return view('frontend.about.visi-misi', compact('village', 'heroImage'));
    }

    public function struktur(): View
    {
        $village = $this->profileService->getPublicVillage();
        $structureTree = $village ? $this->profileService->buildStructureTree($village) : collect();
        $heroImage = Cache::remember('frontend.struktur.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->first()?->image);

        return view('frontend.about.struktur', compact('village', 'structureTree', 'heroImage'));
    }

    public function perangkat(): View
    {
        $village = $this->profileService->getPublicVillage();
        $groups = $village ? $this->profileService->groupOfficialsByStructure($village) : [];
        $heroImage = Cache::remember('frontend.perangkat.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->first()?->image);

        return view('frontend.about.perangkat', compact('village', 'groups', 'heroImage'));
    }
}
