<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use App\Services\SettingService;
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

class DashboardSystemTest extends TestCase
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

    private function superAdmin(): User
    {
        return User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();
    }

    private function admin(): User
    {
        return User::where('email', 'admin@aengtongtong.desa.id')->firstOrFail();
    }

    private function editor(): User
    {
        return User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
    }

    public function test_super_admin_dapat_mengakses_dashboard_dengan_statistik(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Total Berita')
            ->assertSee('Pesan Baru')
            ->assertSee('Aktivitas Terbaru');
    }

    public function test_super_admin_dapat_mengelola_pengaturan_website(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.system.settings.index'))
            ->assertOk()
            ->assertSee('Pengaturan Website');

        $this->actingAs($user)
            ->put(route('admin.system.settings.update'), [
                'general' => ['site_name' => 'Desa Aeng Tong-Tong Baru', 'site_tagline' => 'Desa Maju'],
                'seo' => ['meta_title' => 'Meta Test'],
                'contact' => ['contact_email' => 'kontak@desa.test'],
                'sosmed' => ['sosmed_instagram' => 'https://instagram.com/desa'],
            ])
            ->assertRedirect();

        $settings = app(SettingService::class);
        $this->assertSame('Desa Aeng Tong-Tong Baru', $settings->get('site_name'));
        $this->assertSame('kontak@desa.test', $settings->get('contact_email'));
    }

    public function test_super_admin_dapat_melihat_activity_log(): void
    {
        $this->actingAs($this->superAdmin())
            ->get(route('admin.system.activity-log.index'))
            ->assertOk()
            ->assertSee('Activity Log');
    }

    public function test_super_admin_dapat_membuat_dan_mengedit_pengguna(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.system.users.store'), [
                'name' => 'Petugas Baru',
                'email' => 'petugas@aengtongtong.desa.id',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
                'roles' => ['editor'],
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.system.users.index'));

        $created = User::where('email', 'petugas@aengtongtong.desa.id')->firstOrFail();
        $this->assertTrue($created->hasRole('editor'));

        $this->actingAs($user)
            ->get(route('admin.system.users.edit', $created))
            ->assertOk();

        $this->actingAs($user)
            ->put(route('admin.system.users.update', $created), [
                'name' => 'Petugas Diubah',
                'email' => 'petugas@aengtongtong.desa.id',
                'is_active' => true,
                'roles' => ['admin'],
            ])
            ->assertRedirect();

        $this->assertTrue($created->refresh()->hasRole('admin'));
    }

    public function test_admin_tidak_dapat_mengelola_pengguna_dan_role(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('admin.system.users.index'))
            ->assertForbidden();

        $this->actingAs($admin)
            ->get(route('admin.system.roles.index'))
            ->assertForbidden();
    }

    public function test_editor_tidak_dapat_mengakses_sistem_dan_layanan(): void
    {
        $editor = $this->editor();

        $this->actingAs($editor)
            ->get(route('admin.system.settings.index'))
            ->assertForbidden();

        $this->actingAs($editor)
            ->get(route('admin.system.activity-log.index'))
            ->assertForbidden();

        $this->actingAs($editor)
            ->get(route('admin.service.messages.index'))
            ->assertForbidden();
    }

    public function test_admin_dapat_mengelola_kontak_desa(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('admin.service.contacts.index'))
            ->assertOk()
            ->assertSee('Kontak Desa');

        $this->actingAs($admin)
            ->put(route('admin.service.contacts.update'), [
                'contact' => ['contact_whatsapp' => '081234567899'],
                'sosmed' => ['sosmed_facebook' => 'https://facebook.com/desa'],
            ])
            ->assertRedirect();

        $settings = app(SettingService::class);
        $this->assertSame('081234567899', $settings->get('contact_whatsapp'));
    }

    public function test_publik_mengirim_pesan_masuk(): void
    {
        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('Kirim Pesan');

        $this->post(route('kontak.store'), [
            'name' => 'Pengunjung Test',
            'email' => 'pengunjung@test.com',
            'phone' => '081234567800',
            'subject' => 'Pertanyaan Umum',
            'message' => 'Ini adalah isi pesan dari pengunjung.',
        ])
            ->assertRedirect(route('kontak'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'name' => 'Pengunjung Test',
            'email' => 'pengunjung@test.com',
            'subject' => 'Pertanyaan Umum',
            'status' => 'baru',
        ]);
    }

    public function test_admin_dapat_membuka_dan_membalas_pesan(): void
    {
        $admin = $this->admin();
        $message = Message::firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.service.messages.show', $message))
            ->assertOk()
            ->assertSee($message->subject);

        $this->assertDatabaseHas('messages', ['id' => $message->getKey(), 'status' => 'dibaca']);

        $this->actingAs($admin)
            ->put(route('admin.service.messages.update', $message), [
                'reply' => 'Terima kasih atas pertanyaannya.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('messages', [
            'id' => $message->getKey(),
            'status' => 'dibalas',
            'reply' => 'Terima kasih atas pertanyaannya.',
        ]);
    }

    public function test_admin_dapat_melihat_daftar_pesan_dengan_pesan_belum_dibaca(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->get(route('admin.service.messages.index'))
            ->assertOk()
            ->assertSee('Pesan Masuk');

        $this->assertSame(1, Message::unread()->count());
    }
}
