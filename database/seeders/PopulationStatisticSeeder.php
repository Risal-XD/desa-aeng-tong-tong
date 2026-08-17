<?php

namespace Database\Seeders;

use App\Enums\StatisticCategory;
use App\Models\Statistic;
use App\Models\Village;
use Illuminate\Database\Seeder;

class PopulationStatisticSeeder extends Seeder
{
    public function run(): void
    {
        $village = Village::first();
        if (!$village) {
            return;
        }

        $this->seedPopulationStatistics($village);
    }

    private function seedPopulationStatistics(Village $village): void
    {
        $data = [
            ['label' => 'Penduduk aktif', 'value' => 1557, 'unit' => 'jiwa'],
            ['label' => 'Total KK', 'value' => 630, 'unit' => 'KK'],
            ['label' => 'Laki-laki', 'value' => 771, 'unit' => 'jiwa'],
            ['label' => 'Perempuan', 'value' => 786, 'unit' => 'jiwa'],
            ['label' => 'Balita (0-5)', 'value' => 90, 'unit' => 'jiwa'],
            ['label' => 'Anak (6-17)', 'value' => 202, 'unit' => 'jiwa'],
            ['label' => 'Produktif (18-59)', 'value' => 992, 'unit' => 'jiwa'],
            ['label' => 'Lansia (60+)', 'value' => 273, 'unit' => 'jiwa'],
        ];

        $statistic = Statistic::updateOrCreate(
            [
                'category' => StatisticCategory::POPULATION->value,
                'year' => now()->year,
            ],
            [
                'village_id' => $village->getKey(),
                'name' => 'Statistik Kependudukan',
                'description' => '<p>Data jumlah penduduk Desa Aeng Tong-Tong berdasarkan jenis kelamin dan kelompok usia.</p>',
                'is_active' => true,
            ]
        );

        // Hapus data lama lalu buat yang baru
        $statistic->populationStatistics()->delete();

        foreach ($data as $index => $row) {
            $statistic->populationStatistics()->create([
                'label' => $row['label'],
                'value' => $row['value'],
                'unit' => $row['unit'],
                'sort_order' => $index,
            ]);
        }
    }
}