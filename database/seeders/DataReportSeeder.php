<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ApbdesType;
use App\Enums\DocumentStatus;
use App\Enums\StatisticCategory;
use App\Models\Apbdes;
use App\Models\Document;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataReportSeeder extends Seeder
{
    /**
     * Seed contoh data statistik, APBDes, dan dokumen desa.
     */
    public function run(): void
    {
        $village = Village::first();
        $author = User::query()->whereHas('roles', fn ($q) => $q->where('slug', 'editor'))->first() ?? User::first();

        if ($village === null || $author === null) {
            return;
        }

        $this->seedStatistics($village);
        $this->seedApbdes($village, $author);
        $this->seedDocuments($village, $author);
    }

    private function seedStatistics(Village $village): void
    {
        $groups = [
            [
                'name' => 'Statistik Kependudukan',
                'category' => StatisticCategory::POPULATION,
                'year' => now()->year,
                'description' => '<p>Data jumlah penduduk Desa Aeng Tong-Tong berdasarkan jenis kelamin dan kelompok usia.</p>',
'rows' => [
                ['label' => 'Penduduk aktif', 'value' => 1557, 'unit' => 'jiwa'],
                ['label' => 'Total KK', 'value' => 630, 'unit' => 'KK'],
                ['label' => 'Laki-laki', 'value' => 771, 'unit' => 'jiwa'],
                ['label' => 'Perempuan', 'value' => 786, 'unit' => 'jiwa'],
                ['label' => 'Balita (0-5)', 'value' => 90, 'unit' => 'jiwa'],
                ['label' => 'Anak (6-17)', 'value' => 202, 'unit' => 'jiwa'],
                ['label' => 'Produktif (18-59)', 'value' => 992, 'unit' => 'jiwa'],
                ['label' => 'Lansia (60+)', 'value' => 273, 'unit' => 'jiwa'],
            ],
            ],
            [
                'name' => 'Tingkat Pendidikan',
                'category' => StatisticCategory::EDUCATION,
                'year' => now()->year,
                'description' => '<p>Pendidikan terakhir penduduk usia produktif Desa Aeng Tong-Tong.</p>',
                'rows' => [
                    ['label' => 'Tidak Sekolah', 'value' => 310, 'unit' => 'orang'],
                    ['label' => 'SD/Sederajat', 'value' => 1520, 'unit' => 'orang'],
                    ['label' => 'SMP/Sederajat', 'value' => 1730, 'unit' => 'orang'],
                    ['label' => 'SMA/Sederajat', 'value' => 2310, 'unit' => 'orang'],
                    ['label' => 'Diploma/Sarjana', 'value' => 490, 'unit' => 'orang'],
                ],
            ],
        ];

        foreach ($groups as $group) {
            $statistic = Statistic::updateOrCreate(
                ['category' => $group['category']->value, 'year' => $group['year']],
                [
                    'village_id' => $village->getKey(),
                    'name' => $group['name'],
                    'description' => $group['description'],
                    'is_active' => true,
                ],
            );

            $statistic->populationStatistics()->delete();

            $statistic->populationStatistics()->createMany(
                array_map(
                    fn (array $row, int $index): array => $row + ['sort_order' => $index],
                    $group['rows'],
                    array_keys($group['rows']),
                ),
            );
        }
    }

    private function seedApbdes(Village $village, User $author): void
    {
        $year = now()->year;

        $items = [
            ['type' => ApbdesType::INCOME, 'name' => 'Dana Desa', 'category' => 'Transfer', 'budget' => 1200000000, 'realization' => 1185000000],
            ['type' => ApbdesType::INCOME, 'name' => 'Alokasi Dana Desa (ADD)', 'category' => 'Transfer', 'budget' => 450000000, 'realization' => 450000000],
            ['type' => ApbdesType::INCOME, 'name' => 'Bagi Hasil Pajak & Retribusi', 'category' => 'PADes', 'budget' => 75000000, 'realization' => 72000000],
            ['type' => ApbdesType::EXPENSE, 'name' => 'Penyelenggaraan Pemerintahan', 'category' => 'Bidang Pemerintahan', 'budget' => 600000000, 'realization' => 595000000],
            ['type' => ApbdesType::EXPENSE, 'name' => 'Pembangunan Infrastruktur', 'category' => 'Bidang Pembangunan', 'budget' => 800000000, 'realization' => 760000000],
            ['type' => ApbdesType::EXPENSE, 'name' => 'Pembinaan Kemasyarakatan', 'category' => 'Bidang Pembinaan', 'budget' => 200000000, 'realization' => 195000000],
            ['type' => ApbdesType::EXPENSE, 'name' => 'Pemberdayaan Masyarakat', 'category' => 'Bidang Pemberdayaan', 'budget' => 300000000, 'realization' => 285000000],
            ['type' => ApbdesType::FINANCING, 'name' => 'Silpa Tahun Berjalan', 'category' => 'Penerimaan', 'budget' => 45000000, 'realization' => 45000000],
        ];

        foreach ($items as $item) {
            Apbdes::updateOrCreate(
                [
                    'village_id' => $village->getKey(),
                    'year' => $year,
                    'type' => $item['type'],
                    'name' => $item['name'],
                ],
                [
                    'user_id' => $author->getKey(),
                    'category' => $item['category'],
                    'budget_amount' => $item['budget'],
                    'realization_amount' => $item['realization'],
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedDocuments(Village $village, User $author): void
    {
        $items = [
            [
                'title' => 'Buku Profil Desa Aeng Tong-Tong',
                'category' => 'Profil',
                'filename' => 'buku-profil-desa-aeng-tong-tong.pdf',
                'description' => '<p>Buku profil desa memuat gambaran umum, pemerintahan, potensi, serta data statistik Desa Aeng Tong-Tong.</p>',
            ],
            [
                'title' => 'Laporan Realisasi APBDes Tahun Berjalan',
                'category' => 'Laporan',
                'filename' => 'laporan-realisasi-apbdes.pdf',
                'description' => '<p>Laporan realisasi Anggaran Pendapatan dan Belanja Desa (APBDes) sebagai wujud transparansi keuangan desa.</p>',
            ],
            [
                'title' => 'Peraturan Desa tentang Tata Kelola Pemerintahan',
                'category' => 'Peraturan',
                'filename' => 'perdes-tata-kelola-pemerintahan.pdf',
                'description' => '<p>Peraturan Desa yang mengatur tata kelola pemerintahan dan pelayanan masyarakat Desa Aeng Tong-Tong.</p>',
            ],
        ];

        foreach ($items as $item) {
            $document = Document::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'file_path' => 'documents/'.$item['filename'],
                    'file_name' => $item['filename'],
                    'file_size' => $this->sampleFileSize(),
                    'file_type' => 'application/pdf',
                    'description' => $item['description'],
                    'download_count' => random_int(50, 400),
                    'status' => DocumentStatus::PUBLISHED,
                    'published_at' => now()->subDays(random_int(10, 120)),
                ],
            );

            $this->ensureSampleFile($item['filename']);
        }
    }

    private function ensureSampleFile(string $filename): void
    {
        $path = 'documents/'.$filename;

        if (Storage::disk('public')->exists($path)) {
            return;
        }

        Storage::disk('public')->put(
            $path,
            "%PDF-1.4\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 595 842]>>endobj\nxref\n0 4\n0000000000 65535 f \n0000000009 00000 n \n0000000052 00000 n \n0000000101 00000 n \ntrailer<</Size 4/Root 1 0 R>>\nstartxref\n170\n%%EOF\n",
        );
    }

    private function sampleFileSize(): string
    {
        return round(random_int(80, 500) / 10, 1).' KB';
    }
}
