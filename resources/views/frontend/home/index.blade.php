@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-primary text-on-primary">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(59,130,246,0.1),transparent_55%),radial-gradient(ellipse_at_bottom_right,rgba(16,185,129,0.1),transparent_60%)]"></div>
        <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-primary-container bg-primary-container/20 px-3 py-1 text-xs font-semibold text-inverse-primary">
                    <span class="h-1.5 w-1.5 rounded-full bg-secondary"></span>
                    Juara 1 ADWI 2022 · Rekor MURI
                </p>
                <div class="min-h-[7.5rem] sm:min-h-[10rem]" data-parallax-speed="30">
                    <h1 x-data="typewriter('Selamat Datang di\nDesa Aeng Tong-Tong', 100, 0)" class="font-display text-4xl font-semibold leading-tight text-white sm:text-5xl whitespace-pre-line" x-text="displayText"></h1>
                </div>
                <div class="min-h-[6rem]" data-parallax-speed="50">
                    <p x-data="typewriter('Desa wisata sentra kerajinan keris di Kecamatan Saronggi, Kabupaten Sumenep, Jawa Timur. Menjaga warisan budaya para Mpu sekaligus membangun kesejahteraan masyarakat.', 60, 2800)" class="mt-5 max-w-xl text-sm leading-relaxed text-on-primary-container sm:text-base text-justify" x-text="displayText"></p>
                </div>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('about.sejarah') }}" class="rounded-lg bg-secondary px-6 py-3 text-sm font-semibold text-on-secondary shadow-sm transition hover:bg-secondary-container hover:text-on-secondary-container">
                        Jelajahi Desa
                    </a>
                    <a href="{{ route('potensi') }}" class="rounded-lg border border-outline px-6 py-3 text-sm font-semibold text-white transition hover:bg-on-primary/10">
                        Lihat Potensi
                    </a>
                </div>
            </div>

            <div class="hidden lg:block" data-parallax-speed="-40">
                <div x-data="fadeSlider(@js($heroPhotos->map(fn ($photo) => [
                    'title' => $photo->title,
                    'image' => $photo->image ? asset('storage/'.$photo->image) : null,
                ])->values()))" class="relative mx-auto max-w-sm">
                    <div class="absolute -inset-4 rounded-3xl bg-surface-container-high blur-2xl"></div>
                    <div class="relative aspect-[4/3] overflow-hidden rounded-3xl border border-outline-variant bg-surface-container-low shadow-xl">
                        <template x-for="(photo, index) in photos" :key="index">
                            <div
                                x-show="index === current"
                                x-cloak
                                x-transition:enter="transition-opacity duration-1000 ease-out"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition-opacity duration-1000 ease-in"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"
                                class="absolute inset-0"
                            >
                                <img x-show="photo.image" :src="photo.image" :alt="photo.title" x-cloak class="h-full w-full object-cover">
                                <div x-show="!photo.image" x-cloak class="flex h-full w-full items-center justify-center bg-gradient-to-br from-primary to-secondary">
                                    <span class="font-display text-6xl font-semibold text-on-primary/90" x-text="photo.title.charAt(0)"></span>
                                </div>
                            </div>
                        </template>

                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-ink-950/80 to-transparent p-5">
                            <p class="text-[11px] font-semibold uppercase tracking-widest text-brand-300">
                                Galeri Desa · <span x-text="(current + 1) + ' / ' + photos.length"></span>
                            </p>
                            <h3 class="mt-1 font-display text-lg font-semibold text-white" x-text="photos[current].title"></h3>
                        </div>

                        <div x-show="photos.length > 1" x-cloak class="absolute bottom-4 right-4 flex gap-1.5">
                            <template x-for="(photo, index) in photos" :key="'dot-'+index">
                                <button
                                    type="button"
                                    @click="go(index)"
                                    :class="index === current ? 'bg-white' : 'bg-white/40'"
                                    class="h-1.5 w-1.5 rounded-full transition"
                                    :aria-label="'Ke foto ' + (index + 1)"
                                ></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Banner Slider --}}
    @if ($banners->isNotEmpty())
        <section x-data="bannerSlider(@js($banners->map(fn ($banner) => [
            'title' => $banner->title,
            'description' => $banner->description,
            'image' => $banner->image ? asset('storage/'.$banner->image) : null,
            'link' => $banner->link,
            'first' => mb_substr($banner->title, 0, 1),
        ])->values()))" class="relative overflow-hidden bg-tertiary text-on-tertiary">
            <template x-for="(banner, index) in banners" :key="index">
                <div x-show="index === current" x-cloak x-transition.opacity class="absolute inset-0">
                    <img x-show="banner.image" :src="banner.image" :alt="banner.title" x-cloak class="h-full w-full object-cover opacity-30">
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(0,0,0,0.4),transparent_70%)]"></div>
                </div>
            </template>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(255,255,255,0.1),transparent_55%)]"></div>

            <div class="relative mx-auto max-w-6xl px-4 py-16 text-center sm:px-6 sm:py-20">
                <template x-for="(banner, index) in banners" :key="index">
                    <div x-show="index === current" x-cloak x-transition.opacity>
                        <p class="mx-auto mb-4 inline-flex items-center gap-2 rounded-full border border-outline-variant px-3 py-1 text-xs font-semibold text-on-tertiary-container">
                            <span class="h-1.5 w-1.5 rounded-full bg-secondary"></span>
                            <span x-text="(current + 1) + ' / ' + banners.length"></span>
                        </p>
                        <h2 class="font-display text-3xl font-semibold text-white sm:text-4xl" x-text="banner.title"></h2>
                        <p x-show="banner.description" x-cloak class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-on-tertiary-container sm:text-base" x-text="banner.description"></p>
                        <a x-show="banner.link" :href="banner.link" x-cloak class="mt-8 inline-block rounded-lg bg-secondary px-6 py-3 text-sm font-semibold text-on-secondary transition hover:bg-secondary-container hover:text-on-secondary-container">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </template>

                <div x-show="banners.length > 1" x-cloak class="mt-8 flex items-center justify-center gap-3">
                    <button type="button" @click="prev" class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant text-on-tertiary transition hover:border-secondary hover:text-white" aria-label="Sebelumnya">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" @click="next" class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant text-on-tertiary transition hover:border-secondary hover:text-white" aria-label="Berikutnya">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
            </div>
        </section>
    @endif

    {{-- Gambaran Umum --}}
    @if ($village?->profile?->overview)
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div data-parallax-speed="35">
                    <x-frontend.section-heading
                        eyebrow="Tentang Desa"
                        title="Aeng Tong-Tong dalam Sekilas"
                    />
                    <div class="prose prose-on-surface max-w-none text-sm leading-relaxed text-on-surface-variant">
                        {!! $village->profile->overview !!}
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('about.sejarah') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-primary-container">
                            Baca Sejarah Desa
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2" data-parallax-speed="-35">
                    <div class="rounded-2xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-sm">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-container text-primary">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-on-surface">Wilayah Pesisir Madura</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">Terletak di Kecamatan Saronggi dengan bentang alam khas pesisir Madura.</p>
                    </div>
                    <div class="rounded-2xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-sm">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-surface-container text-primary">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 7.65l1.06 1.06L12 21.23l7.36-7.36 1.06-1.06a5.4 5.4 0 0 0 0-7.65Z"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-on-surface">Sentra Keris</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">Puluhan Mpu menurunkan keahlian membuat keris dari generasi ke generasi.</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Dual-Row Pinterest Marquee Gallery (Natural Aspect Ratio) --}}
    @if ($heroPhotos->isNotEmpty())
        <section class="relative overflow-hidden bg-surface py-20 sm:py-24" data-parallax-speed="25">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <x-frontend.section-heading
                    eyebrow="Galeri Desa"
                    title="Galeri Aeng Tong-Tong"
                    subtitle="Dokumentasi foto keindahan desa dengan orientasi asli (lanskap dan potret) yang mengalir halus."
                    align="center"
                />
            </div>

            <div
                class="mx-auto mt-12 max-w-7xl px-2 sm:px-4"
                x-data="pinterestMarquee(@js($heroPhotos->map(fn ($p) => ['title' => $p->title, 'image' => $p->image])->values()))"
            >
                <div class="marquee-row-viewport space-y-4">
                    {{-- Row 1: Bergerak ke kanan --}}
                    <div class="marquee-row-track marquee-row-1">
                        <template x-for="(it, i) in row1" :key="'r1-'+i">
                            <div class="marquee-img-card" @click="openItem(it)">
                                <img :src="it.src" :alt="it.alt" class="pointer-events-none select-none" draggable="false">
                            </div>
                        </template>
                    </div>

                    {{-- Row 2: Bergerak ke kiri --}}
                    <div class="marquee-row-track marquee-row-2">
                        <template x-for="(it, i) in row2" :key="'r2-'+i">
                            <div class="marquee-img-card" @click="openItem(it)">
                                <img :src="it.src" :alt="it.alt" class="pointer-events-none select-none" draggable="false">
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Modal perbesar foto --}}
                <template x-if="enlarged">
                    <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm p-4" x-cloak @click.self="closeItem()">
                        <div class="relative w-full max-w-2xl overflow-hidden rounded-3xl bg-surface p-4 shadow-2xl">
                            <button type="button" class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-black/60 text-xl text-white transition hover:bg-black" @click="closeItem()" aria-label="Tutup">&times;</button>
                            <img :src="enlarged.src" :alt="enlarged.alt" class="w-full max-h-[70vh] rounded-2xl object-cover">
                            <h3 class="mt-4 font-display text-lg font-semibold text-on-surface" x-text="enlarged.alt"></h3>
                        </div>
                    </div>
                </template>
            </div>
        </section>
    @endif

    {{-- Potensi Unggulan --}}
    @if ($featuredPotentials->isNotEmpty())
        <section class="bg-surface-container-low py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div data-parallax-speed="25">
                    <x-frontend.section-heading
                        eyebrow="Potensi Desa"
                        title="Potensi Unggulan"
                        subtitle="Berbagai potensi unggulan yang menjadikan Desa Aeng Tong-Tong dikenal hingga nasional."
                        align="center"
                    />
                </div>

                <div class="grid gap-6 md:grid-cols-3" data-parallax-speed="-25">
                    @foreach ($featuredPotentials as $potential)
                        <article class="group rounded-2xl border border-outline-variant/50 bg-surface p-6 transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                            @if ($potential->icon)
                                <span class="text-3xl">{{ $potential->icon }}</span>
                            @else
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-surface-container font-display text-lg font-semibold text-primary">
                                    {{ mb_substr($potential->title, 0, 1) }}
                                </span>
                            @endif
                            <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-primary">{{ $potential->category }}</p>
                            <h3 class="mt-1 font-display text-lg font-semibold text-on-surface">{{ $potential->title }}</h3>
                            <div class="mt-2 line-clamp-3 text-sm leading-relaxed text-on-surface-variant">
                                {!! Str::limit(strip_tags((string) $potential->description), 140) !!}
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Berita Terbaru --}}
    @if ($latestNews->isNotEmpty())
        <section class="bg-surface py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="flex flex-wrap items-end justify-between gap-4" data-parallax-speed="30">
                    <x-frontend.section-heading
                        eyebrow="Kabar Desa"
                        title="Berita Terbaru"
                    />
                    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-primary-container">
                        Semua Berita
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3" data-parallax-speed="-30">
                    @foreach ($latestNews as $item)
                        <a href="{{ route('news.show', $item) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-outline-variant/50 bg-surface-container-lowest transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                            <div class="relative flex h-40 items-center justify-center overflow-hidden bg-surface-container">
                                @if ($item->cover_image)
                                    <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <span class="font-display text-3xl font-semibold text-primary">{{ mb_substr($item->title, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <p class="text-xs text-on-surface-variant">{{ $item->published_at?->translatedFormat('d M Y') }}</p>
                                <h3 class="mt-2 font-display text-base font-semibold leading-snug text-on-surface group-hover:text-primary">{{ $item->title }}</h3>
                                @if ($item->excerpt)
                                    <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-on-surface-variant">{{ $item->excerpt }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Agenda Mendatang --}}
    @if ($upcomingAgendas->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
            <div class="flex flex-wrap items-end justify-between gap-4" data-parallax-speed="25">
                <x-frontend.section-heading
                    eyebrow="Agenda"
                    title="Kegiatan Mendatang"
                />
                <a href="{{ route('agendas.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-primary-container">
                    Semua Agenda
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3" data-parallax-speed="-25">
                @foreach ($upcomingAgendas as $item)
                    <div class="flex gap-4 rounded-2xl border border-outline-variant/50 bg-surface-container-lowest p-6 shadow-sm">
                        <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-xl bg-surface-container text-center">
                            <span class="font-display text-2xl font-semibold leading-none text-primary">{{ $item->event_date->format('d') }}</span>
                            <span class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-on-surface-variant">{{ $item->event_date->translatedFormat('M Y') }}</span>
                        </div>
                        <div class="min-w-0">
                            @if ($item->is_featured)
                                <span class="rounded-full bg-secondary px-2 py-0.5 text-[10px] font-semibold text-on-secondary">Unggulan</span>
                            @endif
                            <h3 class="mt-1 font-display text-base font-semibold text-on-surface">{{ $item->title }}</h3>
                            <p class="mt-1 text-xs text-on-surface-variant">{{ $item->location ?? 'Lokasi belum diisi' }}</p>
                            <p class="mt-0.5 text-xs text-on-surface-variant">
                                {{ $item->start_time?->format('H:i') }}–{{ $item->end_time?->format('H:i') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Visi & Misi singkat --}}
    @if ($village?->visions->isNotEmpty() || $village?->missions->isNotEmpty())
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 sm:py-20">
            <div class="grid gap-8 lg:grid-cols-5">
                <div class="lg:col-span-2" data-parallax-speed="30">
                    <x-frontend.section-heading
                        eyebrow="Arah Pembangunan"
                        title="Visi &amp; Misi"
                    />
                    <a href="{{ route('about.visi-misi') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-primary transition hover:text-primary-container">
                        Selengkapnya
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="space-y-4 lg:col-span-3" data-parallax-speed="-30">
                    @if ($village->visions->isNotEmpty())
                        <div class="rounded-2xl border border-primary-container bg-surface-container-lowest p-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-primary">Visi</p>
                            <p class="mt-2 font-display text-lg font-medium text-on-surface">{{ $village->visions->first()->vision }}</p>
                        </div>
                    @endif
                    @if ($village->missions->isNotEmpty())
                        <ol class="space-y-3">
                            @foreach ($village->missions as $index => $mission)
                                <li class="flex gap-3 rounded-xl border border-outline-variant/50 bg-surface p-4">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-semibold text-on-primary">{{ $index + 1 }}</span>
                                    <p class="text-sm text-on-surface-variant">{{ $mission->mission }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Transparansi & Data --}}
    <section class="bg-surface-container-low py-16 sm:py-20">
        <div class="mx-auto max-w-6xl px-4 sm:px-6">
            <div data-parallax-speed="25">
                <x-frontend.section-heading
                    eyebrow="Transparansi"
                    title="Data & Laporan Desa"
                    subtitle="Statistik, anggaran, dan dokumen publik yang dapat diakses serta diunduh masyarakat."
                    align="center"
                />
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3" data-parallax-speed="-25">
                <a href="{{ route('statistics.index') }}" class="group rounded-2xl border border-outline-variant/50 bg-surface p-6 transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-surface-container text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                    </span>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-primary">Statistik Desa</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-on-surface">Data &amp; Grafik</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">Statistik kependudukan, pendidikan, dan kesehatan dalam tabel serta grafik.</p>
                </a>

                <a href="{{ route('apbdes.index') }}" class="group rounded-2xl border border-outline-variant/50 bg-surface p-6 transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-surface-container text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                    </span>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-primary">APBDes</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-on-surface">Anggaran Desa</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">Pendapatan, belanja, dan pembiayaan desa secara terbuka.</p>
                </a>

                <a href="{{ route('documents.index') }}" class="group rounded-2xl border border-outline-variant/50 bg-surface p-6 transition hover:-translate-y-1 hover:border-primary hover:shadow-lg">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-surface-container text-primary">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </span>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-primary">Dokumen</p>
                    <h3 class="mt-1 font-display text-lg font-semibold text-on-surface">Unduhan Publik</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">Buku profil, laporan APBDes, dan peraturan desa yang dapat diunduh.</p>
                </a>
            </div>

            @if ($latestStatistics->isNotEmpty())
                <div class="mt-10 grid gap-4 md:grid-cols-3">
                    @foreach ($latestStatistics as $statistic)
                        <div class="rounded-2xl border border-outline-variant/50 bg-surface p-6 shadow-sm">
                            <p class="text-xs font-semibold uppercase tracking-widest text-primary">
                                {{ $statistic->category->label() }} · {{ $statistic->year }}
                            </p>
                            <h4 class="mt-1 font-display text-base font-semibold text-on-surface">{{ $statistic->name }}</h4>
                            @if ($statistic->populationStatistics->isNotEmpty())
                                <dl class="mt-4 grid grid-cols-2 gap-3">
                                    @foreach ($statistic->populationStatistics->take(4) as $row)
                                        <div class="rounded-xl bg-surface-container-low p-3">
                                            <dt class="text-xs text-on-surface-variant">{{ $row->label }}</dt>
                                            <dd class="mt-1 text-sm font-semibold text-on-surface">
                                                {{ number_format((float) $row->value, 0, ',', '.') }}
                                                @if ($row->unit)
                                                    <span class="text-xs font-normal text-on-surface-variant">{{ $row->unit }}</span>
                                                @endif
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-primary py-16 text-on-primary">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">
            <h2 class="font-display text-2xl font-semibold text-white sm:text-3xl">Ingin mengenal lebih dekat?</h2>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-on-primary-container">
                Kunjungi halaman struktur organisasi untuk mengenal perangkat desa, atau hubungi kami melalui halaman kontak.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('about.struktur') }}" class="rounded-lg bg-secondary px-6 py-3 text-sm font-semibold text-on-secondary transition hover:bg-secondary-container hover:text-on-secondary-container">Struktur Organisasi</a>
                <a href="{{ route('kontak') }}" class="rounded-lg border border-outline px-6 py-3 text-sm font-semibold text-white transition hover:bg-on-primary/10">Hubungi Kami</a>
            </div>
        </div>
    </section>
@endsection
