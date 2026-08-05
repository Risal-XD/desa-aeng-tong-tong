@extends('frontend.layouts.app')

@section('title', 'Berita')
@section('meta_description', 'Berita dan artikel terbaru dari Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Berita Desa"
        subtitle="Informasi dan kabar terbaru seputar Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($news->isNotEmpty())
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <a href="{{ route('news.show', $item) }}" class="group relative flex flex-col overflow-hidden rounded-3xl border border-white/20 bg-surface-container-low/80 backdrop-blur-xl shadow-lg transition duration-500 hover:-translate-y-2 hover:border-primary/40 hover:shadow-2xl">
                        <div class="relative flex h-52 items-center justify-center overflow-hidden bg-surface-container">
                            @if ($item->cover_image)
                                <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-110">
                            @else
                                <span class="font-display text-4xl font-semibold text-primary">{{ mb_substr($item->title, 0, 1) }}</span>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                            @if ($item->category)
                                <span class="absolute left-4 top-4 rounded-full bg-surface/90 backdrop-blur-md px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-primary shadow-sm">
                                    {{ $item->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-6">
                            <div class="flex items-center justify-between text-xs text-on-surface-variant">
                                <span>{{ $item->published_at?->translatedFormat('d M Y') }}</span>
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                    {{ number_format($item->views_count) }}
                                </span>
                            </div>
                            <h2 class="mt-3 font-display text-lg font-semibold leading-snug text-on-surface transition group-hover:text-primary">
                                {{ $item->title }}
                            </h2>
                            @if ($item->excerpt)
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-on-surface-variant">{{ $item->excerpt }}</p>
                            @endif
                            <div class="mt-6 flex items-center justify-between border-t border-outline-variant/30 pt-4 text-sm font-semibold text-primary">
                                <span class="group-hover:underline">Baca Selengkapnya</span>
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-primary/10 transition group-hover:bg-primary group-hover:text-on-primary">
                                    <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $news->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada berita.</p>
            </div>
        @endif
    </section>
@endsection
