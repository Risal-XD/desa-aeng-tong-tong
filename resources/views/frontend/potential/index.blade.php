@extends('frontend.layouts.app')

@section('title', 'Potensi Desa')
@section('meta_description', 'Potensi unggulan Desa Aeng Tong-Tong di bidang kerajinan, wisata, dan ekonomi kreatif.')

@section('content')
    <x-frontend.page-hero
        title="Potensi Desa"
        subtitle="Kekayaan alam, budaya, dan ekonomi Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($potentials->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($potentials as $potential)
                    <article class="group rounded-2xl border border-ink-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        @if ($potential->icon)
                            <span class="text-3xl">{{ $potential->icon }}</span>
                        @else
                            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-100 font-display text-lg font-semibold text-brand-700">
                                {{ mb_substr($potential->title, 0, 1) }}
                            </span>
                        @endif
                        <div class="mt-4 flex items-center gap-2">
                            <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $potential->category }}</p>
                            @if ($potential->is_featured)
                                <span class="rounded-full bg-brand-500 px-2 py-0.5 text-[10px] font-semibold text-white">Unggulan</span>
                            @endif
                        </div>
                        <h2 class="mt-1 font-display text-lg font-semibold text-ink-900">{{ $potential->title }}</h2>
                        <div class="mt-3 text-sm leading-relaxed text-ink-500">
                            {!! Str::limit(strip_tags((string) $potential->description), 180) !!}
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Data potensi desa belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection
