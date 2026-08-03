<?php

namespace Tests\Feature;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\KerisArtisan;
use App\Models\News;
use App\Models\Statistic;
use App\Models\TourismDestination;
use App\Models\Umkm;
use Database\Seeders\ContentSeeder;
use Database\Seeders\DataReportSeeder;
use Database\Seeders\EconomySeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
        $this->seed(ContentSeeder::class);
        $this->seed(MediaSeeder::class);
        $this->seed(EconomySeeder::class);
        $this->seed(DataReportSeeder::class);
        $this->seed(SettingSeeder::class);
        $this->seed(MessageSeeder::class);
    }

    public function test_semua_halaman_index_publik_tampil(): void
    {
        $pages = [
            route('home'),
            route('news.index'),
            route('announcements.index'),
            route('agendas.index'),
            route('galleries.index'),
            route('videos.index'),
            route('documents.index'),
            route('tourism.index'),
            route('keris.index'),
            route('umkms.index'),
            route('statistics.index'),
            route('apbdes.index'),
            route('faq'),
            route('potensi'),
            route('kontak'),
        ];

        foreach ($pages as $page) {
            $this->get($page)->assertOk();
        }
    }

    public function test_semua_halaman_tentang_desa_tampil(): void
    {
        $this->get(route('about.sejarah'))->assertOk();
        $this->get(route('about.visi-misi'))->assertOk();
        $this->get(route('about.struktur'))->assertOk();
        $this->get(route('about.perangkat'))->assertOk();
    }

    public function test_halaman_detail_berita_menampilkan_judul(): void
    {
        $news = News::where('status', 'published')->firstOrFail();

        $this->get(route('news.show', $news))
            ->assertOk()
            ->assertSee($news->title);
    }

    public function test_halaman_detail_pengumuman_menampilkan_judul(): void
    {
        $announcement = Announcement::where('status', 'published')->firstOrFail();

        $this->get(route('announcements.show', $announcement))
            ->assertOk()
            ->assertSee($announcement->title);
    }

    public function test_halaman_detail_wisata_menampilkan_nama(): void
    {
        $tourism = TourismDestination::where('is_active', true)->firstOrFail();

        $this->get(route('tourism.show', $tourism))
            ->assertOk()
            ->assertSee($tourism->title);
    }

    public function test_halaman_detail_keris_menampilkan_nama_mpu(): void
    {
        $keris = KerisArtisan::where('is_active', true)->firstOrFail();

        $this->get(route('keris.show', $keris))
            ->assertOk()
            ->assertSee($keris->name);
    }

    public function test_halaman_detail_umkm_menampilkan_nama(): void
    {
        $umkm = Umkm::where('is_active', true)->firstOrFail();

        $this->get(route('umkms.show', $umkm))
            ->assertOk()
            ->assertSee($umkm->name);
    }

    public function test_halaman_detail_statistik_menampilkan_nama(): void
    {
        $statistic = Statistic::where('is_active', true)->firstOrFail();

        $this->get(route('statistics.show', $statistic))
            ->assertOk()
            ->assertSee($statistic->name);
    }

    public function test_unduhan_dokumen_published_mengembalikan_file(): void
    {
        $document = Document::where('status', 'published')->firstOrFail();

        $this->get(route('documents.download', $document))
            ->assertOk();
    }

    public function test_beranda_menampilkan_konten_utama(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Aeng Tong-Tong');
    }

    public function test_dokumen_public_index_menampilkan_judul_dokumen(): void
    {
        $document = Document::where('status', 'published')->firstOrFail();

        $this->get(route('documents.index'))
            ->assertOk()
            ->assertSee($document->title);
    }
}
