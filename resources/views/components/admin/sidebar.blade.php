@props(['active' => null])

@php
    $user = auth()->user();
    $roles = $user->roles->pluck('name')->implode(', ');
    $unreadMessages = auth()->user()->can('message-view')
        ? \App\Models\Message::unread()->count()
        : 0;

    $icons = [
        'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
        'building' => '<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M12 6h.01M16 6h.01M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"/>',
        'users' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'user' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'tag' => '<path d="M12 2H2v10l9.29 9.29a1 1 0 0 0 1.42 0l8.58-8.58a1 1 0 0 0 0-1.42z"/><circle cx="7" cy="7" r="1"/>',
        'target' => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
        'sparkle' => '<path d="M12 3l1.9 5.8a2 2 0 0 0 1.3 1.3L21 12l-5.8 1.9a2 2 0 0 0-1.3 1.3L12 21l-1.9-5.8a2 2 0 0 0-1.3-1.3L3 12l5.8-1.9a2 2 0 0 0 1.3-1.3z"/>',
        'news' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>',
        'megaphone' => '<path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
        'help' => '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>',
        'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>',
        'video' => '<path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/><rect x="2" y="6" width="14" height="12" rx="2"/>',
        'map' => '<path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"/><circle cx="12" cy="10" r="3"/>',
        'sword' => '<polyline points="14.5 17.5 3 6 3 3 6 3 17.5 14.5"/><line x1="13" y1="19" x2="19" y2="13"/><line x1="16" y1="16" x2="20" y2="20"/><line x1="19" y1="21" x2="21" y2="19"/>',
        'store' => '<path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2 2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7"/>',
        'chart' => '<line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/>',
        'wallet' => '<path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>',
        'file' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/>',
        'message' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8M8 13h6"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
        'activity' => '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>',
        'chevrons' => '<path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/>',
        'link' => '<path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>',
        'book' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
    ];

    $nav = [
        ['label' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard'],
        'sep',
        ['label' => 'Data Desa', 'icon' => 'building', 'route' => 'admin.master-data.villages.index', 'perm' => 'village-view'],
        ['label' => 'Struktur Organisasi', 'icon' => 'users', 'route' => 'admin.master-data.structures.index', 'perm' => 'structure-view'],
        ['label' => 'Perangkat Desa', 'icon' => 'user', 'route' => 'admin.master-data.officials.index', 'perm' => 'official-view'],
        ['label' => 'Kategori', 'icon' => 'tag', 'route' => 'admin.master-data.categories.news.index', 'perm' => 'category-view'],
        'sep',
        ['label' => 'Profil & Sejarah', 'icon' => 'file', 'route' => 'admin.profile.village.index', 'perm' => 'profile-view'],
        ['label' => 'Visi & Misi', 'icon' => 'target', 'route' => 'admin.profile.vision-mission.index', 'perm' => 'vision-mission-view'],
        ['label' => 'Potensi Desa', 'icon' => 'sparkle', 'route' => 'admin.profile.potentials.index', 'perm' => 'potential-view'],
        'sep',
        ['label' => 'Berita', 'icon' => 'news', 'route' => 'admin.content.news.index', 'perm' => 'news-view'],
        ['label' => 'Pengumuman', 'icon' => 'megaphone', 'route' => 'admin.content.announcements.index', 'perm' => 'announcement-view'],
        ['label' => 'Agenda', 'icon' => 'calendar', 'route' => 'admin.content.agendas.index', 'perm' => 'agenda-view'],
        ['label' => 'FAQ', 'icon' => 'help', 'route' => 'admin.content.faqs.index', 'perm' => 'faq-view'],
        'sep',
        ['label' => 'Galeri Foto', 'icon' => 'image', 'route' => 'admin.media.galleries.index', 'perm' => 'gallery-view'],
        ['label' => 'Video', 'icon' => 'video', 'route' => 'admin.media.videos.index', 'perm' => 'video-view'],
        ['label' => 'Banner', 'icon' => 'image', 'route' => 'admin.media.banners.index', 'perm' => 'banner-view'],
        'sep',
        ['label' => 'Wisata', 'icon' => 'map', 'route' => 'admin.economy.tourism.index', 'perm' => 'tourism-view'],
        ['label' => 'Kerajinan Keris', 'icon' => 'sword', 'route' => 'admin.economy.keris.index', 'perm' => 'keris-view'],
        ['label' => 'UMKM', 'icon' => 'store', 'route' => 'admin.economy.umkms.index', 'perm' => 'umkm-view'],
        'sep',
        ['label' => 'Statistik Desa', 'icon' => 'chart', 'route' => 'admin.data-report.statistics.index', 'perm' => 'statistic-view'],
        ['label' => 'APBDes', 'icon' => 'wallet', 'route' => 'admin.data-report.apbdes.index', 'perm' => 'apbdes-view'],
        ['label' => 'Dokumen', 'icon' => 'file', 'route' => 'admin.data-report.documents.index', 'perm' => 'document-view'],
        ['label' => 'E-Booklet', 'icon' => 'book', 'route' => 'admin.data-report.ebooklet.index', 'perm' => 'setting-view'],
        'sep',
        ['label' => 'Pesan Masuk', 'icon' => 'message', 'route' => 'admin.service.messages.index', 'perm' => 'message-view'],
        ['label' => 'Kontak Desa', 'icon' => 'phone', 'route' => 'admin.service.contacts.index', 'perm' => 'contact-view'],
        'sep',
        ['label' => 'Pengguna', 'icon' => 'users', 'route' => 'admin.system.users.index', 'perm' => 'user-view'],
        ['label' => 'Role & Permission', 'icon' => 'shield', 'route' => 'admin.system.roles.index', 'perm' => 'role-view'],
        ['label' => 'Pengaturan Website', 'icon' => 'settings', 'route' => 'admin.system.settings.index', 'perm' => 'setting-view'],
        ['label' => 'Activity Log', 'icon' => 'activity', 'route' => 'admin.system.activity-log.index', 'perm' => 'activity-log-view'],
    ];

    $visibleNav = collect($nav)->filter(function ($item) {
        if ($item === 'sep') {
            return true;
        }

        return Route::has($item['route'])
            && (! isset($item['perm']) || auth()->user()->can($item['perm']));
    })->values();
@endphp

<aside
    x-data="{
        collapsed: window.matchMedia('(min-width: 1024px)').matches,
        orgOpen: false,
        userOpen: false,
    }"
    @mouseenter="collapsed = false"
    @mouseleave="collapsed = true"
    x-show="sidebarOpen"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    :class="collapsed ? 'lg:w-[3.25rem]' : 'lg:w-60'"
    class="fixed inset-y-0 left-0 z-40 flex w-64 shrink-0 flex-col border-r border-primary-container/30 bg-primary text-on-primary transition-[width] duration-200 ease-out lg:sticky lg:top-0 lg:h-screen lg:translate-x-0"
