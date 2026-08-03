<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    public function test_format_rupiah_dengan_simbol(): void
    {
        $this->assertSame('Rp 1.250.000', format_rupiah(1250000));
        $this->assertSame('Rp 0', format_rupiah(0));
    }

    public function test_format_rupiah_tanpa_simbol(): void
    {
        $this->assertSame('1.250.000', format_rupiah(1250000, false));
    }

    public function test_format_rupiah_menerima_float(): void
    {
        $this->assertSame('Rp 1.000', format_rupiah(999.7));
    }

    public function test_format_tanggal_kosong_mengembalikan_tanda_strip(): void
    {
        $this->assertSame('-', format_tanggal(null));
        $this->assertSame('-', format_tanggal(''));
    }

    public function test_format_tanggal_menghasilkan_tanggal_indonesia(): void
    {
        $this->assertSame('01 Januari 2026', format_tanggal('2026-01-01'));
        $this->assertSame('17 Agustus 1945', format_tanggal('1945-08-17'));
    }

    public function test_limit_words_memotong_teks(): void
    {
        $text = 'satu dua tiga empat lima enam';

        $this->assertSame('satu dua tiga...', limit_words($text, 3));
        $this->assertSame($text, limit_words($text, 20));
    }

    public function test_slug_unik_mengubah_spasi_menjadi_pemisah(): void
    {
        $this->assertSame('desa-aeng-tong-tong', slug_unik('Desa Aeng Tong-Tong'));
        $this->assertSame('a-b-c', slug_unik('a b c', '-'));
    }

    public function test_slug_unik_fallback_saat_hasil_kosong(): void
    {
        $slug = slug_unik('!!!');

        $this->assertNotEmpty($slug);
        $this->assertSame(8, Str::length($slug));
    }
}
