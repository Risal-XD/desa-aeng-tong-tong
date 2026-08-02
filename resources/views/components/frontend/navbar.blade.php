@props(['village' => null])

<header class="sticky top-0 z-40 border-b border-ink-200/70 bg-white/90 backdrop-blur">
    <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500 font-display text-lg font-semibold text-white shadow-sm">
                AT
            </span>
            <span class="leading-tight">
                <span class="block font-display text-base font-semibold text-ink-900">Desa Aeng Tong-Tong</span>
                <span class="block text-xs text-ink-500">Kec. Saronggi · Sumenep</span>
            </span>
        </a>

        <div class="hidden items-center gap-1 lg:flex" x-data="{ aboutOpen: false }">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                Beranda
            </a>

            <div class="relative" @mouseenter="aboutOpen = true" @mouseleave="aboutOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('about.*') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                    Tentang
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="aboutOpen" x-transition x-cloak class="absolute left-0 top-full w-64 rounded-xl border border-ink-200 bg-white p-2 shadow-lg">
                    <a href="{{ route('about.sejarah') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Sejarah Desa</a>
                    <a href="{{ route('about.visi-misi') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Visi &amp; Misi</a>
                    <a href="{{ route('about.struktur') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Struktur Organisasi</a>
                    <a href="{{ route('about.perangkat') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Perangkat Desa</a>
                </div>
            </div>

            <a href="{{ route('potensi') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('potensi') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                Potensi
            </a>

            <div class="relative" x-data="{ infoOpen: false }" @mouseenter="infoOpen = true" @mouseleave="infoOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('news.*', 'announcements.*', 'agendas.*', 'galleries.*', 'videos.*') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                    Informasi
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="infoOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-ink-200 bg-white p-2 shadow-lg">
                    <a href="{{ route('news.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Berita</a>
                    <a href="{{ route('announcements.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Pengumuman</a>
                    <a href="{{ route('agendas.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Agenda</a>
                    <a href="{{ route('galleries.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Galeri Foto</a>
                    <a href="{{ route('videos.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Video</a>
                </div>
            </div>

            <div class="relative" x-data="{ economyOpen: false }" @mouseenter="economyOpen = true" @mouseleave="economyOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('tourism.*', 'keris.*', 'umkms.*') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                    Ekonomi
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="economyOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-ink-200 bg-white p-2 shadow-lg">
                    <a href="{{ route('tourism.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Wisata</a>
                    <a href="{{ route('keris.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Kerajinan Keris &amp; Mpu</a>
                    <a href="{{ route('umkms.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">UMKM</a>
                </div>
            </div>

            <div class="relative" x-data="{ dataOpen: false }" @mouseenter="dataOpen = true" @mouseleave="dataOpen = false">
                <button type="button" class="flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('statistics.*', 'apbdes.*', 'documents.*') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                    Data
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div x-show="dataOpen" x-transition x-cloak class="absolute left-0 top-full w-56 rounded-xl border border-ink-200 bg-white p-2 shadow-lg">
                    <a href="{{ route('statistics.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Statistik Desa</a>
                    <a href="{{ route('apbdes.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">APBDes</a>
                    <a href="{{ route('documents.index') }}" class="block rounded-lg px-3 py-2 text-sm text-ink-600 transition hover:bg-brand-50 hover:text-brand-700">Download Dokumen</a>
                </div>
            </div>

            <a href="{{ route('kontak') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('kontak') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                Kontak
            </a>

            <a href="{{ route('faq') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('faq') ? 'text-brand-600' : 'text-ink-600 hover:text-ink-900' }}">
                FAQ
            </a>
        </div>

        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="hidden rounded-lg bg-ink-950 px-4 py-2 text-sm font-semibold text-white transition hover:bg-ink-800 sm:inline-flex">
                    Panel Admin
                </a>
            @else
                <a href="{{ route('admin.login') }}" class="hidden rounded-lg border border-ink-300 px-4 py-2 text-sm font-semibold text-ink-700 transition hover:bg-ink-100 sm:inline-flex">
                    Login Admin
                </a>
            @endauth

            <button
                type="button"
                @click="$store.mobileNav.toggle()"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-ink-200 text-ink-600 transition hover:bg-ink-100 lg:hidden"
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
            <div x-data="{ open: request()->routeIs('about.*') }">
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
            <div x-data="{ open: request()->routeIs('news.*', 'announcements.*', 'agendas.*', 'galleries.*', 'videos.*') }">
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
            <div x-data="{ open: request()->routeIs('tourism.*', 'keris.*', 'umkms.*') }">
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
            <div x-data="{ open: request()->routeIs('statistics.*', 'apbdes.*', 'documents.*') }">
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
            <a href="{{ route('kontak') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">Kontak</a>
            <a href="{{ route('faq') }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium text-ink-700 transition hover:bg-brand-50 hover:text-brand-700">FAQ</a>

            @auth
                <a href="{{ route('admin.dashboard') }}" class="mt-2 block rounded-lg bg-ink-950 px-4 py-2.5 text-center text-sm font-semibold text-white">Panel Admin</a>
            @else
                <a href="{{ route('admin.login') }}" class="mt-2 block rounded-lg border border-ink-300 px-4 py-2.5 text-center text-sm font-semibold text-ink-700">Login Admin</a>
            @endauth
        </div>
    </div>
</header>
