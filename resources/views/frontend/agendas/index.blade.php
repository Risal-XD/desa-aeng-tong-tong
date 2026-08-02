@extends('frontend.layouts.app')

@section('title', 'Agenda')
@section('meta_description', 'Agenda dan kegiatan mendatang di Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Agenda Desa"
        subtitle="Kegiatan dan acara yang akan datang di Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        @if ($agendas->isNotEmpty())
            <div class="space-y-4">
                @foreach ($agendas as $item)
                    <div class="flex gap-4 rounded-2xl border border-ink-200 bg-white p-6 shadow-sm sm:gap-6">
                        <div class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-xl bg-brand-50 text-center">
                            <span class="font-display text-2xl font-semibold leading-none text-brand-700">{{ $item->event_date->format('d') }}</span>
                            <span class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-brand-600">{{ $item->event_date->translatedFormat('M Y') }}</span>
                        </div>
                        <div class="min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($item->is_featured)
                                    <span class="rounded-full bg-brand-500 px-2 py-0.5 text-[10px] font-semibold text-white">Unggulan</span>
                                @endif
                                <span class="text-xs text-ink-400">{{ $item->event_date->translatedFormat('l') }}</span>
                            </div>
                            <h2 class="mt-1 font-display text-lg font-semibold text-ink-900">{{ $item->title }}</h2>
                            <p class="mt-1 flex items-center gap-1.5 text-xs text-ink-500">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $item->location ?? 'Lokasi belum diisi' }}
                            </p>
                            <p class="mt-1 flex items-center gap-1.5 text-xs text-ink-500">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $item->start_time?->format('H:i') }}–{{ $item->end_time?->format('H:i') }}
                            </p>
                            @if ($item->description)
                                <div class="prose prose-ink mt-3 max-w-none text-sm leading-relaxed text-ink-600">
                                    {!! Str::limit(strip_tags((string) $item->description), 160) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $agendas->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada agenda mendatang.</p>
            </div>
        @endif
    </section>
@endsection
