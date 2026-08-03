<?php

namespace Tests\Feature;

use App\Models\News;
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

class SeoTest extends TestCase
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

    public function test_sitemap_xml_tampil_dengan_elemen_urlset(): void
    {
        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=utf-8')
            ->assertSee('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">', false)
            ->assertSee('<loc>', false);
    }

    public function test_sitemap_xml_memuat_halaman_statis_dan_detail(): void
    {
        $news = News::where('status', 'published')->firstOrFail();
        $response = $this->get('/sitemap.xml')->assertOk();

        $response->assertSee(route('home'), false);
        $response->assertSee(route('news.index'), false);
        $response->assertSee(route('news.show', $news), false);
        $response->assertSee(route('kontak'), false);
    }

    public function test_robots_txt_mengarahkan_ke_sitemap_dan_memblokir_admin(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=utf-8')
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.url('/sitemap.xml'));
    }

    public function test_halaman_publik_memiliki_meta_seo_dan_canonical(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('<meta name="description"', false)
            ->assertSee('<meta name="robots"', false)
            ->assertSee('<link rel="canonical"', false);
    }

    public function test_halaman_detail_berita_memiliki_open_graph(): void
    {
        $news = News::where('status', 'published')->firstOrFail();

        $this->get(route('news.show', $news))
            ->assertOk()
            ->assertSee('property="og:title"', false)
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('property="og:url"', false);
    }

    public function test_layout_publik_memiliki_skip_link_aksesibilitas(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('id="konten-utama"', false);
    }
}
