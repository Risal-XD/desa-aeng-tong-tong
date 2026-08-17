<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System\SettingUpdateRequest;
use App\Models\Setting;
use App\Services\ActivityLogService;
use App\Services\SettingService;
use App\Services\UploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingService $settings,
        private readonly UploadService $upload,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        return view('admin.system.settings.edit', [
            'general' => $this->settings->allByGroup('general'),
            'seo' => $this->settings->allByGroup('seo'),
            'contact' => $this->settings->allByGroup('contact'),
            'sosmed' => $this->settings->allByGroup('sosmed'),
        ]);
    }

    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        $this->authorize('update', new Setting);

        if ($request->hasFile('general.site_logo')) {
            $path = $this->upload->store($request->file('general.site_logo'), 'images/settings');
            $this->settings->set('site_logo', $path, 'general', 'string');
        }

        if ($request->hasFile('general.ebooklet_cover')) {
            $path = $this->upload->store($request->file('general.ebooklet_cover'), 'images/settings');
            $this->settings->set('ebooklet_cover', $path, 'general', 'string');
        }

        if ($request->hasFile('general.ebooklet_pdf')) {
            $path = $this->upload->store($request->file('general.ebooklet_pdf'), 'documents');
            $this->settings->set('ebooklet_pdf', $path, 'general', 'string');
        }

        foreach (['general', 'seo', 'contact', 'sosmed'] as $group) {
            $values = $request->validated($group) ?? [];
            unset($values['site_logo'], $values['ebooklet_cover'], $values['ebooklet_pdf']);
            $this->settings->setMany($values, $group);
        }

        $this->activityLog->log('Memperbarui pengaturan website', 'updated', null, ['group' => implode(', ', ['general', 'seo', 'contact', 'sosmed'])]);

        return back()->with('success', 'Pengaturan website berhasil disimpan.');
    }
}
