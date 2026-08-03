<?php

use App\Http\Controllers\Admin\Content\AgendaController;
use App\Http\Controllers\Admin\Content\AnnouncementController;
use App\Http\Controllers\Admin\Content\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\Content\NewsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Data\ApbdesController;
use App\Http\Controllers\Admin\Data\DocumentController as AdminDocumentController;
use App\Http\Controllers\Admin\Data\StatisticController;
use App\Http\Controllers\Admin\Economy\KerisController;
use App\Http\Controllers\Admin\Economy\TourismController;
use App\Http\Controllers\Admin\Economy\UmkmController;
use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\MasterData\OfficialController;
use App\Http\Controllers\Admin\MasterData\StructureController;
use App\Http\Controllers\Admin\MasterData\VillageController;
use App\Http\Controllers\Admin\Media\BannerController;
use App\Http\Controllers\Admin\Media\GalleryController;
use App\Http\Controllers\Admin\Media\VideoController;
use App\Http\Controllers\Admin\Profile\PotentialController;
use App\Http\Controllers\Admin\Profile\VillageHistoryController;
use App\Http\Controllers\Admin\Profile\VillageProfileController;
use App\Http\Controllers\Admin\Profile\VisionMissionController;
use App\Http\Controllers\Admin\Service\ContactController as ServiceContactController;
use App\Http\Controllers\Admin\Service\MessageController;
use App\Http\Controllers\Admin\System\ActivityLogController;
use App\Http\Controllers\Admin\System\ProfileController;
use App\Http\Controllers\Admin\System\RoleController;
use App\Http\Controllers\Admin\System\SettingController;
use App\Http\Controllers\Admin\System\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\AgendaController as FrontendAgendaController;
use App\Http\Controllers\Frontend\AnnouncementController as FrontendAnnouncementController;
use App\Http\Controllers\Frontend\ApbdesController as FrontendApbdesController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\DocumentController as FrontendDocumentController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\GalleryController as FrontendGalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KerisController as FrontendKerisController;
use App\Http\Controllers\Frontend\NewsController as FrontendNewsController;
use App\Http\Controllers\Frontend\PotentialController as FrontendPotentialController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\Frontend\StatisticController as FrontendStatisticController;
use App\Http\Controllers\Frontend\TourismController as FrontendTourismController;
use App\Http\Controllers\Frontend\UmkmController as FrontendUmkmController;
use App\Http\Controllers\Frontend\VideoController as FrontendVideoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ===== Frontend Publik =====
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/robots.txt', [SitemapController::class, 'robots']);

Route::prefix('tentang')->name('about.')->group(function () {
    Route::get('sejarah', [AboutController::class, 'sejarah'])->name('sejarah');
    Route::get('visi-misi', [AboutController::class, 'visiMisi'])->name('visi-misi');
    Route::get('struktur-organisasi', [AboutController::class, 'struktur'])->name('struktur');
    Route::get('perangkat-desa', [AboutController::class, 'perangkat'])->name('perangkat');
});

