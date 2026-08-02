@extends('frontend.layouts.app')

@section('title', $announcement->title)
@section('meta_description', Str::limit(strip_tags((string) $announcement->content), 160))

@section('content')
    <x-frontend.page-hero title="Pengumuman" />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <article>
            <div class="flex items-center gap-3 text-xs text-ink-400">
                <span class="rounded-full bg-brand-50 px-3 py-1 font-semibold uppercase tracking-wide text-brand-700">Pengumuman</span>
                <span>{{ $announcement->published_at?->translatedFormat('d M Y') }}</span>
                <span>Oleh {{ $announcement->author?->name ?? 'Admin' }}</span>
            </div>

            <h1 class="mt-4 font-display text-3xl font-semibold leading-tight text-ink-900 sm:text-4xl">
                {{ $announcement->title }}
            </h1>

            @if ($announcement->content)
                <div class="prose prose-ink mt-8 max-w-none text-sm leading-relaxed text-ink-600 sm:text-base">
                    {!! $announcement->content !!}
                </div>
            @endif

            @if ($announcement->attachment)
                <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" class="mt-8 inline-flex items-center gap-2 rounded-xl bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="m9 15 6 6"/><path d="m15 15-6 6"/></svg>
                    Unduh Lampiran
                </a>
            @endif
        </article>

        <div class="mt-12">
            <a href="{{ route('announcements.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Pengumuman
            </a>
        </div>
    </section>
@endsection
