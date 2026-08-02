<?php

declare(strict_types=1);

namespace App\Enums;

enum ApbdesType: string
{
    case INCOME = 'pendapatan';
    case EXPENSE = 'belanja';
    case FINANCING = 'pembiayaan';

    public function label(): string
    {
        return match ($this) {
            self::INCOME => 'Pendapatan',
            self::EXPENSE => 'Belanja',
            self::FINANCING => 'Pembiayaan',
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
