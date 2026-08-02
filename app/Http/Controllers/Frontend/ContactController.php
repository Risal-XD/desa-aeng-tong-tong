<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactMessageRequest;
use App\Services\MessageService;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function __construct(
        private readonly ProfileService $profileService,
        private readonly MessageService $messages,
    ) {}

    public function index(): View
    {
        $village = $this->profileService->getPublicVillage();

        return view('frontend.contact.index', compact('village'));
    }

    public function store(ContactMessageRequest $request): RedirectResponse
    {
        $this->messages->store($request->validated());

        return back()->with('success', 'Pesan berhasil dikirim. Terima kasih telah menghubungi kami.');
    }
}
