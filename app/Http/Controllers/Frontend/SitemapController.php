<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\KerisArtisan;
use App\Models\News;
use App\Models\Statistic;
use App\Models\TourismDestination;
use App\Models\Umkm;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    /**
     * Menghasilkan sitemap.xml dinamis berisi seluruh URL publik.
     */
    public function index(): Response
    {
        $urls = collect($this->staticUrls())
            ->merge($this->modelUrls());

        $content = $this->renderSitemap($urls);

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * robots.txt mengizinkan crawler dan mengarahkan ke sitemap.
     */
    public function robots(): Response
    {
        $content = "User-agent: *\n"
            ."Allow: /\n"
            ."Disallow: /admin\n"
            ."Disallow: /storage/private\n"
            .'Sitemap: '.url('/sitemap.xml')."\n";

        return response($content, 200, [
            'Content-Type' => 'text/plain; charset=utf-8',
        ]);
    }

    /**
     * @return list<array{loc: string, lastmod: string|null, priority: float}>
     */
    private function staticUrls(): array
    {
        $routes = [
            'home' => 1.0,
            'about.sejarah' => 0.7,
            'about.visi-misi' => 0.7,
            'about.struktur' => 0.7,
            'about.perangkat' => 0.7,
            'news.index' => 0.9,
            'announcements.index' => 0.8,
            'agendas.index' => 0.7,
            'galleries.index' => 0.7,
            'videos.index' => 0.7,
            'documents.index' => 0.8,
            'tourism.index' => 0.8,
            'keris.index' => 0.8,
            'umkms.index' => 0.8,
            'statistics.index' => 0.7,
            'apbdes.index' => 0.7,
            'faq' => 0.6,
            'potensi' => 0.8,
            'kontak' => 0.6,
        ];

        $urls = [];

        foreach ($routes as $name => $priority) {
            if (! Route::has($name)) {
                continue;
            }

            $urls[] = [
                'loc' => route($name),
                'lastmod' => null,
                'priority' => $priority,
            ];
        }

        return $urls;
    }

    /**
     * @return list<array{loc: string, lastmod: string|null, priority: float}>
     */
    private function modelUrls(): array
    {
        $urls = [];

        foreach ($this->sources() as $source) {
            $rows = $source['model']::query()
                ->select(['id', 'slug', 'updated_at'])
                ->where($source['column'], $source['active'])
                ->get();

            foreach ($rows as $row) {
                $urls[] = [
                    'loc' => route($source['route'], $row),
                    'lastmod' => $row->updated_at?->toAtomString(),
                    'priority' => $source['priority'],
                ];
            }
        }

        return $urls;
    }

    /**
     * Definisi model dinamis untuk sitemap.
     *
     * @return list<array{model: class-string, route: string, column: string, active: string, priority: float}>
     */
    private function sources(): array
    {
        return [
            ['model' => News::class, 'route' => 'news.show', 'column' => 'status', 'active' => 'published', 'priority' => 0.8],
            ['model' => Announcement::class, 'route' => 'announcements.show', 'column' => 'status', 'active' => 'published', 'priority' => 0.7],
            ['model' => TourismDestination::class, 'route' => 'tourism.show', 'column' => 'is_active', 'active' => '1', 'priority' => 0.7],
            ['model' => KerisArtisan::class, 'route' => 'keris.show', 'column' => 'is_active', 'active' => '1', 'priority' => 0.6],
            ['model' => Umkm::class, 'route' => 'umkms.show', 'column' => 'is_active', 'active' => '1', 'priority' => 0.6],
            ['model' => Statistic::class, 'route' => 'statistics.show', 'column' => 'is_active', 'active' => '1', 'priority' => 0.6],
        ];
    }

    /**
     * @param  Collection<int, array{loc: string, lastmod: string|null, priority: float}>  $urls
     */
    private function renderSitemap($urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $url) {
            $xml .= '  <url>'."\n";
            $xml .= '    <loc>'.e($url['loc']).'</loc>'."\n";
            $xml .= '    <priority>'.number_format($url['priority'], 1).'</priority>'."\n";
            $xml .= '    <changefreq>daily</changefreq>'."\n";

            if ($url['lastmod']) {
                $xml .= '    <lastmod>'.e($url['lastmod']).'</lastmod>'."\n";
            }

            $xml .= '  </url>'."\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
