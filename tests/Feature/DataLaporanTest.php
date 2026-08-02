<?php

namespace Tests\Feature;

use App\Models\Apbdes;
use App\Models\Document;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Village;
use Database\Seeders\DataReportSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\VillageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DataLaporanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        $this->seed(VillageSeeder::class);
        $this->seed(DataReportSeeder::class);
    }

    private function superAdmin(): User
    {
        return User::where('email', 'superadmin@aengtongtong.desa.id')->firstOrFail();
    }

    private function editor(): User
    {
        return User::where('email', 'editor@aengtongtong.desa.id')->firstOrFail();
    }

    public function test_super_admin_dapat_mengakses_halaman_admin_data(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->get(route('admin.data-report.statistics.index'))
            ->assertOk()
            ->assertSee('Statistik Kependudukan');

        $this->actingAs($user)
            ->get(route('admin.data-report.apbdes.index'))
            ->assertOk()
            ->assertSee('Dana Desa');

        $this->actingAs($user)
            ->get(route('admin.data-report.documents.index'))
            ->assertOk()
            ->assertSee('Buku Profil Desa Aeng Tong-Tong');
    }

    public function test_super_admin_dapat_membuat_statistik_dengan_baris_data(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.data-report.statistics.store'), [
                'name' => 'Statistik Test',
                'category' => 'kesehatan',
                'year' => now()->year,
                'population' => [
                    ['label' => 'Puskesmas', 'value' => 1, 'unit' => 'unit'],
                    ['label' => 'Posyandu', 'value' => 5, 'unit' => 'unit'],
                ],
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.data-report.statistics.index'));

        $statistic = Statistic::where('name', 'Statistik Test')->firstOrFail();
        $this->assertCount(2, $statistic->populationStatistics);
    }

    public function test_super_admin_dapat_membuat_pos_apbdes_dan_dokumen(): void
    {
        $user = $this->superAdmin();

        $this->actingAs($user)
            ->post(route('admin.data-report.apbdes.store'), [
                'year' => now()->year,
                'type' => 'belanja',
                'name' => 'Belanja Test',
                'category' => 'Bidang Pembangunan',
                'budget_amount' => 1000000,
                'realization_amount' => 900000,
                'is_active' => true,
            ])
            ->assertRedirect(route('admin.data-report.apbdes.index'));

        $this->assertDatabaseHas('apbdes', ['name' => 'Belanja Test']);

        $this->actingAs($user)
            ->post(route('admin.data-report.documents.store'), [
                'title' => 'Dokumen Test',
                'category' => 'Laporan',
                'status' => 'published',
                'file' => UploadedFile::fake()->create('dokumen-test.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('admin.data-report.documents.index'));

        $this->assertDatabaseHas('documents', ['title' => 'Dokumen Test']);
    }

    public function test_super_admin_dapat_mengakses_dan_memperbarui_halaman_edit_pos_apbdes(): void
    {
        $user = $this->superAdmin();
        $item = Apbdes::firstOrFail();

        $this->actingAs($user)
            ->get(route('admin.data-report.apbdes.edit', $item))
            ->assertOk()
            ->assertSee($item->name);

        $this->actingAs($user)
            ->patch(route('admin.data-report.apbdes.update', $item), [
                'year' => now()->year,
                'type' => 'pendapatan',
                'name' => 'Pendapatan Test',
                'category' => 'PADes',
                'budget_amount' => 2000000,
                'realization_amount' => 1800000,
                'is_active' => true,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('apbdes', ['id' => $item->getKey(), 'name' => 'Pendapatan Test']);
    }

    public function test_editor_dapat_mengakses_data_tetapi_tidak_bisa_hapus(): void
    {
        $editor = $this->editor();

        $this->assertTrue($editor->can('statistic-view'));
        $this->assertFalse($editor->can('statistic-delete'));

        $this->actingAs($editor)
            ->get(route('admin.data-report.statistics.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->get(route('admin.data-report.apbdes.index'))
            ->assertOk();

        $this->actingAs($editor)
            ->get(route('admin.data-report.documents.index'))
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

    public function test_halaman_frontend_data_dan_laporan(): void
    {
        $this->get(route('statistics.index'))->assertOk()->assertSee('Statistik Desa');
        $this->get(route('statistics.show', 'statistik-kependudukan'))
            ->assertOk()
            ->assertSee('Statistik Kependudukan');

        $this->get(route('apbdes.index'))->assertOk()->assertSee('APBDes');

        $this->get(route('documents.index'))
            ->assertOk()
            ->assertSee('Buku Profil Desa Aeng Tong-Tong');
    }

    public function test_unduhan_dokumen_mencatat_log_dan_menambah_counter(): void
    {
        $document = Document::where('title', 'Buku Profil Desa Aeng Tong-Tong')->firstOrFail();
        $before = $document->download_count;

        $this->get(route('documents.download', $document))
            ->assertOk();

        $this->assertDatabaseHas('downloads', ['document_id' => $document->getKey()]);
        $this->assertDatabaseHas('documents', ['id' => $document->getKey(), 'download_count' => $before + 1]);
    }

    public function test_statistik_non_aktif_menghasilkan_404(): void
    {
        Statistic::create([
            'village_id' => Village::first()->getKey(),
            'name' => 'Statistik Nonaktif',
            'slug' => 'statistik-nonaktif',
            'category' => 'lainnya',
            'year' => now()->year,
            'is_active' => false,
        ]);

        $this->get(route('statistics.show', 'statistik-nonaktif'))->assertNotFound();
    }

    public function test_unduhan_dokumen_draft_menghasilkan_404(): void
    {
        $document = Document::where('title', 'Buku Profil Desa Aeng Tong-Tong')->firstOrFail();
        $document->update(['status' => 'draft']);

        $this->get(route('documents.download', $document))->assertNotFound();
    }
}
