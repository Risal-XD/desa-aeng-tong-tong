<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\Gallery;
use App\Models\User;
use Database\Seeders\MediaSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
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

    public function test_super_admin_dapat_mengakses_halaman_media(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)->get(route('admin.media.banners.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.media.galleries.index'))->assertOk();
        $this->actingAs($user)->get(route('admin.media.videos.index'))->assertOk();
    }

    public function test_super_admin_dapat_membuat_banner_dengan_gambar(): void
    {
        Storage::fake('public');
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.media.banners.store'), [
                'title' => 'Banner Uji',
                'image' => UploadedFile::fake()->image('banner.png', 1200, 400),
                'position' => 'slider',
                'sort_order' => 5,
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.media.banners.index'));

        $banner = Banner::where('title', 'Banner Uji')->firstOrFail();
        $this->assertNotNull($banner->image);
        Storage::disk('public')->assertExists($banner->image);
    }

    public function test_super_admin_dapat_mengubah_dan_menghapus_banner(): void
    {
        Storage::fake('public');
        $user = $this->superAdmin();
        $banner = Banner::firstOrFail();

        $this->actingAs($user)
            ->put(route('admin.media.banners.update', $banner), [
                'title' => 'Banner Diubah',
                'status' => 'inactive',
            ])
            ->assertRedirect();

        $this->assertSame('inactive', $banner->refresh()->status);

        $this->actingAs($user)
            ->delete(route('admin.media.banners.destroy', $banner))
            ->assertRedirect(route('admin.media.banners.index'));

        $this->assertDatabaseMissing('banners', ['id' => $banner->getKey()]);
    }

    public function test_super_admin_dapat_membuat_foto_galeri(): void
    {
        Storage::fake('public');
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.media.galleries.store'), [
                'title' => 'Foto Uji Galeri',
                'image' => UploadedFile::fake()->image('galeri.png'),
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.media.galleries.index'));

        $gallery = Gallery::where('title', 'Foto Uji Galeri')->firstOrFail();
        Storage::disk('public')->assertExists($gallery->image);
    }

    public function test_super_admin_dapat_membuat_video(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.media.videos.store'), [
                'title' => 'Video Uji',
                'video_url' => 'https://www.youtube.com/watch?v=abcdef',
                'platform' => 'youtube',
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.media.videos.index'));

        $this->assertDatabaseHas('videos', ['title' => 'Video Uji']);
    }

    public function test_editor_dapat_mengakses_media_tetapi_tidak_menghapus(): void
    {
        $editor = $this->editor();
        $banner = Banner::firstOrFail();

        $this->actingAs($editor)
            ->get(route('admin.media.banners.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->delete(route('admin.media.banners.destroy', $banner))
            ->assertForbidden();
    }

    public function test_editor_dapat_mengedit_galeri(): void
    {
        $editor = $this->editor();
        $gallery = Gallery::firstOrFail();

        $this->actingAs($editor)
            ->put(route('admin.media.galleries.update', $gallery), [
                'title' => 'Judul Diubah Editor',
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertSame('Judul Diubah Editor', $gallery->refresh()->title);
    }

    public function test_banner_nonaktif_tidak_tampil_di_frontend(): void
    {
        $banner = Banner::first();
        $banner->update(['status' => 'inactive']);

        $this->get(route('home'))->assertOk();
        $this->assertDatabaseHas('banners', ['id' => $banner->getKey(), 'status' => 'inactive']);
    }
}
