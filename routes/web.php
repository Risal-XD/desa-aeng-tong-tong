<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasterData\CategoryController;
use App\Http\Controllers\Admin\MasterData\OfficialController;
use App\Http\Controllers\Admin\MasterData\StructureController;
use App\Http\Controllers\Admin\MasterData\VillageController;
use App\Http\Controllers\Admin\Profile\PotentialController;
use App\Http\Controllers\Admin\Profile\VillageHistoryController;
use App\Http\Controllers\Admin\Profile\VillageProfileController;
use App\Http\Controllers\Admin\Profile\VisionMissionController;
use App\Http\Controllers\Admin\System\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

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
        });
    });
