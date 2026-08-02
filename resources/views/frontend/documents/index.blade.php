@extends('frontend.layouts.app')

@section('title', 'Dokumen')
@section('meta_description', 'Arsip dan unduhan dokumen publik Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Download Dokumen"
        subtitle="Arsip dokumen resmi desa yang dapat diunduh masyarakat."
    />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        @if ($documents->isNotEmpty())
            <div class="space-y-4">
                @foreach ($documents as $item)
                    <div class="flex flex-col gap-4 rounded-2xl border border-ink-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-brand-100 font-display text-sm font-bold text-brand-700">
                            PDF
                        </div>
                        <div class="min-w-0 flex-1">
                            <h2 class="font-display text-base font-semibold text-ink-900">{{ $item->title }}</h2>
                            @if ($item->category || $item->file_size)
                                <p class="mt-0.5 text-xs text-ink-500">
                                    @if ($item->category)
                                        <span class="font-semibold text-brand-600">{{ $item->category }}</span>
                                    @endif
                                    @if ($item->category && $item->file_size)
                                        ·
                                    @endif
                                    {{ $item->file_size ?? '' }}
                                </p>
                            @endif
                            @if ($item->description)
                                <p class="mt-1.5 line-clamp-2 text-sm text-ink-600">
                                    {!! Str::limit(strip_tags((string) $item->description), 140) !!}
                                </p>
                            @endif
                            <p class="mt-1 text-xs text-ink-400">
                                Diunduh {{ number_format($item->download_count) }} kali
                            </p>
                        </div>
                        <a
                            href="{{ route('documents.download', $item) }}"
                            class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Unduh
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $documents->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada dokumen yang dapat diunduh.</p>
            </div>
        @endif
    </section>
@endsection
