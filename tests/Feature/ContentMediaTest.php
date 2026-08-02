<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use App\Models\Village;
use Database\Seeders\ContentSeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContentMediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
        $this->seed(ContentSeeder::class);
        $this->seed(MediaSeeder::class);
    }

    private function superAdmin(): User
    {
        return User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();
    }

    private function editor(): User
    {
        return User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
    }

    public function test_super_admin_dapat_mengakses_halaman_konten(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.content.news.index'))
            ->assertOk()
            ->assertSee('Desa Aeng Tong-Tong Selenggarakan Festival Keris');

        $this->actingAs($user)
            ->get(route('admin.content.announcements.index'))
            ->assertOk()
            ->assertSee('Pemutakhiran Data Penerima Bantuan Pangan');

        $this->actingAs($user)
            ->get(route('admin.content.agendas.index'))
            ->assertOk()
            ->assertSee('Rapat Musyawarah Desa');

        $this->actingAs($user)
            ->get(route('admin.content.faqs.index'))
            ->assertOk()
            ->assertSee('Bagaimana cara mengurus surat keterangan domisili');
    }

    public function test_super_admin_dapat_mengakses_halaman_media(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.media.galleries.index'))
            ->assertOk()
            ->assertSee('Festival Keris 2026');

        $this->actingAs($user)
            ->get(route('admin.media.videos.index'))
            ->assertOk()
            ->assertSee('Profil Desa Aeng Tong-Tong');

        $this->actingAs($user)
            ->get(route('admin.media.banners.index'))
            ->assertOk()
            ->assertSee('Selamat Datang di Desa Aeng Tong-Tong');
    }

    public function test_super_admin_dapat_membuat_berita(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.content.news.store'), [
                'title' => 'Berita Test',
                'content' => '<p>Konten test</p>',
                'status' => 'published',
            ])
            ->assertRedirect(route('admin.content.news.index'));

        $this->assertDatabaseHas('news', ['title' => 'Berita Test']);
    }

    public function test_super_admin_dapat_membuat_faq_dan_video(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.content.faqs.store'), [
                'question' => 'Pertanyaan test?',
                'answer' => '<p>Jawaban test</p>',
                'sort_order' => 1,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.content.faqs.index'));

        $this->assertDatabaseHas('faqs', ['question' => 'Pertanyaan test?']);

        $this->actingAs($user)
            ->post(route('admin.media.videos.store'), [
                'title' => 'Video Test',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'platform' => 'youtube',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.media.videos.index'));

        $this->assertDatabaseHas('videos', ['title' => 'Video Test']);
    }

    public function test_editor_dapat_mengakses_konten_tetapi_tidak_bisa_hapus(): void
    {
        $editor = $this->editor();

        $this->assertTrue($editor->can('news-view'));
        $this->assertFalse($editor->can('news-delete'));

        $this->actingAs($editor)
            ->get(route('admin.content.news.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->get(route('admin.media.videos.index'))
            ->assertOk();
    }

    public function test_editor_tidak_dapat_mengakses_halaman_master_data(): void
    {
        $editor = $this->editor();

        $this->assertFalse($editor->can('village-view'));

        $this->actingAs($editor)
            ->get(route('admin.master-data.villages.index'))
            ->assertForbidden();
    }

    public function test_halaman_frontend_konten_dan_media(): void
    {
        $this->get(route('news.index'))->assertOk()->assertSee('Berita Desa');
        $this->get(route('news.show', ['news' => 'desa-aeng-tong-tong-selenggarakan-festival-keris']))
            ->assertOk()
            ->assertSee('Festival Keris');

        $this->get(route('announcements.index'))->assertOk()->assertSee('Pengumuman');
        $this->get(route('announcements.show', ['announcement' => 'pemutakhiran-data-penerima-bantuan-pangan']))
            ->assertOk();

        $this->get(route('agendas.index'))->assertOk()->assertSee('Rapat Musyawarah Desa');
        $this->get(route('galleries.index'))->assertOk()->assertSee('Galeri Foto');
        $this->get(route('videos.index'))->assertOk()->assertSee('Profil Desa Aeng Tong-Tong');
        $this->get(route('faq'))->assertOk()->assertSee('Bagaimana cara mengurus surat keterangan domisili');
        $this->get(route('home'))->assertOk();
    }

    public function test_halaman_berita_non_published_menghasilkan_404(): void
    {
        $draft = News::create([
            'village_id' => Village::first()->getKey(),
            'user_id' => $this->superAdmin()->getKey(),
            'title' => 'Berita Draf',
            'slug' => 'berita-draf',
            'content' => '<p>Draf</p>',
            'status' => 'draft',
        ]);

        $this->get(route('news.show', $draft))->assertNotFound();
    }
}
