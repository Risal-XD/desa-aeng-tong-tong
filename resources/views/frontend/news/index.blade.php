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
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($news as $item)
                    <a href="{{ route('news.show', $item) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="relative flex h-44 items-center justify-center overflow-hidden bg-brand-100">
                            @if ($item->cover_image)
                                <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <span class="font-display text-4xl font-semibold text-brand-600">{{ mb_substr($item->title, 0, 1) }}</span>
                            @endif
                            @if ($item->category)
                                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-brand-700">
                                    {{ $item->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <p class="text-xs text-ink-400">
                                {{ $item->published_at?->translatedFormat('d M Y') }} · {{ number_format($item->views_count) }} kali dilihat
                            </p>
                            <h2 class="mt-2 font-display text-base font-semibold leading-snug text-ink-900 group-hover:text-brand-600">
                                {{ $item->title }}
                            </h2>
                            @if ($item->excerpt)
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500">{{ $item->excerpt }}</p>
                            @endif
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
