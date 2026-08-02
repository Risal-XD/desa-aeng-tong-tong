<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function sejarah(): View
    {
        $village = $this->profileService->getPublicVillage();

        return view('frontend.about.sejarah', compact('village'));
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
