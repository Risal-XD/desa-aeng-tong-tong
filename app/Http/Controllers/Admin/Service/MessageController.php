<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Service;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\MessageReplyRequest;
use App\Models\Message;
use App\Services\ActivityLogService;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct(
        private readonly MessageService $messages,
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(Request $request): View
    {
        $this->authorize('viewAny', Message::class);

        $messages = Message::query()
            ->newest()
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = '%'.$request->string('search').'%';

                $query->where(fn ($q) => $q->where('name', 'like', $search)
                    ->orWhere('email', 'like', $search)
                    ->orWhere('subject', 'like', $search));
            })
            ->paginate(15)
            ->withQueryString();

        $statusOptions = MessageStatus::options();

        return view('admin.service.messages.index', compact('messages', 'statusOptions'));
    }

    public function show(Message $message): View
    {
        $this->authorize('view', $message);

        $this->messages->markRead($message);

        return view('admin.service.messages.show', compact('message'));
    }

    public function update(MessageReplyRequest $request, Message $message): RedirectResponse
    {
        $this->authorize('update', $message);

        $this->messages->reply($message, $request->validated('reply'));

        $this->activityLog->log('Membalas pesan masuk', 'updated', $message, ['subject' => $message->subject]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
