<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\View\View;

class PotentialController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $potentials = $village?->potentials ?? collect();

        return view('frontend.potential.index', compact('village', 'potentials'));
    }
}
