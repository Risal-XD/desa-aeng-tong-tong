@extends('frontend.layouts.app')

@section('title', $statistic->name)
@section('meta_description', $statistic->description ? Str::limit(strip_tags((string) $statistic->description), 160) : 'Data statistik Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="{{ $statistic->category->label() }}"
        subtitle="Data tahun {{ $statistic->year }}"
    />

    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
        {{-- Metadata & Title --}}
        <div class="mb-10">
            <p class="text-xs font-bold uppercase tracking-[0.22em] text-secondary">
                {{ $statistic->category->label() }} - {{ $statistic->year }}
            </p>
            <h1 class="mt-4 font-display text-3xl font-bold text-primary sm:text-4xl">
                {{ $statistic->name }}
            </h1>
            @if ($statistic->description)
                <p class="mt-6 max-w-3xl text-sm leading-relaxed text-on-surface-variant">
                    {!! strip_tags((string) $statistic->description) !!}
                </p>
            @endif
        </div>

        {{-- Top Summary Cards (Horizontal 4 Kolom) --}}
        <div class="mb-10 flex flex-nowrap overflow-x-auto gap-4 pb-2 -mx-4 px-4 sm:grid sm:grid-cols-2 sm:overflow-visible sm:mx-0 sm:px-0 sm:pb-0 lg:grid-cols-4 lg:overflow-visible">
            @foreach ($statistic->populationStatistics->take(4) as $data)
                <div class="flex-shrink-0 w-64 rounded-lg border border-outline-variant/40 bg-white p-3 shadow-sm sm:w-auto sm:flex-1">
                    <div>
                        <p class="text-[10px] font-semibold tracking-wider text-outline">{{ strtoupper($data->label) }}</p>
                        <div class="mt-1 flex items-baseline gap-1">
                            <span class="font-display text-xl font-bold {{ $loop->last ? 'text-[#d48a1e]' : 'text-primary' }}">
                                {{ number_format((float) $data->value, 0, ',', '.') }}
                            </span>
                            <span class="text-[10px] font-normal text-outline">{{ $data->unit ?? '' }}</span>
                        </div>
                    </div>
                    @if ($loop->index >= 2)
                        <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-surface-container">
                            <div class="h-full {{ $loop->last ? 'bg-[#d48a1e]' : 'bg-primary' }}" style="width: 50%"></div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Main Grid --}}
        <div class="grid gap-8 lg:grid-cols-2">
            {{-- Left: Data Table (Table Style persis gambar) --}}
            <div class="rounded-lg border border-ink-100 bg-white shadow-sm overflow-hidden">
                <div class="border-b border-ink-100 bg-surface-container-lowest" style="padding: 1.5rem 1.5rem;">
                    <h3 class="font-display text-lg font-bold text-primary">Data Kependudukan</h3>
                </div>
                <div class="divide-y divide-ink-100">
                    @foreach ($statistic->populationStatistics as $row)
                        <div class="flex items-center justify-between px-6 py-4 hover:bg-ink-50/50 transition">
                            <span class="text-sm font-semibold text-ink-700">{{ $row->label }}</span>
                            <span class="text-sm font-bold text-primary">{{ number_format((float) $row->value, 0, ',', '.') }} <span class="text-xs font-normal text-ink-500">{{ $row->unit }}</span></span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Chart --}}
            <div class="h-[360px] overflow-hidden rounded-lg border border-ink-100 bg-white shadow-sm">
                <div class="border-b border-ink-100 bg-surface-container-lowest px-6 py-4">
                    <h3 class="font-display text-base font-bold text-primary">Grafik Kelompok Usia</h3>
                </div>
                <div class="px-5 pt-3">
                    <div class="h-[235px]">
                        <canvas
                            x-data="chartBar(
                                @js($statistic->populationStatistics->pluck('label')->all()),
                                @js($statistic->populationStatistics->map(fn ($row) => (float) $row->value)->all()),
                                @js('Kelompok Usia')
                            )"
                        ></canvas>
                    </div>
                    <div class="flex items-center justify-center gap-5 pt-2">
                        <span class="flex items-center gap-2 text-[10px] text-ink-600"><i class="h-2 w-2 rounded-sm bg-secondary"></i>Kelompok Usia</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Link --}}
        <div class="mt-12">
            <a href="{{ route('statistics.index') }}" class="inline-flex items-center gap-3 text-xs font-bold text-outline transition hover:text-primary">
                <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m15 19-7-7 7-7"/></svg>
                Kembali ke Statistik Desa
            </a>
        </div>
    </section>
@endsection
