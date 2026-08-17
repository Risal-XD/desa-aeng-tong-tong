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

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        @forelse ($statistics as $statistic)
            <article class="mb-14 last:mb-0 {{ $loop->first ? '' : 'mt-16 border-t border-outline-variant/30 pt-16' }}">
                <div class="mb-10">
                    <p class="text-xs font-bold uppercase tracking-[0.22em] text-secondary">
                        {{ $statistic->category->label() }} - {{ $statistic->year }}
                    </p>
                    <h2 class="mt-4 font-display text-2xl font-bold text-primary sm:text-3xl">{{ $statistic->name }}</h2>
                    @if ($statistic->description)
                        <p class="mt-4 max-w-3xl text-sm leading-relaxed text-on-surface-variant">{!! strip_tags((string) $statistic->description) !!}</p>
                    @endif
                </div>

                <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">
                    @foreach ($statistic->populationStatistics->take(4) as $row)
                        <div class="rounded-lg border border-outline-variant/40 bg-white p-3 shadow-sm">
                            <p class="text-[10px] font-semibold tracking-wider text-outline">{{ strtoupper($row->label) }}</p>
                            <div class="mt-1 flex items-baseline gap-1">
                                <span class="font-display text-xl font-bold {{ $loop->last ? 'text-[#d48a1e]' : 'text-primary' }}">{{ number_format((float) $row->value, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-outline">{{ $row->unit }}</span>
                            </div>
                            @if ($loop->index >= 2)
                                <div class="mt-2 h-1 overflow-hidden rounded-full bg-surface-container"><div class="h-full {{ $loop->last ? 'bg-[#d48a1e]' : 'bg-primary' }}" style="width:50%"></div></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="grid gap-8 lg:grid-cols-2">
                    <div class="overflow-hidden rounded-lg border border-ink-100 bg-white shadow-sm">
                        <div class="border-b border-ink-100 bg-surface-container-lowest" style="padding: 1.5rem 1.5rem;"><h3 class="font-display text-lg font-bold text-primary">Data {{ $statistic->category->label() }}</h3></div>
                        <div class="divide-y divide-ink-100">
                            @foreach ($statistic->populationStatistics as $row)
                                <div class="flex items-center justify-between px-6 py-4 {{ $loop->even ? 'bg-ink-50/50' : '' }}">
                                    <span class="text-sm font-semibold text-ink-700">{{ $row->label }}</span>
                                    <span class="text-sm font-bold text-primary">{{ number_format((float) $row->value, 0, ',', '.') }} <span class="text-xs font-normal text-ink-500">{{ $row->unit }}</span></span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="h-[360px] overflow-hidden rounded-lg border border-ink-100 bg-white shadow-sm">
                        <div class="border-b border-ink-100 bg-surface-container-lowest px-6 py-4"><h3 class="font-display text-base font-bold text-primary">Grafik {{ $statistic->category->label() }}</h3></div>
                        <div class="px-5 pt-3"><div class="h-[235px]"><canvas x-data="chartBar(@js($statistic->populationStatistics->pluck('label')->all()), @js($statistic->populationStatistics->map(fn ($row) => (float) $row->value)->all()), @js($statistic->name))"></canvas></div></div>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-lg border border-ink-100 bg-white p-10 text-center"><p class="text-sm text-ink-500">Belum ada data statistik.</p></div>
        @endforelse
    </section>
@endsection
