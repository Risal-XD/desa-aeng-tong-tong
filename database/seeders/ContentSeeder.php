<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Faq;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\User;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Seed contoh konten desa.
     */
    public function run(): void
    {
        $village = Village::first();
        $author = User::query()->whereHas('roles', fn ($q) => $q->where('slug', 'editor'))->first() ?? User::first();

        if ($village === null || $author === null) {
            return;
        }

        $this->seedNewsCategories();
        $this->seedNews($village, $author);
        $this->seedAnnouncements($village, $author);
        $this->seedAgendas($village, $author);
        $this->seedFaqs($village, $author);
    }

    private function seedNewsCategories(): void
    {
        foreach (['Berita Desa', 'Budaya', 'Pemerintahan', 'Ekonomi', 'Kegiatan'] as $name) {
            NewsCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'is_active' => true],
            );
        }
    }

    private function seedNews(Village $village, User $author): void
    {
        $items = [
            [
                'title' => 'Desa Aeng Tong-Tong Selenggarakan Festival Keris', 'category' => 'Budaya',
                'excerpt' => 'Puluhan empu dan perajin keris dari berbagai daerah memeriahkan festival keris tahunan di desa.',
                'content' => '<p>Desa Aeng Tong-Tong dikenal sebagai salah satu sentra kerajinan keris di Madura. Festival Keris tahunan ini diadakan untuk melestarikan warisan budaya leluhur.</p><p>Kegiatan berlangsung di halaman balai desa dan diikuti oleh para empu, perajin, serta kolektor keris dari berbagai daerah.</p>',
                'tags' => ['budaya', 'keris', 'festival'],
                'status' => 'published',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Pembangunan Jalan Lingkungan Tahap III Dimulai', 'category' => 'Berita Desa',
                'excerpt' => 'Pemerintah desa memulai pembangunan jalan lingkungan untuk memperlancar mobilitas warga.',
                'content' => '<p>Pembangunan jalan lingkungan tahap ketiga resmi dimulai. Proyek ini mencakup pengecoran jalan sepanjang 1,2 kilometer di tiga dusun.</p><p>Pembangunan ditargetkan selesai dalam dua bulan dan didanai dari APBDes serta bantuan pemerintah kabupaten.</p>',
                'tags' => ['pembangunan', 'infrastruktur'],
                'status' => 'published',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'UMKM Batik Aeng Tong-Tong Tembus Pasar Ekspor', 'category' => 'Ekonomi',
                'excerpt' => 'Produk batik khas Aeng Tong-Tong mulai diminati pasar mancanegara.',
                'content' => '<p>Melalui pendampingan pemerintah desa dan dinas koperasi, produk batik khas Aeng Tong-Tong berhasil menembus pasar ekspor ke beberapa negara ASEAN.</p><p>Kepala desa menyampaikan apresiasinya kepada para perajin dan berkomitmen untuk terus mendukung pengembangan UMKM.</p>',
                'tags' => ['umkm', 'batik', 'ekspor'],
                'status' => 'published',
                'published_at' => now()->subDays(14),
            ],
        ];

        foreach ($items as $item) {
            $category = NewsCategory::where('name', $item['category'])->first();

            News::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'news_category_id' => $category?->getKey(),
                    'user_id' => $author->getKey(),
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'tags' => $item['tags'],
                    'status' => $item['status'],
                    'published_at' => $item['published_at'],
                    'views_count' => random_int(50, 500),
                ],
            );
        }
    }

    private function seedAnnouncements(Village $village, User $author): void
    {
        $items = [
            [
                'title' => 'Pemutakhiran Data Penerima Bantuan Pangan',
                'content' => '<p>Kepada warga desa, pemerintah desa akan melakukan pemutakhiran data penerima bantuan pangan pada bulan ini.</p><p>Warga diharapkan menyiapkan dokumen kependudukan untuk kelancaran verifikasi.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'expired_at' => now()->addDays(20),
            ],
            [
                'title' => 'Jadwal Posyandu Bulan Ini',
                'content' => '<p>Posyandu melayani pemeriksaan kesehatan balita dan ibu hamil setiap hari Rabu pekan pertama dan ketiga.</p>',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'expired_at' => null,
            ],
        ];

        foreach ($items as $item) {
            Announcement::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'content' => $item['content'],
                    'status' => $item['status'],
                    'published_at' => $item['published_at'],
                    'expired_at' => $item['expired_at'],
                ],
            );
        }
    }

    private function seedAgendas(Village $village, User $author): void
    {
        $items = [
            [
                'title' => 'Rapat Musyawarah Desa (Musdes)', 'description' => '<p>Membahas rancangan APBDes perubahan dan prioritas pembangunan.</p>',
                'location' => 'Balai Desa Aeng Tong-Tong', 'event_date' => now()->addDays(5),
                'start_time' => '09:00', 'end_time' => '12:00', 'status' => 'published', 'is_featured' => true,
            ],
            [
                'title' => 'Gotong Royong Bersih Pantai', 'description' => '<p>Kegiatan bersih-bersih pantai dan area wisata dalam rangka menjaga kebersihan lingkungan.</p>',
                'location' => 'Pantai Aeng Tong-Tong', 'event_date' => now()->addDays(12),
                'start_time' => '07:00', 'end_time' => '10:00', 'status' => 'published', 'is_featured' => false,
            ],
            [
                'title' => 'Pelatihan UMKM dan Digitalisasi', 'description' => '<p>Pelatihan bagi pelaku UMKM untuk memasarkan produk secara digital.</p>',
                'location' => 'Rumah Kreatif Desa', 'event_date' => now()->addDays(20),
                'start_time' => '13:00', 'end_time' => '16:00', 'status' => 'published', 'is_featured' => false,
            ],
        ];

        foreach ($items as $item) {
            Agenda::updateOrCreate(
                ['title' => $item['title']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'description' => $item['description'],
                    'location' => $item['location'],
                    'event_date' => $item['event_date'],
                    'start_time' => $item['start_time'],
                    'end_time' => $item['end_time'],
                    'status' => $item['status'],
                    'is_featured' => $item['is_featured'],
                ],
            );
        }
    }

    private function seedFaqs(Village $village, User $author): void
    {
        $items = [
            ['question' => 'Bagaimana cara mengurus surat keterangan domisili?', 'answer' => '<p>Warga dapat mengurus surat keterangan domisili di balai desa pada jam kerja dengan membawa KTP dan KK.</p>', 'category' => 'Administrasi', 'sort_order' => 1],
            ['question' => 'Kapan jadwal pembayaran pajak desa?', 'answer' => '<p>Pembayaran pajak desa dilaksanakan setiap bulan melalui RT/RW masing-masing.</p>', 'category' => 'Administrasi', 'sort_order' => 2],
            ['question' => 'Apakah ada paket wisata di Aeng Tong-Tong?', 'answer' => '<p>Ya, tersedia paket wisata pantai dan edukasi kerajinan keris. Hubungi pengelola wisata desa untuk informasi lebih lanjut.</p>', 'category' => 'Wisata', 'sort_order' => 3],
        ];

        foreach ($items as $item) {
            Faq::updateOrCreate(
                ['question' => $item['question']],
                [
                    'village_id' => $village->getKey(),
                    'user_id' => $author->getKey(),
                    'answer' => $item['answer'],
                    'category' => $item['category'],
                    'sort_order' => $item['sort_order'],
                    'is_active' => true,
                ],
            );
        }
    }
}
