<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
    }

    public function test_super_admin_dapat_mengakses_halaman_master_data(): void
    {
        $user = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($user)
            ->get(route('admin.master-data.villages.index'))
            ->assertOk()
            ->assertSee('Aeng Tong-Tong');

        $this->actingAs($user)
            ->get(route('admin.master-data.structures.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.master-data.officials.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.master-data.categories.news.index'))
            ->assertOk()
            ->assertSee('Berita Desa');
    }

    public function test_super_admin_dapat_mengakses_halaman_profil_desa(): void
    {
        $user = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($user)
            ->get(route('admin.profile.village.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.profile.history.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('admin.profile.vision-mission.index'))
            ->assertOk()
            ->assertSee('Terwujudnya Desa Aeng Tong-Tong');

        $this->actingAs($user)
            ->get(route('admin.profile.potentials.index'))
            ->assertOk()
            ->assertSee('Sentra Kerajinan Keris');
    }

    public function test_super_admin_dapat_membuat_kategori_berita(): void
    {
        $user = User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($user)
            ->post(route('admin.master-data.categories.news.store'), [
                'name' => 'Kategori Test',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.master-data.categories.news.index'));

        $this->assertDatabaseHas('news_categories', ['name' => 'Kategori Test']);
    }

    public function test_editor_tidak_dapat_mengakses_master_data_dan_profil(): void
    {
        $editor = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();

        $this->assertFalse($editor->can('village-view'));
        $this->assertFalse($editor->can('profile-view'));

        $this->actingAs($editor)
            ->get(route('admin.master-data.villages.index'))
            ->assertForbidden();
    }
}
