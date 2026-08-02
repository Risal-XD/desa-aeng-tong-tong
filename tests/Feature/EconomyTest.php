<?php

namespace Tests\Feature;

use App\Models\KerisArtisan;
use App\Models\TourismDestination;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Village;
use Database\Seeders\EconomySeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EconomyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
        $this->seed(EconomySeeder::class);
    }

    private function superAdmin(): User
    {
        return User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();
    }

    private function editor(): User
    {
        return User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
    }

    public function test_super_admin_dapat_mengakses_halaman_admin_ekonomi(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.economy.tourism.index'))
            ->assertOk()
            ->assertSee('Pantai Aeng Tong-Tong');

        $this->actingAs($user)
            ->get(route('admin.economy.keris.index'))
            ->assertOk()
            ->assertSee('Mpu Haji Ahmad');

        $this->actingAs($user)
            ->get(route('admin.economy.umkms.index'))
            ->assertOk()
            ->assertSee('Batik Tong-Tong Asri');
    }

    public function test_super_admin_dapat_membuat_wisata(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.economy.tourism.store'), [
                'title' => 'Wisata Test',
                'category' => 'Alam',
                'description' => '<p>Wisata test</p>',
                'address' => 'Dusun Aeng Tong-Tong',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.economy.tourism.index'));

        $this->assertDatabaseHas('tourism_destinations', ['title' => 'Wisata Test']);
    }

    public function test_super_admin_dapat_membuat_keris_dan_umkm(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.economy.keris.store'), [
                'name' => 'Mpu Test',
                'title' => 'Mpu',
                'specialties' => 'Pamor, Bilah',
                'bio' => '<p>Bio test</p>',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.economy.keris.index'));

        $artisan = KerisArtisan::where('name', 'Mpu Test')->firstOrFail();
        $this->assertSame(['Pamor', 'Bilah'], $artisan->specialties);

        $this->actingAs($user)
            ->post(route('admin.economy.umkms.store'), [
                'name' => 'UMKM Test',
                'owner_name' => 'Pemilik Test',
                'category' => 'Kuliner',
                'description' => '<p>Deskripsi test</p>',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.economy.umkms.index'));

        $this->assertDatabaseHas('umkms', ['name' => 'UMKM Test']);
    }

    public function test_super_admin_dapat_mengakses_dan_memperbarui_halaman_edit_wisata(): void
    {
        $user = $this->superAdmin();
        $destination = TourismDestination::where('title', 'Pantai Aeng Tong-Tong')->firstOrFail();

        $this->actingAs($user)
            ->get(route('admin.economy.tourism.edit', $destination))
            ->assertOk()
            ->assertSee('Pantai Aeng Tong-Tong');

        $this->actingAs($user)
            ->put(route('admin.economy.tourism.update', $destination), [
                'title' => 'Pantai Aeng Tong-Tong Baru',
                'category' => 'Alam',
                'description' => '<p>Wisata test</p>',
                'address' => 'Dusun Aeng Tong-Tong',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tourism_destinations', ['title' => 'Pantai Aeng Tong-Tong Baru']);
    }

    public function test_editor_dapat_mengakses_ekonomi_tetapi_tidak_bisa_hapus(): void
    {
        $editor = $this->editor();

        $this->assertTrue($editor->can('tourism-view'));
        $this->assertFalse($editor->can('tourism-delete'));

        $this->actingAs($editor)
            ->get(route('admin.economy.tourism.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->get(route('admin.economy.keris.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->get(route('admin.economy.umkms.index'))
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

    public function test_halaman_frontend_ekonomi(): void
    {
        $this->get(route('tourism.index'))->assertOk()->assertSee('Wisata Desa');

        $this->get(route('tourism.show', ['tourism_destination' => 'pantai-aeng-tong-tong']))
            ->assertOk()
            ->assertSee('Pantai Aeng Tong-Tong');

        $this->get(route('keris.index'))->assertOk()->assertSee('Kerajinan Keris');

        $this->get(route('keris.show', ['keris_artisan' => 'mpu-haji-ahmad']))
            ->assertOk()
            ->assertSee('Mpu Haji Ahmad');

        $this->get(route('umkms.index'))->assertOk()->assertSee('UMKM');

        $this->get(route('umkms.show', ['umkm' => 'batik-tong-tong-asri']))
            ->assertOk()
            ->assertSee('Batik Tong-Tong Asri');
    }

    public function test_halaman_wisata_tidak_aktif_menghasilkan_404(): void
    {
        TourismDestination::create([
            'village_id' => Village::first()->getKey(),
            'user_id' => $this->superAdmin()->getKey(),
            'title' => 'Wisata Nonaktif',
            'slug' => 'wisata-nonaktif',
            'is_active' => false,
        ]);

        $this->get(route('tourism.show', 'wisata-nonaktif'))->assertNotFound();
    }

    public function test_halaman_umkm_soft_deleted_menghasilkan_404(): void
    {
        $umkm = Umkm::where('name', 'Batik Tong-Tong Asri')->firstOrFail();
        $umkm->delete();

        $this->get(route('umkms.show', $umkm))->assertNotFound();
    }
}
