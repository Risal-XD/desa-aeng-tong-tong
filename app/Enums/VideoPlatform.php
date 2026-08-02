<?php

declare(strict_types=1);

namespace App\Enums;

enum VideoPlatform: string
{
    case YOUTUBE = 'youtube';
    case VIMEO = 'vimeo';
    case OTHER = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::YOUTUBE => 'YouTube',
            self::VIMEO => 'Vimeo',
            self::OTHER => 'Lainnya',
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