Route::get('potensi-desa', [FrontendPotentialController::class, 'index'])->name('potensi');
Route::get('kontak', [ContactController::class, 'index'])->name('kontak');
Route::post('kontak', [ContactController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('kontak.store');
Route::get('faq', [FaqController::class, 'index'])->name('faq');

Route::get('berita', [FrontendNewsController::class, 'index'])->name('news.index');
Route::get('berita/{news:slug}', [FrontendNewsController::class, 'show'])->name('news.show');
Route::get('pengumuman', [FrontendAnnouncementController::class, 'index'])->name('announcements.index');
Route::get('pengumuman/{announcement:slug}', [FrontendAnnouncementController::class, 'show'])->name('announcements.show');
Route::get('agenda', [FrontendAgendaController::class, 'index'])->name('agendas.index');
Route::get('galeri', [FrontendGalleryController::class, 'index'])->name('galleries.index');
Route::get('video', [FrontendVideoController::class, 'index'])->name('videos.index');

Route::get('wisata', [FrontendTourismController::class, 'index'])->name('tourism.index');
Route::get('wisata/{tourism_destination:slug}', [FrontendTourismController::class, 'show'])->name('tourism.show');
Route::get('kerajinan-keris', [FrontendKerisController::class, 'index'])->name('keris.index');
Route::get('kerajinan-keris/{keris_artisan:slug}', [FrontendKerisController::class, 'show'])->name('keris.show');
Route::get('umkm', [FrontendUmkmController::class, 'index'])->name('umkms.index');
Route::get('umkm/{umkm:slug}', [FrontendUmkmController::class, 'show'])->name('umkms.show');

Route::get('statistik', [FrontendStatisticController::class, 'index'])->name('statistics.index');
Route::get('statistik/{statistic:slug}', [FrontendStatisticController::class, 'show'])->name('statistics.show');
Route::get('apbdes', [FrontendApbdesController::class, 'index'])->name('apbdes.index');
Route::get('dokumen', [FrontendDocumentController::class, 'index'])->name('documents.index');
Route::get('dokumen/{document:slug}/unduh', [FrontendDocumentController::class, 'download'])->name('documents.download');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Autentikasi (guest)
        Route::middleware('guest')->group(function () {
            Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

            Route::post('login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('throttle:5,1')
                ->name('login.store');
        });

        // Area terproteksi
        Route::middleware(['auth', 'user.active'])->group(function () {
            Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

            Route::get('/', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('profil', [ProfileController::class, 'show'])
                ->name('profile.show');

            Route::put('profil', [ProfileController::class, 'update'])
                ->name('profile.update');

            Route::put('profil/password', [ProfileController::class, 'updatePassword'])
                ->name('profile.update-password');

            // ===== Master Data =====
            Route::prefix('master-data')->name('master-data.')->group(function () {
                Route::resource('villages', VillageController::class)
                    ->except(['show']);

                Route::resource('structures', StructureController::class)
                    ->except(['show']);

                Route::resource('officials', OfficialController::class)
                    ->except(['show']);

                // Kategori (berita / galeri / video)
                Route::prefix('categories')->name('categories.')->group(function () {
                    foreach (['news', 'gallery', 'video'] as $type) {
                        Route::get($type, [CategoryController::class, 'index'])
                            ->defaults('type', $type)
                            ->name($type.'.index');
                        Route::get($type.'/create', [CategoryController::class, 'create'])
                            ->defaults('type', $type)
                            ->name($type.'.create');
                        Route::post($type, [CategoryController::class, 'store'])
                            ->defaults('type', $type)
                            ->name($type.'.store');
                        Route::get($type.'/{category}/edit', [CategoryController::class, 'edit'])
                            ->defaults('type', $type)
                            ->name($type.'.edit');
                        Route::put($type.'/{category}', [CategoryController::class, 'update'])
                            ->defaults('type', $type)
                            ->name($type.'.update');
                        Route::delete($type.'/{category}', [CategoryController::class, 'destroy'])
                            ->defaults('type', $type)
                            ->name($type.'.destroy');
                    }
                });
            });

            // ===== Profil Desa =====
            Route::prefix('profile')->name('profile.')->group(function () {
                Route::get('village', [VillageProfileController::class, 'edit'])
                    ->name('village.index');
                Route::put('village', [VillageProfileController::class, 'update'])
                    ->name('village.update');

                Route::get('history', [VillageHistoryController::class, 'edit'])
                    ->name('history.index');
                Route::put('history', [VillageHistoryController::class, 'update'])
                    ->name('history.update');

                Route::get('vision-mission', [VisionMissionController::class, 'edit'])
                    ->name('vision-mission.index');
                Route::put('vision-mission', [VisionMissionController::class, 'update'])
                    ->name('vision-mission.update');

                Route::resource('potentials', PotentialController::class)
                    ->except(['show']);
            });

            // ===== Konten =====
            Route::prefix('content')->name('content.')->group(function () {
                Route::resource('news', NewsController::class)
                    ->except(['show']);

                Route::resource('announcements', AnnouncementController::class)
                    ->except(['show']);

                Route::resource('agendas', AgendaController::class)
                    ->except(['show']);

                Route::resource('faqs', AdminFaqController::class)
                    ->except(['show']);
            });

            // ===== Media =====
            Route::prefix('media')->name('media.')->group(function () {
                Route::resource('galleries', GalleryController::class)
                    ->except(['show']);

                Route::resource('videos', VideoController::class)
                    ->except(['show']);

                Route::resource('banners', BannerController::class)
                    ->except(['show']);
            });

            // ===== Ekonomi & Budaya =====
            Route::prefix('economy')->name('economy.')->group(function () {
                Route::resource('tourism', TourismController::class)
                    ->parameters(['tourism' => 'tourism_destination'])
                    ->except(['show']);

                Route::resource('keris', KerisController::class)
                    ->parameters(['keris' => 'keris_artisan'])
                    ->except(['show']);

                Route::resource('umkms', UmkmController::class)
                    ->except(['show']);
            });

            // ===== Data & Laporan =====
            Route::prefix('data-report')->name('data-report.')->group(function () {
                Route::resource('statistics', StatisticController::class)
                    ->except(['show']);

                Route::resource('apbdes', ApbdesController::class)
                    ->parameters(['apbdes' => 'apbdes'])
                    ->except(['show']);

                Route::resource('documents', AdminDocumentController::class)
                    ->parameters(['document' => 'document'])
                    ->except(['show']);
            });

            // ===== Layanan =====
            Route::prefix('service')->name('service.')->group(function () {
                Route::resource('messages', MessageController::class)
                    ->except(['create', 'store', 'edit', 'destroy']);

                Route::get('contacts', [ServiceContactController::class, 'index'])
                    ->name('contacts.index');
                Route::put('contacts', [ServiceContactController::class, 'update'])
                    ->name('contacts.update');
            });

            // ===== Sistem =====
            Route::prefix('system')->name('system.')->group(function () {
                Route::resource('users', UserController::class)
                    ->except(['show']);

                Route::resource('roles', RoleController::class)
                    ->only(['index', 'edit', 'update']);

                Route::get('settings', [SettingController::class, 'index'])
                    ->name('settings.index');
                Route::put('settings', [SettingController::class, 'update'])
                    ->name('settings.update');

                Route::get('activity-log', [ActivityLogController::class, 'index'])
                    ->name('activity-log.index');
            });
        });
    });
