<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Services\ProfileService;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $categories = GalleryCategory::where('is_active', true)->orderBy('name')->get();
        $galleries = Gallery::active()
            ->with('category')
            ->orderBy('is_cover', 'desc')
            ->latest('id')
            ->paginate(12);

        return view('frontend.galleries.index', compact('village', 'categories', 'galleries'));
    }
}
