<?php

namespace Tests\Unit;

use App\Services\DashboardService;
use Database\Seeders\ContentSeeder;
use Database\Seeders\DataReportSeeder;
use Database\Seeders\EconomySeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
        $this->seed(ContentSeeder::class);
        $this->seed(MediaSeeder::class);
        $this->seed(EconomySeeder::class);
        $this->seed(DataReportSeeder::class);
        $this->seed(SettingSeeder::class);
        $this->seed(MessageSeeder::class);
    }

    public function test_get_stats_memuat_seluruh_counter(): void
    {
        $stats = app(DashboardService::class)->getStats();

        $keys = [
            'total_users', 'active_users', 'total_roles', 'total_permissions',
            'news', 'announcements', 'agendas', 'faqs',
            'galleries', 'videos', 'banners',
            'tourism', 'keris', 'umkms',
            'statistics', 'apbdes', 'documents', 'downloads',
            'messages', 'unread_messages',
        ];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $stats, "Counter '{$key}' tidak ada.");
            $this->assertIsInt($stats[$key], "Counter '{$key}' bukan integer.");
        }

        $this->assertSame(3, $stats['total_users']);
        $this->assertGreaterThan(0, $stats['news']);
        $this->assertGreaterThan(0, $stats['unread_messages']);
    }

    public function test_get_charts_menyediakan_empat_grafik(): void
    {
        $charts = app(DashboardService::class)->getCharts();

        $this->assertArrayHasKey('newsPerMonth', $charts);
        $this->assertArrayHasKey('population', $charts);
        $this->assertArrayHasKey('apbdes', $charts);
        $this->assertArrayHasKey('topDownloads', $charts);

        $this->assertCount(6, $charts['newsPerMonth']['labels']);
        $this->assertCount(6, $charts['newsPerMonth']['values']);
        $this->assertCount(3, $charts['apbdes']['labels']);
        $this->assertCount(3, $charts['apbdes']['budget']);
    }

    public function test_get_charts_population_berisi_data_kependudukan(): void
    {
        $charts = app(DashboardService::class)->getCharts();

        $this->assertNotNull($charts['population']);
        $this->assertArrayHasKey('labels', $charts['population']);
        $this->assertNotEmpty($charts['population']['labels']);
    }

    public function test_recent_activity_mengembalikan_koleksi_terbaru(): void
    {
        $activities = app(DashboardService::class)->recentActivity(3);

        $this->assertLessThanOrEqual(3, $activities->count());
    }

    public function test_recent_messages_mengembalikan_pesan_terbaru(): void
    {
        $messages = app(DashboardService::class)->recentMessages(2);

        $this->assertLessThanOrEqual(2, $messages->count());
        $this->assertTrue($messages->every(fn ($m) => $m->status !== null));
    }
}
