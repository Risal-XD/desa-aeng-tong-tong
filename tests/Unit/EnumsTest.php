<?php

namespace Tests\Unit;

use App\Enums\AgendaStatus;
use App\Enums\AnnouncementStatus;
use App\Enums\ApbdesType;
use App\Enums\CommonStatus;
use App\Enums\DocumentStatus;
use App\Enums\MessageStatus;
use App\Enums\NewsStatus;
use App\Enums\StatisticCategory;
use App\Enums\VideoPlatform;
use Tests\TestCase;

class EnumsTest extends TestCase
{
    public function test_message_status_label_dan_badge(): void
    {
        $this->assertSame('Baru', MessageStatus::BARU->label());
        $this->assertSame('Dibaca', MessageStatus::DIBACA->label());
        $this->assertSame('Dibalas', MessageStatus::DIBALAS->label());

        $this->assertStringContainsString('amber', MessageStatus::BARU->badge());
        $this->assertStringContainsString('sky', MessageStatus::DIBACA->badge());
        $this->assertStringContainsString('emerald', MessageStatus::DIBALAS->badge());

        $this->assertSame([
            'baru' => 'Baru',
            'dibaca' => 'Dibaca',
            'dibalas' => 'Dibalas',
        ], MessageStatus::options());
    }

    public function test_news_status_label_dan_options(): void
    {
        $this->assertSame('Draf', NewsStatus::DRAFT->label());
        $this->assertSame('Terbit', NewsStatus::PUBLISHED->label());
        $this->assertSame('Terjadwal', NewsStatus::SCHEDULED->label());
        $this->assertSame(['draft', 'published', 'scheduled'], array_keys(NewsStatus::options()));
    }

    public function test_announcement_status_memiliki_scheduled(): void
    {
        $this->assertSame('Terjadwal', AnnouncementStatus::SCHEDULED->label());
        $this->assertSame(['draft', 'published', 'scheduled'], array_keys(AnnouncementStatus::options()));
    }

    public function test_agenda_status_label(): void
    {
        $this->assertSame('Draf', AgendaStatus::DRAFT->label());
        $this->assertSame('Terbit', AgendaStatus::PUBLISHED->label());
    }

    public function test_apbdes_type_label_dan_value(): void
    {
        $this->assertSame('Pendapatan', ApbdesType::INCOME->label());
        $this->assertSame('Belanja', ApbdesType::EXPENSE->label());
        $this->assertSame('Pembiayaan', ApbdesType::FINANCING->label());
        $this->assertSame('pendapatan', ApbdesType::INCOME->value);
    }

    public function test_common_status_label(): void
    {
        $this->assertSame('Aktif', CommonStatus::ACTIVE->label());
        $this->assertSame('Nonaktif', CommonStatus::INACTIVE->label());
    }

    public function test_document_status_label(): void
    {
        $this->assertSame('Draf', DocumentStatus::DRAFT->label());
        $this->assertSame('Terbit', DocumentStatus::PUBLISHED->label());
    }

    public function test_statistic_category_menampung_enam_kategori(): void
    {
        $this->assertSame('Kependudukan', StatisticCategory::POPULATION->label());
        $this->assertSame('Pendidikan', StatisticCategory::EDUCATION->label());
        $this->assertSame('Kesehatan', StatisticCategory::HEALTH->label());
        $this->assertSame('Ekonomi', StatisticCategory::ECONOMY->label());
        $this->assertSame('Sosial', StatisticCategory::SOCIAL->label());
        $this->assertSame('Lainnya', StatisticCategory::OTHER->label());
        $this->assertCount(6, StatisticCategory::options());
    }

    public function test_video_platform_label(): void
    {
        $this->assertSame('YouTube', VideoPlatform::YOUTUBE->label());
        $this->assertSame('Vimeo', VideoPlatform::VIMEO->label());
        $this->assertSame('Lainnya', VideoPlatform::OTHER->label());
    }
}
