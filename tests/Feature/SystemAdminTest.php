<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SystemAdminTest extends TestCase
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

    public function test_super_admin_dapat_melihat_dan_mengedit_role(): void
    {
        $user = $this->superAdmin();
        $role = Role::where('slug', 'editor')->firstOrFail();

        $this->actingAs($user)->get(route('admin.system.roles.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.system.roles.edit', $role))->assertOk()->assertSee('Editor Konten');
    }

    public function test_super_admin_dapat_memperbarui_permission_role(): void
    {
        $user = $this->superAdmin();
        $role = Role::where('slug', 'editor')->firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.system.roles.update', $role), [
                'name' => 'Editor Konten',
                'slug' => 'editor',
                'permissions' => ['news-view', 'news-create'],
            ])
            ->assertRedirect();

        $this->assertSame(
            ['news-create', 'news-view'],
            $role->permissions()->pluck('slug')->sort()->values()->all(),
        );
    }

    public function test_role_menolak_slug_tidak_valid(): void
    {
        $user = $this->superAdmin();
        $role = Role::where('slug', 'editor')->firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.system.roles.update', $role), [
                'name' => 'Editor',
                'slug' => 'Editor Konten',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_daftar_role_menampilkan_jumlah_pengguna(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.system.roles.index'))
            ->assertOk()
            ->assertSee('Editor Konten')
            ->assertSee('1');
    }

    public function test_operasi_crud_mencatat_activity_log(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.system.users.store'), [
                'name' => 'Petugas Log',
                'email' => 'petugaslog@aengtongtong.desa.id',
                'password' => 'rahasia123',
                'password_confirmation' => 'rahasia123',
                'roles' => ['editor'],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->getKey(),
            'event' => 'created',
        ]);
    }

    public function test_activity_log_dapat_difilter_log_name(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.system.activity-log.index', ['log_name' => 'login']))
            ->assertOk();
    }

    public function test_login_dan_logout_mencatat_activity_log(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.logout'))
            ->assertRedirect();

        $this->assertDatabaseHas('activity_logs', ['event' => 'logout']);
    }

    public function test_admin_tidak_dapat_mengedit_role(): void
    {
        $admin = User::where('email', 'admin@aengtongtong.desa.id')->firstOrFail();
        $role = Role::where('slug', 'editor')->firstOrFail();

        $this->actingAs($admin)
            ->get(route('admin.system.roles.edit', $role))
            ->assertForbidden();
    }
}
