<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Message;
use App\Models\Village;

class MessageService
{
    /**
     * Menyimpan pesan baru dari formulir kontak publik.
     *
     * @param  array<string, mixed>  $data
     */
    public function store(array $data): Message
    {
        $village = Village::query()->orderBy('id')->first();

        return Message::create([
            'village_id' => $village?->getKey(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'baru',
        ]);
    }

    public function markRead(Message $message): void
    {
        if ($message->status->value === 'baru') {
            $message->update(['status' => 'dibaca']);
        }
    }

    public function reply(Message $message, string $reply): void
    {
        $message->update([
            'status' => 'dibalas',
            'reply' => $reply,
            'replied_at' => now(),
            'user_id' => auth()->id(),
        ]);
    }
}
