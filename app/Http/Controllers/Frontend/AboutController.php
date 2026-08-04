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
        $heroImage = Cache::remember('frontend.sejarah.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->where('title', 'like', '%keris%')
            ->first()?->image);

        return view('frontend.about.sejarah', compact('village', 'heroImage'));
    }

    public function visiMisi(): View
    {
        $village = $this->profileService->getPublicVillage();

        return view('frontend.about.visi-misi', compact('village'));
    }

    public function struktur(): View
    {
        $village = $this->profileService->getPublicVillage();
        $structureTree = $village ? $this->profileService->buildStructureTree($village) : collect();

        return view('frontend.about.struktur', compact('village', 'structureTree'));
    }

    public function perangkat(): View
    {
        $village = $this->profileService->getPublicVillage();
        $groups = $village ? $this->profileService->groupOfficialsByStructure($village) : [];

        return view('frontend.about.perangkat', compact('village', 'groups'));
    }
}
