<?php

namespace Tests\Unit;

use App\Services\UploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadServiceTest extends TestCase
{
    public function test_store_menyimpan_file_ke_disk_public(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('banner.png');

        $path = app(UploadService::class)->store($file, 'images/banners');

        $this->assertStringStartsWith('images/banners/', $path);
        $this->assertStringEndsWith('.png', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_delete_tidak_error_saat_path_kosong(): void
    {
        Storage::fake('public');

        app(UploadService::class)->delete(null);

        $this->expectNotToPerformAssertions();
    }

    public function test_delete_menghapus_file_yang_ada(): void
    {
        Storage::fake('public');

        $path = Storage::disk('public')->put('images/banners/lama.png', 'konten');

        app(UploadService::class)->delete($path);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_replace_menghapus_file_lama_dan_menyimpan_baru(): void
    {
        Storage::fake('public');

        $old = Storage::disk('public')->put('images/banners/lama.png', 'konten');
        $file = UploadedFile::fake()->image('baru.png');

        $new = app(UploadService::class)->replace($old, $file, 'images/banners');

        Storage::disk('public')->assertMissing($old);
        Storage::disk('public')->assertExists($new);
        $this->assertNotSame($old, $new);
    }

    public function test_store_menghasilkan_nama_unik(): void
    {
        Storage::fake('public');

        $service = app(UploadService::class);

        $a = $service->store(UploadedFile::fake()->image('a.jpg'), 'images');
        $b = $service->store(UploadedFile::fake()->image('b.jpg'), 'images');

        $this->assertNotSame($a, $b);
    }
}
