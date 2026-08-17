<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Data;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Data\EBookletUpdateRequest;
use App\Models\Setting;
use App\Services\ActivityLogService;
use App\Services\SettingService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EBookletController extends Controller
{
    public function __construct(
        private readonly SettingService $settings,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        return view('admin.data-report.ebooklet.edit', [
            'ebookletCover' => $this->settings->get('ebooklet_cover'),
            'ebookletPdf' => $this->settings->get('ebooklet_pdf'),
        ]);
    }

    public function update(EBookletUpdateRequest $request): RedirectResponse
    {
        $this->authorize('update', new Setting);

        if ($request->hasFile('ebooklet_cover')) {
            $path = $this->upload->store($request->file('ebooklet_cover'), 'images/settings');
            $this->settings->set('ebooklet_cover', $path, 'general', 'string');
        }

        if ($request->hasFile('ebooklet_pdf')) {
            $path = $this->upload->store($request->file('ebooklet_pdf'), 'documents');
            $this->settings->set('ebooklet_pdf', $path, 'general', 'string');
        }

        $this->activityLog->log('Memperbarui e-booklet', 'updated', null);

        return back()->with('success', 'E-booklet berhasil disimpan.');
    }
}