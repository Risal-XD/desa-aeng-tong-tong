<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GalleryCategory;
use App\Models\NewsCategory;
use App\Models\OrganizationalStructure;
use App\Models\VideoCategory;
use App\Models\Village;
use App\Models\VillageOfficial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VillageSeeder extends Seeder
{
    /**
     * Seed data master desa Aeng Tong-Tong.
     */
    public function run(): void
    {
        $village = Village::firstOrCreate(
            ['code' => '3529152001'],
            [
                'name' => 'Aeng Tong-Tong',
                'code' => '3529152001',
                'district' => 'Saronggi',
                'regency' => 'Sumenep',
                'province' => 'Jawa Timur',
                'address' => 'Jl. Raya Aeng Tong-Tong, Kec. Saronggi',
                'latitude' => -6.8891782,
                'longitude' => 113.8290572,
                'area' => 4.52,
                'total_hamlet' => 4,
                'description' => 'Desa wisata sentra kerajinan keris yang meraih Rekor MURI sebagai desa dengan Mpu (pembuat keris) terbanyak di dunia serta Juara 1 ADWI 2022.',
            ]
        );

        $this->seedProfile($village);
        $this->seedHistory($village);
        $this->seedVisionMissions($village);
        $this->seedStructures($village);
        $this->seedCategories();
        $this->seedPotentials($village);
    }

    private function seedProfile(Village $village): void
    {
        $village->profile()->updateOrCreate([], [
            'overview' => '<p>Desa Aeng Tong-Tong terletak di Kecamatan Saronggi, Kabupaten Sumenep, Provinsi Jawa Timur. Desa ini dikenal sebagai sentra kerajinan keris dan berhasil menyabet Rekor MURI sebagai desa dengan Mpu terbanyak di dunia. Pada tahun 2022, desa ini meraih Juara 1 Anugerah Desa Wisata Indonesia (ADWI).</p>',
            'geographic' => '<p>Desa Aeng Tong-Tong memiliki luas wilayah sekitar 4,52 km&sup2; dan terbagi menjadi beberapa dusun. Wilayahnya berada di pesisir dengan bentang alam khas Madura.</p>',
            'demographics_summary' => '<p>Penduduk Desa Aeng Tong-Tong mayoritas bermata pencaharian sebagai perajin keris, petani, dan nelayan. Masyarakatnya terkenal ramah dan menjunjung tinggi nilai budaya.</p>',
        ]);
    }

    private function seedHistory(Village $village): void
    {
        $village->history()->updateOrCreate([], [
            'history_content' => '<p>Aengtongtong adalah sebuah desa di Kecamatan Saronggi, Kabupaten Sumenep, Provinsi Jawa Timur. Aengtongtong dalam bahasa Madura berasal dari kata “aeng” yang berarti air, sementara “tong –tong” adalah bejana yang dibawa dengan cara dijinjing karena letak geografis Desa Aengtongtong yang ada di lereng bukit dan berbatu-batu, menyebabkan warga harus membawa semacam gentong untuk mendapatkan air di mata air yang terletak di bagian barat Desa Aengtongtong, dalam arti masyarakatnya waktu jaman dulu gemar menggotong air atau membawa air.

Desa Aengtongtong terkenal akan industri kreatif pembuatan Keris terbesar dengan empu keris terbanyak di dunia, sehingga Sumenep dikenal dengan kota Keris. Budaya penempaan Keris dimulai pada masa Aria Wiraraja yang merupakan Bangsawan Wengker dipindah tugaskan ke ujung pulau Madura dengan membawa beserta orang-orang Wengker yang pandai membuat Keris.</p>',
            'founder_name' => 'Mpu yang dihormati masyarakat desa',
            'founded_year' => 1800,
            'status' => 'published',
        ]);
    }

    private function seedVisionMissions(Village $village): void
    {
        $village->visions()->delete();
        $village->missions()->delete();

        $village->visions()->create([
            'vision' => 'Terwujudnya Desa Aeng Tong-Tong yang mandiri, sejahtera, dan berbudaya sebagai desa wisata keris terkemuka.',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        foreach ([
            'Melestarikan dan mengembangkan kerajinan keris sebagai warisan budaya.',
            'Meningkatkan kesejahteraan masyarakat melalui pariwisata dan ekonomi kreatif.',
            'Membangun pemerintahan desa yang transparan dan melayani.',
        ] as $index => $mission) {
            $village->missions()->create([
                'mission' => $mission,
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    private function seedStructures(Village $village): void
    {
        $village->structures()->delete();
        $village->officials()->delete();

        $kades = OrganizationalStructure::create([
            'village_id' => $village->id,
            'name' => 'Pemerintah Desa',
            'position' => 'Kepala Desa',
            'level' => 1,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $sekre = OrganizationalStructure::create([
            'village_id' => $village->id,
            'parent_id' => $kades->id,
            'name' => 'Sekretariat Desa',
            'position' => 'Sekretaris Desa',
            'level' => 2,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        OrganizationalStructure::create([
            'village_id' => $village->id,
            'parent_id' => $sekre->id,
            'name' => 'Kaur Pemerintahan',
            'position' => 'Kepala Urusan Pemerintahan',
            'level' => 3,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        OrganizationalStructure::create([
            'village_id' => $village->id,
            'parent_id' => $kades->id,
            'name' => 'Badan Permusyawaratan Desa (BPD)',
            'position' => 'Ketua BPD',
            'level' => 2,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        VillageOfficial::create([
            'village_id' => $village->id,
            'structure_id' => $kades->id,
            'name' => 'H. Abd. Rahem, S.Pd.I',
            'position' => 'Kepala Desa',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }

    private function seedCategories(): void
    {
        foreach ([
            'Berita Desa',
            'Budaya',
            'Pariwisata',
        ] as $name) {
            NewsCategory::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]);
        }

        foreach ([
            'Kegiatan Desa',
            'Kerajinan Keris',
            'Wisata',
        ] as $name) {
            GalleryCategory::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]);
        }

        foreach ([
            'Profil Desa',
            'Kegiatan',
        ] as $name) {
            VideoCategory::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'is_active' => true]);
        }
    }

    private function seedPotentials(Village $village): void
    {
        $potentials = [
            [
                'title' => 'Sentra Kerajinan Keris',
                'category' => 'Kerajinan',
                'is_featured' => true,
                'description' => '<p>Desa Aeng Tong-Tong merupakan sentra pembuatan keris dengan puluhan Mpu yang menurunkan keahlian dari generasi ke generasi. Rekor MURI diraih sebagai desa dengan Mpu terbanyak di dunia.</p>',
            ],
            [
                'title' => 'Wisata Budaya Desa',
                'category' => 'Wisata',
                'is_featured' => true,
                'description' => '<p>Kegiatan wisata budaya seperti prosesi pembuatan keris dan pagelaran seni menjadi daya tarik wisatawan, mendukung predikat Juara 1 ADWI 2022.</p>',
            ],
            [
                'title' => 'Ekonomi Kreatif UMKM',
                'category' => 'UMKM',
                'is_featured' => false,
                'description' => '<p>Produk kerajinan dan kuliner khas desa dikembangkan untuk mendorong perekonomian masyarakat.</p>',
            ],
        ];

        foreach ($potentials as $index => $data) {
            $village->potentials()->updateOrCreate(
                ['title' => $data['title']],
                [
                    'user_id' => null,
                    'category' => $data['category'],
                    'is_featured' => $data['is_featured'],
                    'description' => $data['description'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
