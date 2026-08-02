<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Services\ProfileService;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $announcements = Announcement::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.announcements.index', compact('village', 'announcements'));
    }

    public function show(Announcement $announcement): View
    {
        abort_unless($announcement->status === 'published' && ($announcement->published_at === null || $announcement->published_at->lte(now())), 404);

        $village = $this->profileService->getPublicVillage();

        return view('frontend.announcements.show', compact('village', 'announcement'));
    }
}
