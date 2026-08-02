<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Apbdes;
use App\Models\Banner;
use App\Models\Document;
use App\Models\Download;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\KerisArtisan;
use App\Models\Message;
use App\Models\News;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Statistic;
use App\Models\TourismDestination;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Video;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Ringkasan statistik untuk kartu dashboard.
     *
     * @return array<string, int>
     */
    public function getStats(): array
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::active()->count(),
            'total_roles' => Role::count(),
            'total_permissions' => Permission::count(),
            'news' => News::count(),
            'announcements' => Announcement::count(),
            'agendas' => Agenda::count(),
            'faqs' => Faq::count(),
            'galleries' => Gallery::count(),
            'videos' => Video::count(),
            'banners' => Banner::count(),
            'tourism' => TourismDestination::count(),
            'keris' => KerisArtisan::count(),
            'umkms' => Umkm::count(),
            'statistics' => Statistic::count(),
            'apbdes' => Apbdes::count(),
            'documents' => Document::count(),
            'downloads' => Download::count(),
            'messages' => Message::count(),
            'unread_messages' => Message::unread()->count(),
        ];
    }

    /**
     * Data grafik Chart.js untuk dashboard.
     *
     * @return array<string, mixed>
     */
    public function getCharts(): array
    {
        return [
            'newsPerMonth' => $this->newsPerMonth(),
            'population' => $this->latestPopulationStatistic(),
            'apbdes' => $this->apbdesSummary(),
            'topDownloads' => $this->topDownloads(),
        ];
    }

    /**
     * Jumlah berita tayang 6 bulan terakhir (dikelompokkan di PHP agar kompatibel semua DB).
     *
     * @return array{labels: list<string>, values: list<int>}
     */
    private function newsPerMonth(): array
    {
        $start = Carbon::now()->subMonths(5)->startOfMonth();

        $rows = News::query()
            ->published()
            ->where('published_at', '>=', $start)
            ->pluck('published_at')
            ->map(fn ($date) => Carbon::parse($date)->format('Y-m'))
            ->countBy();

        $labels = [];
        $values = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $start->copy()->addMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $values[] = (int) ($rows[$month->format('Y-m')] ?? 0);
        }

        return ['labels' => $labels, 'values' => $values];
    }

    /**
     * Statistik kependudukan terbaru untuk grafik donat.
     *
     * @return array{title: string, labels: list<string>, values: list<int>}|null
     */
    private function latestPopulationStatistic(): ?array
    {
        $statistic = Statistic::query()
            ->active()
            ->with('populationStatistics')
            ->where('category', 'kependudukan')
            ->orderByDesc('year')
            ->first();

        if (! $statistic || $statistic->populationStatistics->isEmpty()) {
            return null;
        }

        return [
            'title' => $statistic->name.' '.$statistic->year,
            'labels' => $statistic->populationStatistics->pluck('label')->all(),
            'values' => $statistic->populationStatistics->pluck('value')->map(fn ($v) => (int) $v)->all(),
        ];
    }

    /**
     * Ringkasan APBDes tahun berjalan (anggaran vs realisasi per jenis).
     *
     * @return array{year: int, labels: list<string>, budget: list<int>, realization: list<int>}
     */
    private function apbdesSummary(): array
    {
        $year = (int) Apbdes::query()->max('year') ?: now()->year;

        $rows = Apbdes::query()
            ->active()
            ->where('year', $year)
            ->select('type', DB::raw('COALESCE(SUM(budget_amount),0) as budget'), DB::raw('COALESCE(SUM(realization_amount),0) as realization'))
            ->groupBy('type')
            ->get()
            ->keyBy('type');

        $labels = [];
        $budget = [];
        $realization = [];

        foreach (['pendapatan', 'belanja', 'pembiayaan'] as $type) {
            $labels[] = ucfirst($type);
            $budget[] = (int) ($rows[$type]->budget ?? 0);
            $realization[] = (int) ($rows[$type]->realization ?? 0);
        }

        return [
            'year' => $year,
            'labels' => $labels,
            'budget' => $budget,
            'realization' => $realization,
        ];
    }

    /**
     * Dokumen terpopuler berdasarkan jumlah unduhan.
     *
     * @return array{labels: list<string>, values: list<int>}
     */
    private function topDownloads(): array
    {
        $documents = Document::query()
            ->published()
            ->where('download_count', '>', 0)
            ->orderByDesc('download_count')
            ->limit(5)
            ->get(['title', 'download_count']);

        return [
            'labels' => $documents->pluck('title')->all(),
            'values' => $documents->pluck('download_count')->map(fn ($v) => (int) $v)->all(),
        ];
    }

    /**
     * Aktivitas terbaru.
     */
    public function recentActivity(int $limit = 8)
    {
        return ActivityLog::query()
            ->with('user')
            ->latest('id')
            ->limit($limit)
            ->get();
    }

    /**
     * Pesan masuk terbaru.
     */
    public function recentMessages(int $limit = 6)
    {
        return Message::query()
            ->newest()
            ->limit($limit)
            ->get();
    }
}
