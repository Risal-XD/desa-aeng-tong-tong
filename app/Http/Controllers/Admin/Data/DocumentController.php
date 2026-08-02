<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Data;

use App\Enums\DocumentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\DocumentRequest;
use App\Models\Document;
use App\Services\ActivityLogService;
use App\Services\UploadService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Document::class);

        $documents = Document::query()
            ->with('author')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('admin.data-report.documents.index', compact('documents'));
    }

    public function create(): View
    {
        $this->authorize('create', Document::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.data-report.documents.create', compact('village'));
    }

    public function store(DocumentRequest $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $file = $request->file('file');
        $filePath = $this->upload->store($file, 'documents');

        $document = Document::create(array_merge(
            $request->safe()->except('file'),
            [
                'village_id' => $village->getKey(),
                'user_id' => auth()->id(),
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $this->humanFileSize($file->getSize()),
                'file_type' => $file->getClientMimeType(),
                'published_at' => $request->input('status') === DocumentStatus::PUBLISHED->value ? now() : null,
            ],
        ));

        $this->activityLog->log('Menambahkan dokumen', 'created', $document, ['title' => $document->title]);

        return redirect()->route('admin.data-report.documents.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function edit(Document $document): View
    {
        $this->authorize('update', $document);

        return view('admin.data-report.documents.edit', compact('document'));
    }

    public function update(DocumentRequest $request, Document $document): RedirectResponse
    {
        $this->authorize('update', $document);

        $data = $request->safe()->except('file');
        $data['published_at'] = $request->input('status') === DocumentStatus::PUBLISHED->value
            ? ($document->published_at ?? now())
            : null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $data['file_path'] = $this->upload->replace($document->file_path, $file, 'documents');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $this->humanFileSize($file->getSize());
            $data['file_type'] = $file->getClientMimeType();
        }

        $document->update($data);

        $this->activityLog->log('Memperbarui dokumen', 'updated', $document, ['title' => $document->title]);

        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        $title = $document->title;

        $this->upload->delete($document->file_path);
        $document->delete();

        $this->activityLog->log('Menghapus dokumen', 'deleted', null, ['title' => $title]);

        return redirect()->route('admin.data-report.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    private function humanFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $index = 0;

        while ($bytes >= 1024 && $index < count($units) - 1) {
            $bytes /= 1024;
            $index++;
        }

        return round($bytes, 2).' '.$units[$index];
    }
}
