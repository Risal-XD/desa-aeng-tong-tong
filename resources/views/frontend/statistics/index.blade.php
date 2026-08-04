@extends('frontend.layouts.app')

@section('title', 'Statistik Desa')
@section('meta_description', 'Data statistik desa Aeng Tong-Tong meliputi kependudukan, pendidikan, kesehatan, ekonomi, dan sosial.')

@section('content')
    <x-frontend.page-hero
        title="Statistik Desa"
        subtitle="Data dan grafik perkembangan Desa Aeng Tong-Tong untuk transparansi dan akuntabilitas publik."
        :image="$heroImage"
        imagePosition="right center"
        backgroundSize="280%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($statistics->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($statistics as $statistic)
                    <a href="{{ route('statistics.show', $statistic) }}" class="group rounded-2xl border border-ink-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">
                            {{ $statistic->category->label() }} · {{ $statistic->year }}
                        </p>
                        <h2 class="mt-2 font-display text-lg font-semibold text-ink-900 group-hover:text-brand-600">
                            {{ $statistic->name }}
                        </h2>
                        @if ($statistic->description)
                            <div class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-500">
                                {!! Str::limit(strip_tags((string) $statistic->description), 120) !!}
                            </div>
                        @endif
                        <p class="mt-4 text-xs font-semibold text-brand-600">Lihat Detail →</p>
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada data statistik.</p>
            </div>
        @endif
    </section>
@endsection
