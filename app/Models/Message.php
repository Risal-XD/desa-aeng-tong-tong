<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'village_id',
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'reply',
        'replied_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => MessageStatus::class,
            'replied_at' => 'datetime',
        ];
    }

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('id');
    }

    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('status', MessageStatus::BARU->value);
    }

    public function isReplied(): bool
    {
        return $this->status === MessageStatus::DIBALAS && filled($this->reply);
    }
}
