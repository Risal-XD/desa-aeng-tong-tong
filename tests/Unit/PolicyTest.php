<?php

namespace Tests\Unit;

use App\Models\News;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
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

    public function test_super_admin_melampaui_seluruh_policy(): void
    {
        $gate = Gate::forUser($this->superAdmin());

        $this->assertTrue($gate->allows('viewAny', News::class));
        $this->assertTrue($gate->allows('delete', new News));
        $this->assertTrue($gate->allows('update', new Setting));
        $this->assertTrue($gate->allows('create', News::class));
    }

    public function test_editor_dapat_membuat_tetapi_tidak_menghapus_berita(): void
    {
        $gate = Gate::forUser($this->editor());

        $this->assertTrue($gate->allows('create', News::class));
        $this->assertTrue($gate->allows('update', new News));
        $this->assertFalse($gate->allows('delete', new News));
    }

    public function test_editor_tidak_dapat_mengakses_setting_dan_message(): void
    {
        $gate = Gate::forUser($this->editor());

        $this->assertFalse($gate->allows('viewAny', Setting::class));
        $this->assertFalse($gate->allows('update', new Setting));
    }

    public function test_admin_dapat_mengelola_setting_tetapi_bukan_pengguna(): void
    {
        $gate = Gate::forUser($this->admin());

        $this->assertTrue($gate->allows('viewAny', Setting::class));
        $this->assertTrue($gate->allows('update', new Setting));
        $this->assertFalse($gate->allows('viewAny', User::class));
    }

    public function test_permission_super_admin_meliputi_seluruh_modul(): void
    {
        $user = $this->superAdmin();

        foreach (['dashboard-view', 'news-create', 'message-view', 'setting-edit', 'activity-log-view'] as $slug) {
            $this->assertTrue($user->hasPermission($slug), "Permission '{$slug}' seharusnya dimiliki super admin.");
        }
    }

    public function test_has_role_memeriksa_slug_role(): void
    {
        $this->assertTrue($this->admin()->hasRole('admin'));
        $this->assertFalse($this->admin()->hasRole('editor'));
    }
}
