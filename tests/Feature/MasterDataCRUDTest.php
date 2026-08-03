<?php

namespace Tests\Feature;

use App\Models\GalleryCategory;
use App\Models\OrganizationalStructure;
use App\Models\User;
use App\Models\Village;
use App\Models\VillageOfficial;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MasterDataCRUDTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
    }

    private function superAdmin(): User
    {
        return User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();
    }

    private function editor(): User
    {
        return User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
    }

    public function test_super_admin_dapat_mengakses_semua_halaman_master_data(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)->get(route('admin.master-data.villages.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.master-data.structures.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.master-data.officials.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.master-data.categories.news.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.master-data.categories.gallery.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.master-data.categories.video.index'))->assertOk();
    }

    public function test_super_admin_dapat_membuat_struktur_organisasi(): void
    {
        $user = $this->superAdmin();
        $root = OrganizationalStructure::where('name', 'Pemerintah Desa')->firstOrFail();

        $this->actingAs($user)
            ->post(route('admin.master-data.structures.store'), [
                'parent_id' => $root->getKey(),
                'name' => 'Kasi Kesejahteraan',
                'position' => 'Kepala Seksi Kesejahteraan',
                'level' => 3,
                'sort_order' => 5,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.master-data.structures.index'));

        $this->assertDatabaseHas('organizational_structures', [
            'name' => 'Kasi Kesejahteraan',
            'parent_id' => $root->getKey(),
        ]);
    }

    public function test_super_admin_dapat_mengubah_dan_menghapus_struktur(): void
    {
        $user = $this->superAdmin();
        $structure = OrganizationalStructure::where('name', 'Sekretariat Desa')->firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.master-data.structures.update', $structure), [
                'name' => 'Sekretariat Desa Diperbarui',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->actingAs($user)
            ->delete(route('admin.master-data.structures.destroy', $structure))
            ->assertRedirect(route('admin.master-data.structures.index'));

        $this->assertDatabaseMissing('organizational_structures', ['id' => $structure->getKey()]);
    }

    public function test_super_admin_dapat_membuat_perangkat_desa(): void
    {
        Storage::fake('public');
        $user = $this->superAdmin();
        $village = Village::firstOrFail();

        $this->actingAs($user)
            ->post(route('admin.master-data.officials.store'), [
                'village_id' => $village->getKey(),
                'name' => 'Perangkat Uji',
                'position' => 'Kepala Urusan Umum',
                'photo' => UploadedFile::fake()->image('perangkat.png'),
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.master-data.officials.index'));

        $official = VillageOfficial::where('name', 'Perangkat Uji')->firstOrFail();
        Storage::disk('public')->assertExists($official->photo);
    }

    public function test_super_admin_dapat_membuat_data_desa_baru(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.master-data.villages.store'), [
                'name' => 'Desa Uji Coba',
                'code' => '9999999999',
                'district' => 'Kec. Uji',
                'regency' => 'Kab. Uji',
                'province' => 'Jawa Timur',
                'total_hamlet' => 2,
            ])
            ->assertRedirect(route('admin.master-data.villages.index'));

        $this->assertDatabaseHas('villages', ['code' => '9999999999', 'name' => 'Desa Uji Coba']);
    }

    public function test_super_admin_dapat_membuat_dan_mengubah_kategori_galeri(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.master-data.categories.gallery.store'), [
                'name' => 'Kategori Baru',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.master-data.categories.gallery.index'));

        $category = GalleryCategory::where('name', 'Kategori Baru')->firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.master-data.categories.gallery.update', $category->getKey()), [
                'name' => 'Kategori Diubah',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertSame('Kategori Diubah', $category->refresh()->name);
    }

    public function test_editor_tidak_dapat_mengelola_master_data(): void
    {
        $editor = $this->editor();

        $this->actingAs($editor)
            ->post(route('admin.master-data.structures.store'), [
                'name' => 'Harus Ditolak',
            ])
            ->assertForbidden();

        $this->actingAs($editor)
            ->get(route('admin.master-data.categories.news.create'))
            ->assertForbidden();
    }

    public function test_kode_desa_bersifat_unik(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.master-data.villages.store'), [
                'name' => 'Duplikat',
                'code' => '3529152001',
                'district' => 'Saronggi',
                'regency' => 'Sumenep',
                'province' => 'Jawa Timur',
            ])
            ->assertSessionHasErrors('code');
    }
}
