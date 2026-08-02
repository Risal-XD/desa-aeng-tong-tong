<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Services\ProfileService;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();
        $categories = NewsCategory::where('is_active', true)->orderBy('name')->get();
        $news = News::published()
            ->with(['category', 'author'])
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.news.index', compact('village', 'categories', 'news'));
    }

    public function show(News $news): View
    {
        abort_unless($news->status === 'published' && ($news->published_at === null || $news->published_at->lte(now())), 404);

        $village = $this->profileService->getPublicVillage();

        if (session()->missing('news_viewed_'.$news->getKey())) {
            $news->increment('views_count');
            session()->put('news_viewed_'.$news->getKey(), true);
        }

        $related = News::published()
            ->whereKeyNot($news->getKey())
            ->when($news->news_category_id, fn ($q) => $q->where('news_category_id', $news->news_category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('frontend.news.show', compact('village', 'news', 'related'));
    }
}
