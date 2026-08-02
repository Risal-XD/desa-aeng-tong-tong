<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\KerisArtisan;
use App\Models\TourismDestination;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;

class EconomySeeder extends Seeder
{
    /**
     * Seed contoh data ekonomi & budaya desa.
     */
    public function run(): void
    {
        $village = Village::first();
        $author = User::query()->whereHas('roles', fn ($q) => $q->where('slug', 'editor'))->first() ?? User::first();

        if ($village === null || $author === null) {
            return;
        }

        $this->seedTourism($village, $author);
        $this->seedKerisArtisans($village, $author);
        $this->seedUmkms($village, $author);
    }

    private function seedTourism(Village $village, User $author): void
    {
        $items = [
            [
                'title' => 'Pantai Aeng Tong-Tong',
                'category' => 'Alam',
                'address' => 'Dusun Aeng Tong-Tong, Kec. Saronggi, Kab. Sumenep',
                'description' => '<p>Pantai dengan pasir putih dan pemandangan laut Madura yang indah. Tempat yang tepat untuk menikmati suasana senja dan kuliner laut.</p>',
                'open_hours' => '07.00 – 17.00 WIB',
                'entrance_fee' => 'Rp 10.000',
                'is_featured' => true,
            ],
            [
                'title' => 'Sentra Kerajinan Keris',
                'category' => 'Budaya & Edukasi',
                'address' => 'Dusun Aeng Tong-Tong, Kec. Saronggi, Kab. Sumenep',
                'description' => '<p>Kawasan bengkel para Mpu yang memproduksi keris secara turun-temurun. Pengunjung dapat menyaksikan langsung proses pembuatan keris dan berinteraksi dengan para empu.</p>',
                'open_hours' => '08.00 – 16.00 WIB',
                'entrance_fee' => 'Rp 15.000',
                'is_featured' => true,
            ],
            [
                'title' => 'Kampung Batik Aeng Tong-Tong',
                'category' => 'Kuliner & Kerajinan',
                'address' => 'Dusun Aeng Tong-Tong, Kec. Saronggi, Kab. Sumenep',
                'description' => '<p>Kampung perajin batik khas Madura dengan corak dan motif khas Aeng Tong-Tong. Tersedia workshop membatik untuk pengunjung.</p>',
                'open_hours' => '08.00 – 17.00 WIB',
                'entrance_fee' => null,
                'is_featured' => false,
            ],
        ];

        foreach ($items as $item) {
            TourismDestination::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'category' => $item['category'],
                    'address' => $item['address'],
                    'description' => $item['description'],
                    'open_hours' => $item['open_hours'],
                    'entrance_fee' => $item['entrance_fee'],
                    'image' => null,
                    'is_featured' => $item['is_featured'],
                    'views_count' => random_int(100, 800),
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedKerisArtisans(Village $village, User $author): void
    {
        $items = [
            [
                'name' => 'Mpu Haji Ahmad',
                'title' => 'Mpu',
                'specialties' => ['Pamor', 'Bilah'],
                'experience_years' => '40 tahun',
                'award' => 'Rekor MURI Empu Terbanyak',
                'bio' => '<p>Mpu senior yang telah menekuni pembuatan keris selama lebih dari empat dekade. Karyanya dikenal hingga ke mancanegara.</p>',
            ],
            [
                'name' => 'Mpu Suparman',
                'title' => 'Mpu',
                'specialties' => ['Warangka', 'Ukiran'],
                'experience_years' => '25 tahun',
                'award' => null,
                'bio' => '<p>Mpu yang berfokus pada pembuatan warangka dan seni ukir kayu sebagai pelengkap keris.</p>',
            ],
            [
                'name' => 'Mpu Hasan Basri',
                'title' => 'Empu Muda',
                'specialties' => ['Bilah', 'Pamor'],
                'experience_years' => '15 tahun',
                'award' => null,
                'bio' => '<p>Empu generasi muda penerus tradisi pembuatan keris di Desa Aeng Tong-Tong.</p>',
            ],
        ];

        foreach ($items as $item) {
            KerisArtisan::updateOrCreate(
                ['name' => $item['name']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'title' => $item['title'],
                    'specialties' => $item['specialties'],
                    'experience_years' => $item['experience_years'],
                    'award' => $item['award'],
                    'bio' => $item['bio'],
                    'photo' => null,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedUmkms(Village $village, User $author): void
    {
        $items = [
            [
                'name' => 'Batik Tong-Tong Asri',
                'owner_name' => 'Ibu Siti Aminah',
                'category' => 'Kerajinan',
                'instagram' => '@batik.aengtongtong',
                'description' => '<p>Produsen batik khas Aeng Tong-Tong dengan motif pesisir Madura yang telah menembus pasar ekspor.</p>',
                'is_featured' => true,
            ],
            [
                'name' => 'Keris Nusantara',
                'owner_name' => 'Bapak Junaidi',
                'category' => 'Kerajinan',
                'instagram' => '@keris.aengtongtong',
                'description' => '<p>Workshop dan penjualan keris berkualitas tinggi karya para Mpu desa, melayani pesanan domestik dan mancanegara.</p>',
                'is_featured' => true,
            ],
            [
                'name' => 'Olahan Ikan Laut Segar',
                'owner_name' => 'Ibu Nur Hasanah',
                'category' => 'Kuliner',
                'instagram' => null,
                'description' => '<p>Pengolahan hasil laut menjadi berbagai produk olahan seperti ikan asap, terasi, dan sambal khas Madura.</p>',
                'is_featured' => false,
            ],
        ];

        foreach ($items as $item) {
            Umkm::updateOrCreate(
                ['name' => $item['name']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'owner_name' => $item['owner_name'],
                    'category' => $item['category'],
                    'instagram' => $item['instagram'],
                    'description' => $item['description'],
                    'logo' => null,
                    'cover_image' => null,
                    'is_featured' => $item['is_featured'],
                    'is_active' => true,
                ],
            );
        }
    }
}
