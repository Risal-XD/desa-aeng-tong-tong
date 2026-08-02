<?php

declare(strict_types=1);

namespace App\Enums;

enum AnnouncementStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draf',
            self::PUBLISHED => 'Terbit',
            self::SCHEDULED => 'Terjadwal',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
