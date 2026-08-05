<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Apbdes;
use App\Models\Banner;
use App\Models\Document;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use App\Models\KerisArtisan;
use App\Models\Message;
use App\Models\Mission;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\OrganizationalStructure;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Statistic;
use App\Models\TourismDestination;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\Village;
use App\Models\VillageHistory;
use App\Models\VillageOfficial;
use App\Models\VillagePotential;
use App\Models\VillageProfile;
use App\Models\Vision;
use App\Observers\FrontendCacheObserver;
use App\Policies\ActivityLogPolicy;
use App\Policies\AgendaPolicy;
use App\Policies\AnnouncementPolicy;
use App\Policies\ApbdesPolicy;
use App\Policies\BannerPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\FaqPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\KerisPolicy;
use App\Policies\MessagePolicy;
use App\Policies\NewsPolicy;
use App\Policies\OfficialPolicy;
use App\Policies\PotentialPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\StatisticPolicy;
use App\Policies\StructurePolicy;
use App\Policies\TourismPolicy;
use App\Policies\UmkmPolicy;
use App\Policies\UserPolicy;
use App\Policies\VideoPolicy;
use App\Policies\VillagePolicy;
use App\Policies\VisionMissionPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->configureGates();

        foreach (FrontendCacheObserver::models() as $model) {
            $model::observe(FrontendCacheObserver::class);
        }
    }

    private function configureRateLimiting(): void
    {
        RateLimiter::for('admin-login', function (Request $request) {
            $email = (string) $request->input('email', '');
            return Limit::perMinute(5)->by(mb_strtolower($email).'|'.$request->ip());
        });
    }

    /**
     * Registrasi otorisasi berbasis policy + permission (RBAC).
     *
     * Pendekatan "catch-all" dipilih agar:
     * 1. Tidak bergantung pada tabel permission saat aplikasi boot (aman sebelum migrasi).
     * 2. Tidak ada cache basi permission di lingkungan testing.
     * 3. Setiap slug permission otomatis berlaku sebagai ability (mis. news-create).
     */
    private function configureGates(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);

        // Master Data
        Gate::policy(Village::class, VillagePolicy::class);
        Gate::policy(OrganizationalStructure::class, StructurePolicy::class);
        Gate::policy(VillageOfficial::class, OfficialPolicy::class);
        Gate::policy(NewsCategory::class, CategoryPolicy::class);
        Gate::policy(GalleryCategory::class, CategoryPolicy::class);
        Gate::policy(VideoCategory::class, CategoryPolicy::class);

        // Konten
        Gate::policy(News::class, NewsPolicy::class);
        Gate::policy(Announcement::class, AnnouncementPolicy::class);
        Gate::policy(Agenda::class, AgendaPolicy::class);
        Gate::policy(Faq::class, FaqPolicy::class);

        // Media
        Gate::policy(Gallery::class, GalleryPolicy::class);
        Gate::policy(Video::class, VideoPolicy::class);
        Gate::policy(Banner::class, BannerPolicy::class);

        // Profil Desa
        Gate::policy(VillageProfile::class, ProfilePolicy::class);
        Gate::policy(VillageHistory::class, ProfilePolicy::class);
        Gate::policy(Vision::class, VisionMissionPolicy::class);
        Gate::policy(Mission::class, VisionMissionPolicy::class);
        Gate::policy(VillagePotential::class, PotentialPolicy::class);

        // Ekonomi & Budaya
        Gate::policy(TourismDestination::class, TourismPolicy::class);
        Gate::policy(KerisArtisan::class, KerisPolicy::class);
        Gate::policy(Umkm::class, UmkmPolicy::class);

        // Data & Laporan
        Gate::policy(Statistic::class, StatisticPolicy::class);
        Gate::policy(Apbdes::class, ApbdesPolicy::class);
        Gate::policy(Document::class, DocumentPolicy::class);

        // Sistem & Layanan
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(ActivityLog::class, ActivityLogPolicy::class);
        Gate::policy(Message::class, MessagePolicy::class);

        Gate::before(function ($user, string $ability): ?bool {
            if (! $user instanceof User) {
                return null;
            }

            // Super Admin melewati seluruh pemeriksaan.
            if ($user->hasRole(Role::SUPER_ADMIN)) {
                return true;
            }

            // Ability lain (mis. 'update', 'delete', 'view') diteruskan ke policy.
            return $user->hasPermission($ability) ? true : null;
        });
    }
}
