<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use App\Models\Village;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $village = Village::query()->orderBy('id')->first();
        $villageId = $village?->getKey();

        Message::updateOrCreate(
            ['email' => 'wahyu.saputra@gmail.com', 'subject' => 'Informasi Rapat Musyawarah Desa'],
            [
                'village_id' => $villageId,
                'name' => 'Wahyu Saputra',
                'phone' => '081234567811',
                'message' => 'Assalamualaikum, saya ingin bertanya jadwal rapat musyawarah desa bulan ini. Terima kasih.',
                'status' => 'baru',
            ],
        );

        Message::updateOrCreate(
            ['email' => 'siti.nurhaliza@gmail.com', 'subject' => 'Pertanyaan Bantuan UMKM'],
            [
                'village_id' => $villageId,
                'name' => 'Siti Nurhaliza',
                'phone' => null,
                'message' => 'Apakah ada program bantuan atau pelatihan untuk UMKM di Desa Aeng Tong-Tong? Saya pemilik usaha kripik.',
                'status' => 'dibalas',
                'reply' => 'Waalaikumsalam. Saat ini ada program pelatihan UMKM bekerja sama dengan Dinas Koperasi. Silakan hubungi kantor desa untuk mendaftar.',
                'replied_at' => now()->subDay(),
            ],
        );
    }
}
