<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Village;
use App\Models\VillagePotential;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAdminTest extends TestCase
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

    public function test_super_admin_dapat_mengakses_halaman_profil_desa(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)->get(route('admin.profile.village.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.profile.history.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.profile.vision-mission.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.profile.potentials.index'))->assertOk();
    }

    public function test_super_admin_dapat_memperbarui_profil_desa(): void
    {
        $user = $this->superAdmin();
        $village = Village::firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.profile.village.update'), [
                'overview' => '<p>Gambaran umum baru.</p>',
                'geographic' => '<p>Geografis baru.</p>',
                'demographics_summary' => '<p>Demografi baru.</p>',
            ])
            ->assertRedirect();

        $this->assertSame('<p>Gambaran umum baru.</p>', $village->profile->refresh()->overview);
    }

    public function test_super_admin_dapat_memperbarui_sejarah_desa(): void
    {
        $user = $this->superAdmin();
        $village = Village::firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.profile.history.update'), [
                'history_content' => '<p>Sejarah diperbarui.</p>',
                'founder_name' => 'Tokoh Pendiri',
                'founded_year' => 1850,
                'status' => 'published',
            ])
            ->assertRedirect();

        $this->assertSame('<p>Sejarah diperbarui.</p>', $village->history->refresh()->history_content);
    }

    public function test_super_admin_dapat_memperbarui_visi_misi(): void
    {
        $user = $this->superAdmin();
        $village = Village::firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.profile.vision-mission.update'), [
                'vision' => 'Visi baru desa.',
                'missions' => ['Misi pertama baru.', 'Misi kedua baru.'],
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertSame('Visi baru desa.', $village->visions()->firstOrFail()->vision);
        $this->assertSame(2, $village->missions()->count());
    }

    public function test_super_admin_dapat_membuat_dan_menghapus_potensi(): void
    {
        Storage::fake('public');
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.profile.potentials.store'), [
                'title' => 'Potensi Baru',
                'category' => 'Kerajinan',
                'description' => '<p>Deskripsi potensi.</p>',
                'image' => UploadedFile::fake()->image('potensi.png'),
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.profile.potentials.index'));

        $potential = VillagePotential::where('title', 'Potensi Baru')->firstOrFail();
        Storage::disk('public')->assertExists($potential->image);

        $this->actingAs($user)
            ->delete(route('admin.profile.potentials.destroy', $potential))
            ->assertRedirect();

        $this->assertSoftDeleted('village_potentials', ['id' => $potential->getKey()]);
    }

    public function test_super_admin_dapat_memperbarui_akun_profil(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.profile.show'))
            ->assertOk();

        $this->actingAs($user)
            ->put(route('admin.profile.update'), [
                'name' => 'Super Admin Diedit',
                'email' => 'superadmin@aengtongtong.desa.id',
            ])
            ->assertRedirect();

        $this->assertSame('Super Admin Diedit', $user->refresh()->name);
    }

    public function test_super_admin_dapat_mengganti_kata_sandi(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->put(route('admin.profile.update-password'), [
                'current_password' => 'password',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect();

        $this->assertTrue(Hash::check('password123', $user->refresh()->password));
    }

    public function test_ganti_kata_sandi_gagal_saat_password_lama_salah(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->put(route('admin.profile.update-password'), [
                'current_password' => 'salah123',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertSessionHasErrors('current_password');
    }

    public function test_perbarui_profil_desa_mencatat_activity_log(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->put(route('admin.profile.village.update'), [
                'overview' => '<p>Gambaran umum baru.</p>',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('activity_logs', [
            'user_id' => $user->getKey(),
            'description' => 'Memperbarui profil desa',
            'event' => 'updated',
        ]);
    }

    public function test_editor_tidak_dapat_mengelola_profil_desa(): void
    {
        $editor = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();

        $this->actingAs($editor)
            ->get(route('admin.profile.village.index'))
            ->assertForbidden();

        $this->actingAs($editor)
            ->put(route('admin.profile.vision-mission.update'), [
                'vision' => 'Visi',
                'missions' => ['Misi'],
            ])
            ->assertForbidden();
    }

    public function test_editor_hanya_bisa_membuat_potensi_tanpa_hapus(): void
    {
        $editor = User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
        $potential = VillagePotential::firstOrFail();

        $this->actingAs($editor)
            ->delete(route('admin.profile.potentials.destroy', $potential))
            ->assertForbidden();
    }
}
