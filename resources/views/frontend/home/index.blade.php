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
