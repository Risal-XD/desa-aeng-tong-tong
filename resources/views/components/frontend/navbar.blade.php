@props(['village' => null])

<header class="sticky top-0 z-40 border-b border-outline-variant/30 bg-surface/95 backdrop-blur shadow-sm">
    <nav class="mx-auto flex h-24 max-w-6xl items-center justify-between gap-6 px-4 sm:px-6" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="group flex items-center gap-3">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo KKN Desa Aeng Tong-Tong" class="h-20 w-20 object-contain transition group-hover:scale-105">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo Kedua" class="h-20 w-20 object-contain transition group-hover:scale-105">
        </a>

        <div class="hidden items-center gap-1 lg:flex" x-data="{ aboutOpen: false }">
            <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                Beranda
            </a>

            <div class="relative" @mouseenter="aboutOpen = true" @mouseleave="aboutOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('about.*') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Tentang
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="aboutOpen" x-transition x-cloak class="absolute left-0 top-full w-64 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-2 shadow-xl">
                    <a href="{{ route('about.sejarah') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Sejarah Desa</a>
                    <a href="{{ route('about.visi-misi') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Visi &amp; Misi</a>
                    <a href="{{ route('about.struktur') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Struktur Organisasi</a>
                    <a href="{{ route('about.perangkat') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Perangkat Desa</a>
                </div>
            </div>

            <a href="{{ route('potensi') }}" class="rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('potensi') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                Potensi
            </a>

            <div class="relative" x-data="{ infoOpen: false }" @mouseenter="infoOpen = true" @mouseleave="infoOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('news.*', 'announcements.*', 'agendas.*', 'galleries.*', 'videos.*') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Informasi
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="infoOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-2 shadow-xl">
                    <a href="{{ route('news.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Berita</a>
                    <a href="{{ route('announcements.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Pengumuman</a>
                    <a href="{{ route('agendas.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Agenda</a>
                    <a href="{{ route('galleries.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Galeri Foto</a>
                    <a href="{{ route('videos.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Video</a>
                </div>
            </div>

            <div class="relative" x-data="{ economyOpen: false }" @mouseenter="economyOpen = true" @mouseleave="economyOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('tourism.*', 'keris.*', 'umkms.*') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Ekonomi
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="economyOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-2 shadow-xl">
                    <a href="{{ route('tourism.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Wisata</a>
                    <a href="{{ route('keris.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Kerajinan Keris &amp; Mpu</a>
                    <a href="{{ route('umkms.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">UMKM</a>
                </div>
            </div>

            <div class="relative" x-data="{ dataOpen: false }" @mouseenter="dataOpen = true" @mouseleave="dataOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-md px-3 py-2 text-sm font-medium transition {{ request()->routeIs('statistics.*', 'apbdes.*', 'documents.*') ? 'text-primary font-semibold' : 'text-on-surface-variant hover:text-on-surface' }}">
                    Data
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="dataOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-outline-variant/30 bg-surface-container-lowest p-2 shadow-xl">
                    <a href="{{ route('statistics.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Statistik Desa</a>
                    <a href="{{ route('apbdes.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">APBDes</a>
                    <a href="{{ route('documents.index') }}" class="block rounded-lg px-3 py-2 text-sm text-on-surface-variant transition hover:bg-surface-container-low hover:text-primary">Download Dokumen</a>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="hidden rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-on-primary transition hover:bg-primary-container sm:inline-flex">
                    Panel Admin
                </a>
            @else
                <a href="{{ route('admin.login') }}" class="hidden rounded-lg border border-outline-variant px-4 py-2 text-sm font-semibold text-on-surface transition hover:bg-surface-container sm:inline-flex">
                    Login Admin
                </a>
            @endauth

            <button
                type="button"
                @click="$store.mobileNav.toggle()"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-outline-variant text-on-surface-variant transition hover:bg-surface-container lg:hidden"
                aria-label="Buka menu"
            >
                <svg x-show="!$store.mobileNav.open" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="12" x2="20" y2="12"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
                <svg x-show="$store.mobileNav.open" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
    </nav>

    <div x-show="$store.mobileNav.open" x-cloak x-transition class="border-t border-ink-200 bg-white lg:hidden">
        <div class="space-y-1 px-4 py-4">
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">Beranda</a>
            <div x-data="{ open: @js(request()->routeIs('about.*')) }">
                <button type="button" @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">
                    Tentang
                    <svg class="h-4 w-4" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-cloak class="space-y-1 border-l-2 border-brand-200 pl-3">
                    <a href="{{ route('about.sejarah') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Sejarah Desa</a>
                    <a href="{{ route('about.visi-misi') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Visi &amp; Misi</a>
                    <a href="{{ route('about.struktur') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Struktur Organisasi</a>
                    <a href="{{ route('about.perangkat') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Perangkat Desa</a>
                </div>
            </div>
            <a href="{{ route('potensi') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">Potensi</a>
            <div x-data="{ open: @js(request()->routeIs('news.*', 'announcements.*', 'agendas.*', 'galleries.*', 'videos.*')) }">
                <button type="button" @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">
                    Informasi
                    <svg class="h-4 w-4" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-cloak class="space-y-1 border-l-2 border-brand-200 pl-3">
                    <a href="{{ route('news.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Berita</a>
                    <a href="{{ route('announcements.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Pengumuman</a>
                    <a href="{{ route('agendas.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Agenda</a>
                    <a href="{{ route('galleries.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Galeri Foto</a>
                    <a href="{{ route('videos.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Video</a>
                </div>
            </div>
            <div x-data="{ open: @js(request()->routeIs('tourism.*', 'keris.*', 'umkms.*')) }">
                <button type="button" @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">
                    Ekonomi
                    <svg class="h-4 w-4" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-cloak class="space-y-1 border-l-2 border-brand-200 pl-3">
                    <a href="{{ route('tourism.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Wisata</a>
                    <a href="{{ route('keris.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Kerajinan Keris &amp; Mpu</a>
                    <a href="{{ route('umkms.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">UMKM</a>
                </div>
            </div>
            <div x-data="{ open: @js(request()->routeIs('statistics.*', 'apbdes.*', 'documents.*')) }">
                <button type="button" @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">
                    Data
                    <svg class="h-4 w-4" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="open" x-cloak class="space-y-1 border-l-2 border-brand-200 pl-3">
                    <a href="{{ route('statistics.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Statistik Desa</a>
                    <a href="{{ route('apbdes.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">APBDes</a>
                    <a href="{{ route('documents.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 hover:text-brand-700">Download Dokumen</a>
                </div>
            </div>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="mt-2 block rounded-lg bg-ink-950 px-4 py-2.5 text-center text-sm font-semibold text-white">Panel Admin</a>
            @else
                <a href="{{ route('admin.login') }}" class="mt-2 block rounded-lg border border-ink-300 px-4 py-2.5 text-center text-sm font-semibold text-ink-700">Login Admin</a>
            @endauth
        </div>
    </div>
</header>
