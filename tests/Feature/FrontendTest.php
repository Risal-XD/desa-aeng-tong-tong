<?php

namespace Tests\Feature;

use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(VillageSeeder::class);
    }

    public function test_halaman_beranda_tampil(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Aeng Tong-Tong')
            ->assertSee('Sentra Kerajinan Keris');
    }

    public function test_halaman_tentang_desa_tampil(): void
    {
        $this->get(route('about.sejarah'))
            ->assertOk()
            ->assertSee('Sejarah');

        $this->get(route('about.visi-misi'))
            ->assertOk()
            ->assertSee('Terwujudnya Desa Aeng Tong-Tong');

        $this->get(route('about.struktur'))
            ->assertOk()
            ->assertSee('Kepala Desa');

        $this->get(route('about.perangkat'))
            ->assertOk()
            ->assertSee('H. Abd. Rahem');
    }

    public function test_halaman_potensi_desa_tampil(): void
    {
        $this->get(route('potensi'))
            ->assertOk()
            ->assertSee('Sentra Kerajinan Keris')
            ->assertSee('Wisata Budaya Desa');
    }

    public function test_halaman_kontak_dan_faq_tampil(): void
    {
        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('Alamat Kantor');

        $this->get(route('faq'))
            ->assertOk()
            ->assertSee('Pertanyaan Umum');
    }

    public function test_navigasi_utama_tampil_di_seluruh_halaman(): void
    {
        $this->get(route('home'))
            ->assertSee('Tentang')
            ->assertSee('Potensi')
            ->assertSee('Kontak')
            ->assertSee('FAQ');
    }
}
