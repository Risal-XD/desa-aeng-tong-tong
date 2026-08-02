<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $featuredPotentials = $this->profileService->getFeaturedPotentials(3);

        return view('frontend.home.index', [
            'village' => $village,
            'featuredPotentials' => $featuredPotentials,
        ]);
    }
}
