<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\System\SettingUpdateRequest;
use App\Models\Setting;
use App\Services\ActivityLogService;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly SettingService $settings,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        return view('admin.service.contacts.edit', [
            'contact' => $this->settings->allByGroup('contact'),
            'sosmed' => $this->settings->allByGroup('sosmed'),
        ]);
    }

    public function update(SettingUpdateRequest $request): RedirectResponse
    {
        $this->authorize('update', new Setting);

        $this->settings->setMany($request->validated('contact') ?? [], 'contact');
        $this->settings->setMany($request->validated('sosmed') ?? [], 'sosmed');

        $this->activityLog->log('Memperbarui kontak desa', 'updated', null);

        return back()->with('success', 'Informasi kontak desa berhasil disimpan.');
    }
}
