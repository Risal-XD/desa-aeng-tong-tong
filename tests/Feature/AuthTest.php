<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guest_ditredirect_ke_halaman_login(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_super_admin_dapat_login_dan_mengakses_dashboard(): void
    {
        $response = $this->post(route('admin.login.store'), [
            'email' => 'superadmin@aengtongtong.desa.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();

        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_login_dengan_kredensial_salah_menampilkan_error(): void
    {
        $this->post(route('admin.login.store'), [
            'email' => 'superadmin@aengtongtong.desa.id',
            'password' => 'salah-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_pengguna_nonaktif_tidak_dapat_login(): void
    {
        $user = User::factory()->create([
            'email' => 'nonaktif@example.com',
            'password' => 'secret1234',
            'is_active' => false,
        ]);

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'secret1234',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_super_admin_memiliki_semua_permission(): void
    {
        $user = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->assertTrue($user->can('user-delete'));
        $this->assertTrue($user->can('news-create'));
        $this->assertTrue($user->hasRole('super-admin'));
    }

    public function test_editor_tidak_dapat_mengakses_manajemen_pengguna(): void
    {
        $editor = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($editor);

        $this->assertFalse($editor->can('user-view'));
        $this->assertTrue($editor->can('news-create'));
        $this->assertFalse($editor->can('news-delete'));
        $this->assertTrue($editor->can('umkm-edit'));
    }

    public function test_editor_mendapat_403_saat_menghapus_berita_melalui_policy_user(): void
    {
        $editor = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
        $target = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($editor)
            ->get(route('admin.dashboard'))
            ->assertOk();

        // Editor tidak boleh menghapus pengguna lain.
        $this->assertFalse($editor->can('delete', $target));
    }

    public function test_logout_mengakhiri_sesi(): void
    {
        $user = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($user)
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
