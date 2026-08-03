<?php

namespace Tests\Unit;

use App\Models\Setting;
use App\Services\SettingService;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(SettingSeeder::class);
    }

    public function test_get_mengembalikan_default_saat_belum_ada(): void
    {
        $service = app(SettingService::class);

        $this->assertNull($service->get('tidak_ada'));
        $this->assertSame('default', $service->get('tidak_ada', 'default'));
    }

    public function test_get_string_mengembalikan_string(): void
    {
        $service = app(SettingService::class);

        $this->assertSame('Desa Aeng Tong-Tong', $service->get('site_name'));
    }

    public function test_get_boolean_mengurai_nilai_teks(): void
    {
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['group' => 'general', 'value' => '1', 'type' => 'boolean'],
        );

        $service = app(SettingService::class);

        $this->assertTrue($service->get('maintenance_mode'));
    }

    public function test_get_json_mengembalikan_array_dan_kosong_saat_nilai_kosong(): void
    {
        Setting::updateOrCreate(
            ['key' => 'theme_color'],
            ['group' => 'general', 'value' => '{"primary":"#0ea5e9"}', 'type' => 'json'],
        );

        Setting::updateOrCreate(
            ['key' => 'jam_kerja'],
            ['group' => 'general', 'value' => '', 'type' => 'json'],
        );

        $service = app(SettingService::class);

        $this->assertSame(['primary' => '#0ea5e9'], $service->get('theme_color'));
        $this->assertSame([], $service->get('jam_kerja'));
    }

    public function test_set_membuat_atau_memperbarui_setting(): void
    {
        $service = app(SettingService::class);

        $service->set('site_tagline', 'Desa Maju & Mandiri');
        $this->assertSame('Desa Maju & Mandiri', $service->get('site_tagline'));

        $service->set('site_tagline', 'Diperbarui');
        $this->assertSame(1, Setting::where('key', 'site_tagline')->count());
        $this->assertSame('Diperbarui', $service->get('site_tagline'));
    }

    public function test_set_tipe_json_mengenkode_array(): void
    {
        $service = app(SettingService::class);

        $service->set('jam_kerja', ['Senin' => '08:00-16:00'], 'contact', 'json');

        $this->assertSame(['Senin' => '08:00-16:00'], $service->get('jam_kerja'));
    }

    public function test_set_many_melewati_nilai_kosong(): void
    {
        $service = app(SettingService::class);

        $service->setMany(['contact_whatsapp' => '081234567890', 'contact_fax' => ''], 'contact');

        $this->assertSame('081234567890', $service->get('contact_whatsapp'));
        $this->assertNull($service->get('contact_fax'));
    }

    public function test_all_by_group_mengembalikan_hanya_grup_tertentu(): void
    {
        $service = app(SettingService::class);

        $sosmed = $service->allByGroup('sosmed');

        $this->assertNotEmpty($sosmed);
        $this->assertArrayNotHasKey('site_name', $sosmed);
        $this->assertArrayHasKey('sosmed_facebook', $sosmed);
    }
}
