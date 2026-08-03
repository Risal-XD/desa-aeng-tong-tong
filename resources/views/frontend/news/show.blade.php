@extends('frontend.layouts.app')

@section('title', $news->title)
@section('meta_description', $news->excerpt ?? Str::limit(strip_tags((string) $news->content), 160))
@section('og_type', 'article')
@section('og_image', $news->cover_image ? asset('storage/'.$news->cover_image) : '')

@section('content')
    <x-frontend.page-hero title="Berita" />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <article>
            <div class="flex items-center gap-3 text-xs text-ink-400">
                @if ($news->category)
                    <span class="rounded-full bg-brand-50 px-3 py-1 font-semibold uppercase tracking-wide text-brand-700">{{ $news->category->name }}</span>
                @endif
                <span>{{ $news->published_at?->translatedFormat('d M Y') }}</span>
                <span>Oleh {{ $news->author?->name ?? 'Admin' }}</span>
            </div>

            <h1 class="mt-4 font-display text-3xl font-semibold leading-tight text-ink-900 sm:text-4xl">
                {{ $news->title }}
            </h1>

            @if ($news->excerpt)
                <p class="mt-4 text-base leading-relaxed text-ink-500">{{ $news->excerpt }}</p>
            @endif

            @if ($news->cover_image)
                <div class="mt-8 overflow-hidden rounded-2xl">
                    <img src="{{ asset('storage/'.$news->cover_image) }}" alt="{{ $news->title }}" class="h-72 w-full object-cover">
                </div>
            @endif

            <div class="prose prose-ink mt-8 max-w-none text-sm leading-relaxed text-ink-600 sm:text-base">
                {!! $news->content !!}
            </div>

            @if ($news->tags)
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ($news->tags as $tag)
                        <span class="rounded-full bg-ink-100 px-3 py-1 text-xs font-medium text-ink-600">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            @if ($news->source)
                <p class="mt-6 text-xs text-ink-400">Sumber: {{ $news->source }}</p>
            @endif
        </article>

        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-ink-200 pt-10">
                <h2 class="font-display text-xl font-semibold text-ink-900">Berita Terkait</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('news.show', $item) }}" class="group rounded-xl border border-ink-200 bg-white p-5 transition hover:border-brand-300 hover:shadow-md">
                            <p class="text-xs text-ink-400">{{ $item->published_at?->translatedFormat('d M Y') }}</p>
                            <h3 class="mt-2 font-display text-sm font-semibold leading-snug text-ink-900 group-hover:text-brand-600">
                                {{ $item->title }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
