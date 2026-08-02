<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Download;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();

        $documents = Document::published()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12);

        return view('frontend.documents.index', compact('village', 'documents'));
    }

    public function download(Document $document): StreamedResponse
    {
        abort_unless(
            $document->status === DocumentStatus::PUBLISHED
                && ($document->published_at === null || $document->published_at->lte(now())),
            404,
        );

        $document->increment('download_count');

        Download::create([
            'document_id' => $document->getKey(),
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'downloaded_at' => now(),
        ]);

        if (! Storage::disk('public')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($document->file_path, $document->file_name);
    }
}
