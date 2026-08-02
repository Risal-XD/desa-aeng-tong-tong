<?php

declare(strict_types=1);

namespace App\Enums;

enum MessageStatus: string
{
    case BARU = 'baru';
    case DIBACA = 'dibaca';
    case DIBALAS = 'dibalas';

    public function label(): string
    {
        return match ($this) {
            self::BARU => 'Baru',
            self::DIBACA => 'Dibaca',
            self::DIBALAS => 'Dibalas',
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::BARU => 'bg-amber-100 text-amber-800',
            self::DIBACA => 'bg-sky-100 text-sky-800',
            self::DIBALAS => 'bg-emerald-100 text-emerald-800',
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
