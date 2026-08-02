@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-ink-950">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(212,138,30,0.35),transparent_55%),radial-gradient(ellipse_at_bottom_right,rgba(120,62,25,0.4),transparent_60%)]"></div>
        <div class="relative mx-auto grid max-w-6xl items-center gap-10 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:py-24">
            <div>
                <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-brand-500/40 bg-brand-500/10 px-3 py-1 text-xs font-semibold text-brand-300">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    Juara 1 ADWI 2022 · Rekor MURI
                </p>
                <h1 class="font-display text-4xl font-semibold leading-tight text-white sm:text-5xl">
                    Selamat Datang di<br>
                    <span class="text-brand-400">Desa Aeng Tong-Tong</span>
                </h1>
                <p class="mt-5 max-w-xl text-sm leading-relaxed text-ink-300 sm:text-base">
                    Desa wisata sentra kerajinan keris di Kecamatan Saronggi, Kabupaten Sumenep, Jawa Timur.
                    Menjaga warisan budaya para Mpu sekaligus membangun kesejahteraan masyarakat.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('about.sejarah') }}" class="rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-600">
                        Jelajahi Desa
                    </a>
                    <a href="{{ route('potensi') }}" class="rounded-xl border border-ink-600 px-6 py-3 text-sm font-semibold text-ink-200 transition hover:border-ink-400 hover:text-white">
                        Lihat Potensi
                    </a>
                </div>
            </div>

            <div class="hidden lg:block">
                <div class="relative mx-auto max-w-sm">
                    <div class="absolute -inset-4 rounded-3xl bg-brand-500/10 blur-2xl"></div>
                    <div class="relative rounded-3xl border border-ink-700 bg-ink-900/70 p-8 shadow-2xl backdrop-blur">
                        @if ($village)
                            <p class="font-display text-xl font-semibold text-white">{{ $village->name }}</p>
                            <p class="mt-1 text-xs text-ink-400">Kode Desa {{ $village->code }}</p>
                            <dl class="mt-6 grid grid-cols-2 gap-4">
                                <div class="rounded-xl bg-ink-950/60 p-4">
                                    <dt class="text-xs text-ink-400">Luas Wilayah</dt>
                                    <dd class="mt-1 text-lg font-semibold text-brand-400">{{ number_format((float) $village->area, 2, ',', '.') }} km²</dd>
                                </div>
                                <div class="rounded-xl bg-ink-950/60 p-4">
                                    <dt class="text-xs text-ink-400">Dusun</dt>
                                    <dd class="mt-1 text-lg font-semibold text-brand-400">{{ $village->total_hamlet }}</dd>
                                </div>
                                <div class="rounded-xl bg-ink-950/60 p-4">
                                    <dt class="text-xs text-ink-400">Potensi Unggulan</dt>
                                    <dd class="mt-1 text-lg font-semibold text-brand-400">{{ $featuredPotentials->count() }}</dd>
                                </div>
                                <div class="rounded-xl bg-ink-950/60 p-4">
                                    <dt class="text-xs text-ink-400">Berdiri Sejak</dt>
                                    <dd class="mt-1 text-lg font-semibold text-brand-400">{{ $village->history?->founded_year ?? '-' }}</dd>
                                </div>
                            </dl>
                        @else
                            <p class="text-sm text-ink-300">Data desa belum tersedia.</p>
                        @endif
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
        ])->values()))" class="relative overflow-hidden bg-ink-950">
            <template x-for="(banner, index) in banners" :key="index">
                <div x-show="index === current" x-cloak x-transition.opacity class="absolute inset-0">
                    <img x-show="banner.image" :src="banner.image" :alt="banner.title" x-cloak class="h-full w-full object-cover opacity-40">
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(120,62,25,0.5),transparent_70%)]"></div>
                </div>
            </template>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_left,rgba(212,138,30,0.35),transparent_55%)]"></div>

            <div class="relative mx-auto max-w-6xl px-4 py-16 text-center sm:px-6 sm:py-20">
                <template x-for="(banner, index) in banners" :key="index">
                    <div x-show="index === current" x-cloak x-transition.opacity>
                        <p class="mx-auto mb-4 inline-flex items-center gap-2 rounded-full border border-brand-500/40 bg-brand-500/10 px-3 py-1 text-xs font-semibold text-brand-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                            <span x-text="(current + 1) + ' / ' + banners.length"></span>
                        </p>
                        <h2 class="font-display text-3xl font-semibold text-white sm:text-4xl" x-text="banner.title"></h2>
                        <p x-show="banner.description" x-cloak class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-ink-300 sm:text-base" x-text="banner.description"></p>
                        <a x-show="banner.link" :href="banner.link" x-cloak class="mt-8 inline-block rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </template>

                <div x-show="banners.length > 1" x-cloak class="mt-8 flex items-center justify-center gap-3">
                    <button type="button" @click="prev" class="flex h-10 w-10 items-center justify-center rounded-full border border-ink-600 text-ink-300 transition hover:border-brand-500 hover:text-white" aria-label="Sebelumnya">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                    <button type="button" @click="next" class="flex h-10 w-10 items-center justify-center rounded-full border border-ink-600 text-ink-300 transition hover:border-brand-500 hover:text-white" aria-label="Berikutnya">
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
                <div>
                    <x-frontend.section-heading
                        eyebrow="Tentang Desa"
                        title="Aeng Tong-Tong dalam Sekilas"
                    />
                    <div class="prose prose-ink max-w-none text-sm leading-relaxed text-ink-600">
                        {!! $village->profile->overview !!}
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="{{ route('about.sejarah') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                            Baca Sejarah Desa
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-ink-900">Wilayah Pesisir Madura</h3>
                        <p class="mt-2 text-sm text-ink-500">Terletak di Kecamatan Saronggi dengan bentang alam khas pesisir Madura.</p>
                    </div>
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 7.65l1.06 1.06L12 21.23l7.36-7.36 1.06-1.06a5.4 5.4 0 0 0 0-7.65Z"/></svg>
                        </span>
                        <h3 class="mt-4 font-semibold text-ink-900">Sentra Keris</h3>
                        <p class="mt-2 text-sm text-ink-500">Puluhan Mpu menurunkan keahlian membuat keris dari generasi ke generasi.</p>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Potensi Unggulan --}}
    @if ($featuredPotentials->isNotEmpty())
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <x-frontend.section-heading
                    eyebrow="Potensi Desa"
                    title="Potensi Unggulan"
                    subtitle="Berbagai potensi unggulan yang menjadikan Desa Aeng Tong-Tong dikenal hingga nasional."
                    align="center"
                />

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($featuredPotentials as $potential)
                        <article class="group rounded-2xl border border-ink-200 bg-ink-50 p-6 transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                            @if ($potential->icon)
                                <span class="text-3xl">{{ $potential->icon }}</span>
                            @else
                                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-100 font-display text-lg font-semibold text-brand-700">
                                    {{ mb_substr($potential->title, 0, 1) }}
                                </span>
                            @endif
                            <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $potential->category }}</p>
                            <h3 class="mt-1 font-display text-lg font-semibold text-ink-900">{{ $potential->title }}</h3>
                            <div class="mt-2 line-clamp-3 text-sm leading-relaxed text-ink-500">
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
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-frontend.section-heading
                        eyebrow="Kabar Desa"
                        title="Berita Terbaru"
                    />
                    <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                        Semua Berita
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($latestNews as $item)
                        <a href="{{ route('news.show', $item) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200 bg-ink-50 transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                            <div class="relative flex h-40 items-center justify-center overflow-hidden bg-brand-100">
                                @if ($item->cover_image)
                                    <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                @else
                                    <span class="font-display text-3xl font-semibold text-brand-600">{{ mb_substr($item->title, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <p class="text-xs text-ink-400">{{ $item->published_at?->translatedFormat('d M Y') }}</p>
                                <h3 class="mt-2 font-display text-base font-semibold leading-snug text-ink-900 group-hover:text-brand-600">{{ $item->title }}</h3>
                                @if ($item->excerpt)
                                    <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500">{{ $item->excerpt }}</p>
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
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-frontend.section-heading
                    eyebrow="Agenda"
                    title="Kegiatan Mendatang"
                />
                <a href="{{ route('agendas.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                    Semua Agenda
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($upcomingAgendas as $item)
                    <div class="flex gap-4 rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                        <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-50 text-center">
                            <span class="font-display text-2xl font-semibold leading-none text-brand-700">{{ $item->event_date->format('d') }}</span>
                            <span class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-brand-600">{{ $item->event_date->translatedFormat('M Y') }}</span>
                        </div>
                        <div class="min-w-0">
                            @if ($item->is_featured)
                                <span class="rounded-full bg-brand-500 px-2 py-0.5 text-[10px] font-semibold text-white">Unggulan</span>
                            @endif
                            <h3 class="mt-1 font-display text-base font-semibold text-ink-900">{{ $item->title }}</h3>
                            <p class="mt-1 text-xs text-ink-500">{{ $item->location ?? 'Lokasi belum diisi' }}</p>
                            <p class="mt-0.5 text-xs text-ink-500">
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
                <div class="lg:col-span-2">
                    <x-frontend.section-heading
                        eyebrow="Arah Pembangunan"
                        title="Visi &amp; Misi"
                    />
                    <a href="{{ route('about.visi-misi') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                        Selengkapnya
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="space-y-4 lg:col-span-3">
                    @if ($village->visions->isNotEmpty())
                        <div class="rounded-2xl border border-brand-200 bg-brand-50 p-6">
                            <p class="text-xs font-semibold uppercase tracking-widest text-brand-700">Visi</p>
                            <p class="mt-2 font-display text-lg font-medium text-ink-900">{{ $village->visions->first()->vision }}</p>
                        </div>
                    @endif
                    @if ($village->missions->isNotEmpty())
                        <ol class="space-y-3">
                            @foreach ($village->missions as $index => $mission)
                                <li class="flex gap-3 rounded-xl border border-ink-200 bg-white p-4">
                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-ink-950 text-xs font-semibold text-white">{{ $index + 1 }}</span>
                                    <p class="text-sm text-ink-600">{{ $mission->mission }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-ink-950 py-16">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6">
            <h2 class="font-display text-2xl font-semibold text-white sm:text-3xl">Ingin mengenal lebih dekat?</h2>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-ink-400">
                Kunjungi halaman struktur organisasi untuk mengenal perangkat desa, atau hubungi kami melalui halaman kontak.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('about.struktur') }}" class="rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">Struktur Organisasi</a>
                <a href="{{ route('kontak') }}" class="rounded-xl border border-ink-600 px-6 py-3 text-sm font-semibold text-ink-200 transition hover:border-ink-400 hover:text-white">Hubungi Kami</a>
            </div>
        </div>
    </section>
@endsection
