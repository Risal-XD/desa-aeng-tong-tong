@extends('frontend.layouts.app')

@section('title', 'APBDes')
@section('meta_description', 'Anggaran Pendapatan dan Belanja Desa Aeng Tong-Tong — transparansi keuangan desa.')

@section('content')
    <x-frontend.page-hero
        title="APBDes"
        subtitle="Anggaran Pendapatan dan Belanja Desa sebagai wujud transparansi dan akuntabilitas keuangan desa."
    />

    <section class="mx-auto max-w-5xl px-4 py-16 sm:px-6">
        @forelse ($years as $year)
            <div class="mb-12">
                <h2 class="font-display text-2xl font-semibold text-ink-900">Tahun {{ $year }}</h2>

                <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                    @foreach ($types as $type)
                        @php
                            $typeItems = $items->where('year', $year)->where('type', $type);
                            $total = $summary[(string) $year][$type->value] ?? null;
                        @endphp
                        @if ($typeItems->isNotEmpty())
                            <div class="min-w-0 rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                                <h3 class="text-sm font-semibold uppercase tracking-wide text-ink-500">{{ $type->label() }}</h3>
                                <p class="mt-3 text-lg font-semibold text-ink-900">Rp {{ number_format($total['budget'] ?? 0, 0, ',', '.') }}</p>
                                <p class="text-xs text-ink-500">
                                    Realisasi: Rp {{ number_format($total['realization'] ?? 0, 0, ',', '.') }}
                                </p>

                                <div class="mt-4 space-y-2 border-t border-ink-100 pt-4">
                                    @foreach ($typeItems as $item)
                                        <div class="flex items-center justify-between gap-3 text-sm">
                                            <span class="min-w-0 truncate text-ink-700">{{ $item->name }}</span>
                                            <span class="shrink-0 font-semibold text-ink-900">
                                                Rp {{ number_format((float) $item->realization_amount, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada data APBDes.</p>
            </div>
        @endforelse
    </section>
@endsection
