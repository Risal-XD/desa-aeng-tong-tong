<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\FaqRequest;
use App\Models\Faq;
use App\Services\ActivityLogService;
use App\Services\VillageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        private readonly VillageService $villageService,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $this->authorize('viewAny', Faq::class);

        $faqs = Faq::query()
            ->with('author')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(15);

        return view('admin.content.faqs.index', compact('faqs'));
    }

    public function create(): View
    {
        $this->authorize('create', Faq::class);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.content.faqs.create', compact('village'));
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $this->authorize('create', Faq::class);

        $village = $this->villageService->getDefaultVillage();
        abort_unless($village !== null, 404, 'Data desa belum tersedia.');

        $data = $request->safe()->all();
        $data['village_id'] = $village->getKey();
        $data['user_id'] = auth()->id();
        $data['is_active'] = $request->boolean('is_active', true);

        $faq = Faq::create($data);

        $this->activityLog->log('Menambahkan FAQ', 'created', $faq, ['question' => $faq->question]);

        return redirect()->route('admin.content.faqs.index')
            ->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq): View
    {
        $this->authorize('update', $faq);

        $village = $this->villageService->getDefaultVillage();

        return view('admin.content.faqs.edit', compact('village', 'faq'));
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $this->authorize('update', $faq);

        $data = $request->safe()->all();
        $data['is_active'] = $request->boolean('is_active', true);

        $faq->update($data);

        $this->activityLog->log('Memperbarui FAQ', 'updated', $faq, ['question' => $faq->question]);

        return back()->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $this->authorize('delete', $faq);

        $question = $faq->question;

        $faq->delete();

        $this->activityLog->log('Menghapus FAQ', 'deleted', null, ['question' => $question]);

        return redirect()->route('admin.content.faqs.index')
            ->with('success', 'FAQ berhasil dihapus.');
    }
}
