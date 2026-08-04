@props(['active' => null])

@php
    $user = auth()->user();
    $roles = $user->roles->pluck('name')->implode(', ');
    $unreadMessages = auth()->user()->can('message-view')
        ? \App\Models\Message::unread()->count()
        : 0;

    $icons = [
        'dashboard' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>',
        'user' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
        'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        'news' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
    ];

    $menus = [
        [
            'group' => 'Utama',
            'items' => [
                ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard'],
            ],
        ],
        [
            'group' => 'Master Data',
            'items' => [
                ['label' => 'Data Desa', 'icon' => 'dashboard', 'route' => 'admin.master-data.villages.index', 'perm' => 'village-view'],
                ['label' => 'Struktur Organisasi', 'icon' => 'users', 'route' => 'admin.master-data.structures.index', 'perm' => 'structure-view'],
                ['label' => 'Perangkat Desa', 'icon' => 'users', 'route' => 'admin.master-data.officials.index', 'perm' => 'official-view'],
                ['label' => 'Kategori', 'icon' => 'news', 'route' => 'admin.master-data.categories.news.index', 'perm' => 'category-view'],
            ],
        ],
        [
            'group' => 'Profil Desa',
            'items' => [
                ['label' => 'Profil & Sejarah', 'icon' => 'news', 'route' => 'admin.profile.village.index', 'perm' => 'profile-view'],
                ['label' => 'Visi & Misi', 'icon' => 'news', 'route' => 'admin.profile.vision-mission.index', 'perm' => 'vision-mission-view'],
                ['label' => 'Potensi Desa', 'icon' => 'dashboard', 'route' => 'admin.profile.potentials.index', 'perm' => 'potential-view'],
            ],
        ],
        [
            'group' => 'Konten',
            'items' => [
                ['label' => 'Berita', 'icon' => 'news', 'route' => 'admin.content.news.index', 'perm' => 'news-view'],
                ['label' => 'Pengumuman', 'icon' => 'news', 'route' => 'admin.content.announcements.index', 'perm' => 'announcement-view'],
                ['label' => 'Agenda', 'icon' => 'dashboard', 'route' => 'admin.content.agendas.index', 'perm' => 'agenda-view'],
                ['label' => 'FAQ', 'icon' => 'news', 'route' => 'admin.content.faqs.index', 'perm' => 'faq-view'],
            ],
        ],
        [
            'group' => 'Media',
            'items' => [
                ['label' => 'Galeri Foto', 'icon' => 'dashboard', 'route' => 'admin.media.galleries.index', 'perm' => 'gallery-view'],
                ['label' => 'Video', 'icon' => 'dashboard', 'route' => 'admin.media.videos.index', 'perm' => 'video-view'],
                ['label' => 'Banner', 'icon' => 'dashboard', 'route' => 'admin.media.banners.index', 'perm' => 'banner-view'],
            ],
        ],
        [
            'group' => 'Ekonomi & Budaya',
            'items' => [
                ['label' => 'Wisata', 'icon' => 'dashboard', 'route' => 'admin.economy.tourism.index', 'perm' => 'tourism-view'],
                ['label' => 'Kerajinan Keris', 'icon' => 'dashboard', 'route' => 'admin.economy.keris.index', 'perm' => 'keris-view'],
                ['label' => 'UMKM', 'icon' => 'dashboard', 'route' => 'admin.economy.umkms.index', 'perm' => 'umkm-view'],
            ],
        ],
        [
            'group' => 'Data & Laporan',
            'items' => [
                ['label' => 'Statistik Desa', 'icon' => 'dashboard', 'route' => 'admin.data-report.statistics.index', 'perm' => 'statistic-view'],
                ['label' => 'APBDes', 'icon' => 'dashboard', 'route' => 'admin.data-report.apbdes.index', 'perm' => 'apbdes-view'],
                ['label' => 'Dokumen', 'icon' => 'news', 'route' => 'admin.data-report.documents.index', 'perm' => 'document-view'],
            ],
        ],
        [
            'group' => 'Layanan',
            'items' => [
                ['label' => 'Pesan Masuk', 'icon' => 'news', 'route' => 'admin.service.messages.index', 'perm' => 'message-view'],
                ['label' => 'Kontak Desa', 'icon' => 'dashboard', 'route' => 'admin.service.contacts.index', 'perm' => 'contact-view'],
            ],
        ],
        [
            'group' => 'Sistem',
            'items' => [
                ['label' => 'Pengguna', 'icon' => 'users', 'route' => 'admin.system.users.index', 'perm' => 'user-view'],
                ['label' => 'Role & Permission', 'icon' => 'shield', 'route' => 'admin.system.roles.index', 'perm' => 'role-view'],
                ['label' => 'Pengaturan Website', 'icon' => 'settings', 'route' => 'admin.system.settings.index', 'perm' => 'setting-view'],
                ['label' => 'Activity Log', 'icon' => 'activity', 'route' => 'admin.system.activity-log.index', 'perm' => 'activity-log-view'],
            ],
        ],
    ];
