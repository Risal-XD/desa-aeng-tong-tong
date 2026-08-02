<?php

declare(strict_types=1);

namespace App\Enums;

enum StatisticCategory: string
{
    case POPULATION = 'kependudukan';
    case EDUCATION = 'pendidikan';
    case HEALTH = 'kesehatan';
    case ECONOMY = 'ekonomi';
    case SOCIAL = 'sosial';
    case OTHER = 'lainnya';

    public function label(): string
    {
        return match ($this) {
            self::POPULATION => 'Kependudukan',
            self::EDUCATION => 'Pendidikan',
            self::HEALTH => 'Kesehatan',
            self::ECONOMY => 'Ekonomi',
            self::SOCIAL => 'Sosial',
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
