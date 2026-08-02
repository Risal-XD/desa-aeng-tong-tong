<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class ActivityLogService
{
    /**
     * Mencatat aktivitas pengguna ke tabel activity_logs.
     */
    public function log(
        string $description,
        ?string $event = null,
        ?Model $subject = null,
        array $properties = [],
        string $logName = 'default',
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'log_name' => $logName,
            'description' => $description,
            'event' => $event,
            'subject_type' => $subject ? $subject->getMorphClass() : null,
            'subject_id' => $subject?->getKey(),
            'properties' => $properties,
            'created_at' => now(),
        ]);
    }
}
