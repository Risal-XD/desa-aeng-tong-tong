<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * @var array<string, array{group: string, value: string}>
     */
    private const SETTINGS = [
        'site_name' => ['group' => 'general', 'value' => 'Desa Aeng Tong-Tong'],
        'site_tagline' => ['group' => 'general', 'value' => 'Desa Wisata Sentra Kerajinan Keris'],
        'site_description' => ['group' => 'general', 'value' => 'Website resmi Desa Aeng Tong-Tong, Kecamatan Saronggi, Kabupaten Sumenep, Jawa Timur.'],
        'meta_title' => ['group' => 'seo', 'value' => 'Desa Aeng Tong-Tong - Website Resmi Desa'],
        'meta_description' => ['group' => 'seo', 'value' => 'Profil, potensi, berita, dan layanan Desa Aeng Tong-Tong, Kec. Saronggi, Kab. Sumenep, Jawa Timur.'],
        'meta_keywords' => ['group' => 'seo', 'value' => 'desa, aeng tong-tong, sumenep, saronggi, keris, wisata desa'],
        'contact_phone' => ['group' => 'contact', 'value' => '(0328) 123456'],
        'contact_email' => ['group' => 'contact', 'value' => 'desa.aengtongtong@gmail.com'],
        'contact_whatsapp' => ['group' => 'contact', 'value' => '081234567890'],
        'contact_address' => ['group' => 'contact', 'value' => 'Jl. Raya Aeng Tong-Tong No. 1, Saronggi, Sumenep, Jawa Timur'],
        'office_hours' => ['group' => 'contact', 'value' => 'Senin - Jumat, 08.00 - 15.00 WIB'],
        'sosmed_facebook' => ['group' => 'sosmed', 'value' => 'https://facebook.com/aengtongtong'],
        'sosmed_instagram' => ['group' => 'sosmed', 'value' => 'https://instagram.com/aengtongtong'],
        'sosmed_twitter' => ['group' => 'sosmed', 'value' => 'https://twitter.com/aengtongtong'],
        'sosmed_youtube' => ['group' => 'sosmed', 'value' => 'https://youtube.com/@aengtongtong'],
        'sosmed_tiktok' => ['group' => 'sosmed', 'value' => 'https://tiktok.com/@aengtongtong'],
    ];

    public function run(): void
    {
        foreach (self::SETTINGS as $key => $config) {
            Setting::updateOrCreate(
                ['key' => $key],
                [
                    'group' => $config['group'],
                    'value' => $config['value'],
                    'type' => 'string',
                ],
            );
        }
    }
}