@endphp

<aside
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-on-primary lg:sticky lg:top-0 lg:flex lg:h-screen lg:translate-x-0 lg:flex-col"
>
    <!-- Header/Brand -->
    <div class="flex items-center gap-3 border-b border-primary-container/30 px-5 py-5 h-16 shrink-0">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-surface-container-lowest text-sm font-bold text-primary shadow-sm">
            AT
        </div>
        <div class="min-w-0">
            <p class="truncate text-sm font-semibold text-on-primary leading-tight">Desa Aeng Tong-Tong</p>
            <p class="text-[10px] uppercase tracking-wider text-on-primary-container/60 font-medium">Panel Admin</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 space-y-6 overflow-y-auto px-3 py-6 scrollbar-thin scrollbar-thumb-primary-container/50">
        @foreach ($menus as $menu)
            @php
                $visibleItems = collect($menu['items'])->filter(function ($item) {
                    $routeExists = Route::has($item['route']);
                    $allowed = ! isset($item['perm']) || auth()->user()->can($item['perm']);
                    return $routeExists && $allowed;
                });
            @endphp

            @if ($visibleItems->isNotEmpty())
                <div x-data="{ expanded: true }">
                    <button 
                        @click="expanded = !expanded"
                        class="group flex w-full items-center justify-between px-2 pb-2 text-[11px] font-semibold uppercase tracking-widest text-on-primary-container/50 transition-colors hover:text-white"
                    >
                        <span>{{ $menu['group'] }}</span>
                        <svg 
                            class="h-3 w-3 transition-transform duration-200" 
                            :class="expanded ? 'rotate-0' : '-rotate-90'"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                        >
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    
                    <ul x-show="expanded" x-collapse class="space-y-1">
                        @foreach ($visibleItems as $item)
                            @php
                                $isActive = request()->routeIs($item['route'].'*');
                                $label = $item['label'];
                                $iconPath = $icons[$item['icon']] ?? $icons['dashboard'];
                            @endphp
                            <li>
                                <a
                                    href="{{ route($item['route']) }}"
                                    class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200
                                        {{ $isActive 
                                            ? 'bg-primary-container text-white shadow-sm ring-1 ring-white/10' 
                                            : 'text-on-primary/60 hover:bg-white/5 hover:text-white' 
                                        }}"
                                >
                                    <svg class="h-4.5 w-4.5 shrink-0 opacity-80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        {!! $iconPath !!}
                                    </svg>
                                    <span class="flex-1 truncate">{{ $label }}</span>
                                    
                                    @if ($item['route'] === 'admin.service.messages.index' && $unreadMessages > 0)
                                        <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-error px-1.5 text-[10px] font-bold text-on-error ring-1 ring-error/50">
                                            {{ $unreadMessages }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endforeach
    </nav>

    <!-- User Profile Footer -->
    <div class="border-t border-primary-container/30 p-4 shrink-0 bg-primary/50 backdrop-blur-sm">
        <div class="flex items-center gap-3">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-container text-xs font-bold text-on-primary-container ring-1 ring-white/10 overflow-hidden shadow-sm">
                @if ($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                @else
                    {{ mb_substr($user->name, 0, 1) }}
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-semibold text-white leading-none">{{ $user->name }}</p>
                <p class="mt-1 truncate text-[10px] text-on-primary-container/60 font-medium tracking-wide uppercase">{{ $roles }}</p>
            </div>
            <a 
                href="{{ route('admin.profile.show') }}" 
                class="flex h-7 w-7 items-center justify-center rounded-md text-on-primary/40 hover:bg-white/10 hover:text-white transition-colors"
                title="Edit Profil"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>
                </svg>
            </a>
        </div>
    </div>
</aside>
