<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

if (! function_exists('format_rupiah')) {
    /**
     * Format angka menjadi Rupiah Indonesia.
     */
    function format_rupiah(int|float $amount, bool $withSymbol = true): string
    {
        $formatted = number_format((float) $amount, 0, ',', '.');

        return $withSymbol ? "Rp {$formatted}" : $formatted;
    }
}

if (! function_exists('format_tanggal')) {
    /**
     * Format tanggal dalam Bahasa Indonesia.
     */
    function format_tanggal(string|null $date, string $format = 'd F Y'): string
    {
        if (! $date) {
            return '-';
        }

        return Carbon::parse($date)->translatedFormat($format);
    }
}

if (! function_exists('limit_words')) {
    /**
     * Memotong teks berdasarkan jumlah kata.
     */
    function limit_words(string $text, int $limit = 30, string $end = '...'): string
    {
        return Str::words($text, $limit, $end);
    }
}

if (! function_exists('slug_unik')) {
    /**
     * Membuat slug unik dengan fallback acak.
     */
    function slug_unik(string $value, string $separator = '-'): string
    {
        $slug = Str::slug($value, $separator);

        if (empty($slug)) {
            $slug = Str::lower(Str::random(8));
        }

        return $slug;
    }
}
