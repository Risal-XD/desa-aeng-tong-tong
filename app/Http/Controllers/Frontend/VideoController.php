<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Services\ProfileService;
use Illuminate\View\View;

class VideoController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $videos = Video::active()
            ->with('category')
            ->latest('id')
            ->paginate(12);

        return view('frontend.videos.index', compact('village', 'videos'));
    }
}