>
    <!-- Header / Brand -->
    <div class="flex h-16 shrink-0 items-center border-b border-primary-container/30 px-3">
        <div x-data="{ open: false }" @click.outside="open = false" class="relative w-full">
            <button
                @click="open = !open"
                :title="collapsed ? 'Desa Aeng Tong-Tong' : ''"
                class="flex h-9 w-full items-center justify-center gap-2 rounded-lg transition hover:bg-white/5 lg:justify-start lg:px-2"
            >
                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-surface-container-lowest text-xs font-bold text-primary shadow-sm">AT</span>
                <span
                    x-show="!collapsed"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="min-w-0 flex-1 text-left"
                >
                    <span class="block truncate text-sm font-semibold leading-tight">Desa Aeng Tong-Tong</span>
                    <span class="block text-[10px] font-medium uppercase tracking-wider text-on-primary-container/60">Panel Admin</span>
                </span>
                <svg
                    x-show="!collapsed"
                    class="h-3.5 w-3.5 shrink-0 text-on-primary-container/50 transition-transform duration-200"
                    :class="open ? 'rotate-180' : ''"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                >
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 translate-y-1"
                @click="open = false"
                class="absolute left-3 top-full z-50 mt-1 w-56 rounded-lg border border-white/10 bg-surface-container-lowest p-1 text-on-surface shadow-xl"
            >
                @if (Route::has('home'))
                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 rounded-md px-2.5 py-2 text-sm text-on-surface transition hover:bg-primary-container/20">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons['link'] !!}</svg>
                        Lihat Situs
                    </a>
                @endif
                @if (Route::has('admin.system.settings.index') && auth()->user()->can('setting-view'))
                    <a href="{{ route('admin.system.settings.index') }}" class="flex items-center gap-2 rounded-md px-2.5 py-2 text-sm text-on-surface transition hover:bg-primary-container/20">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons['settings'] !!}</svg>
                        Pengaturan Website
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-2 py-4 scrollbar-thin scrollbar-thumb-primary-container/50">
        <ul class="flex flex-col gap-1">
            @foreach ($visibleNav as $item)
                @if ($item === 'sep')
                    <li class="my-2 border-t border-primary-container/20"></li>
                @else
                    @php
                        $isActive = request()->routeIs($item['route'].'*');
                        $iconPath = $icons[$item['icon']] ?? $icons['dashboard'];
                    @endphp
                    <li>
                        <a
                            href="{{ route($item['route']) }}"
                            :title="collapsed ? @js($item['label']) : ''"
                            class="group relative flex h-9 items-center rounded-md transition-all duration-200
                                {{ $isActive
                                    ? 'bg-primary-container text-white shadow-sm ring-1 ring-white/10'
                                    : 'text-on-primary/60 hover:bg-white/5 hover:text-white'
                                }}
                                lg:justify-center"
                            :class="collapsed ? 'lg:justify-center' : 'lg:justify-start'"
                        >
                            <span class="flex w-full items-center px-2" :class="collapsed ? 'lg:justify-center' : 'lg:px-2.5'">
                                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    {!! $iconPath !!}
                                </svg>
                                <span
                                    x-show="!collapsed"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0 -translate-x-1"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0 -translate-x-1"
                                    class="ml-2.5 flex-1 truncate text-sm font-medium"
                                >
                                    {{ $item['label'] }}
                                </span>
                                @if ($item['route'] === 'admin.service.messages.index' && $unreadMessages > 0)
                                    <span
                                        x-show="!collapsed"
                                        class="mr-0.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-error px-1.5 text-[10px] font-bold text-on-error ring-1 ring-error/50"
                                    >
                                        {{ $unreadMessages }}
                                    </span>
                                @endif
                            </span>
                            @if ($item['route'] === 'admin.service.messages.index' && $unreadMessages > 0)
                                <span
                                    x-show="collapsed"
                                    x-transition:enter="transition ease-out duration-150"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-100"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="absolute right-1.5 top-1 flex h-3.5 min-w-[14px] items-center justify-center rounded-full bg-error px-1 text-[9px] font-bold text-on-error lg:hidden"
                                    :class="collapsed ? 'lg:flex' : 'lg:hidden'"
                                >
                                    {{ $unreadMessages }}
                                </span>
                            @endif
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </nav>

    <!-- User Profile Footer -->
    <div class="shrink-0 border-t border-primary-container/30 p-2">
        <a
            href="{{ route('admin.profile.show') }}"
            :title="collapsed ? 'Pengaturan' : ''"
            class="flex h-9 items-center rounded-md text-on-primary/60 transition hover:bg-white/5 hover:text-white lg:justify-center"
            :class="collapsed ? 'lg:justify-center' : 'lg:justify-start'"
        >
            <span class="flex w-full items-center px-2" :class="collapsed ? 'lg:justify-center' : 'lg:px-2.5'">
                <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons['settings'] !!}</svg>
                <span
                    x-show="!collapsed"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-x-1"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0 -translate-x-1"
                    class="ml-2.5 flex-1 truncate text-sm font-medium"
                >Pengaturan</span>
            </span>
        </a>

        <div x-data="{ open: false }" @click.outside="open = false" class="relative mt-1">
            <button
                @click="open = !open"
                :title="collapsed ? 'Akun' : ''"
                class="flex h-10 w-full items-center rounded-md transition hover:bg-white/5 lg:justify-center"
                :class="collapsed ? 'lg:justify-center' : 'lg:justify-start'"
            >
                <span class="flex w-full items-center px-2" :class="collapsed ? 'lg:justify-center' : 'lg:px-2.5'">
                    <span class="relative shrink-0">
                        <span class="flex h-7 w-7 items-center justify-center overflow-hidden rounded-lg bg-primary-container text-xs font-bold text-on-primary-container ring-1 ring-white/10">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                            @else
                                {{ mb_substr($user->name, 0, 1) }}
                            @endif
                        </span>
                    </span>
                    <span x-show="!collapsed" class="ml-2.5 min-w-0 flex-1 text-left">
                        <span class="block truncate text-xs font-semibold leading-tight">{{ $user->name }}</span>
                        <span class="block truncate text-[10px] font-medium uppercase tracking-wider text-on-primary-container/60">{{ $roles }}</span>
                    </span>
                    <svg
                        x-show="!collapsed"
                        class="h-3.5 w-3.5 shrink-0 text-on-primary-container/50 transition-transform duration-200"
                        :class="open ? 'rotate-180' : ''"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    >
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </span>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0 translate-y-1"
                @click="open = false"
                class="absolute bottom-full left-2 z-50 mb-2 w-56 rounded-lg border border-white/10 bg-surface-container-lowest p-1 text-on-surface shadow-xl"
            >
                <div class="flex items-center gap-2.5 px-2.5 py-2">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center overflow-hidden rounded-lg bg-primary-container text-sm font-bold text-on-primary-container">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            {{ mb_substr($user->name, 0, 1) }}
                        @endif
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-on-surface">{{ $user->name }}</p>
                        <p class="truncate text-xs text-on-surface-variant">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="my-1 border-t border-primary-container/20"></div>
                <a href="{{ route('admin.profile.show') }}" class="flex items-center gap-2 rounded-md px-2.5 py-2 text-sm text-on-surface transition hover:bg-primary-container/20">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons['user'] !!}</svg>
                    Profil
                </a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-md px-2.5 py-2 text-sm text-error transition hover:bg-error-container/50">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons['logout'] !!}</svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
