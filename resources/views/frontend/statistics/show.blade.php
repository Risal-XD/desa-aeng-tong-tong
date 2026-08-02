@extends('frontend.layouts.app')

@section('title', $statistic->name)
@section('meta_description', $statistic->description ? Str::limit(strip_tags((string) $statistic->description), 160) : 'Data statistik Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="{{ $statistic->category->label() }}"
        subtitle="Data tahun {{ $statistic->year }}"
    />

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        <article class="grid gap-8 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">
                    {{ $statistic->category->label() }} · {{ $statistic->year }}
                </p>
                <h1 class="mt-2 font-display text-3xl font-semibold text-ink-900">
                    {{ $statistic->name }}
                </h1>

                @if ($statistic->description)
                    <div class="prose prose-ink mt-4 max-w-none text-sm leading-relaxed text-ink-600">
                        {!! $statistic->description !!}
                    </div>
                @endif

                @if ($statistic->populationStatistics->isNotEmpty())
                    <div class="mt-8 overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm">
                        <table class="min-w-full divide-y divide-ink-100 text-sm">
                            <thead>
                                <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                                    <th class="px-5 py-3">Keterangan</th>
                                    <th class="px-5 py-3 text-right">Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ink-100">
                                @foreach ($statistic->populationStatistics as $row)
                                    <tr>
                                        <td class="px-5 py-3 text-ink-700">{{ $row->label }}</td>
                                        <td class="px-5 py-3 text-right font-semibold text-ink-900">
                                            {{ number_format((float) $row->value, 0, ',', '.') }}
                                            @if ($row->unit)
                                                <span class="text-xs font-normal text-ink-500">{{ $row->unit }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <div>
                @if ($statistic->populationStatistics->isNotEmpty())
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                        <h2 class="font-display text-base font-semibold text-ink-900">Grafik</h2>
                        <div class="mt-4 h-72">
                            <canvas
                                x-data="chartBar(
                                    @js($statistic->populationStatistics->pluck('label')->all()),
                                    @js($statistic->populationStatistics->map(fn ($row) => (float) $row->value)->all()),
                                    @js($statistic->name)
                                )"
                            ></canvas>
                        </div>
                    </div>
                @endif
            </div>
        </article>

        <div class="mt-12">
            <a href="{{ route('statistics.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Statistik Desa
            </a>
        </div>
    </section>
@endsection
