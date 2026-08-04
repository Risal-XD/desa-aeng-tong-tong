<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\TourismDestination;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class TourismController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $destinations = TourismDestination::active()
            ->orderBy('is_featured', 'desc')
            ->latest('id')
            ->paginate(9);
        $heroImage = Cache::remember('frontend.tourism.hero_image', 300, fn () => Gallery::active()
            ->whereNotNull('image')
            ->first()?->image);

        return view('frontend.tourism.index', compact('village', 'destinations', 'heroImage'));
    }

    public function show(TourismDestination $tourism_destination): View
    {
        abort_unless($tourism_destination->is_active, 404);

        $village = $this->profileService->getPublicVillage();

        if (session()->missing('tourism_viewed_'.$tourism_destination->getKey())) {
            $tourism_destination->increment('views_count');
            session()->put('tourism_viewed_'.$tourism_destination->getKey(), true);
        }

        $related = TourismDestination::active()
            ->whereKeyNot($tourism_destination->getKey())
            ->when($tourism_destination->category, fn ($q) => $q->where('category', $tourism_destination->category))
            ->latest('id')
            ->limit(3)
            ->get();

        return view('frontend.tourism.show', compact('village', 'tourism_destination', 'related'));
    }
}
