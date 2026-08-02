@extends('frontend.layouts.app')

@section('title', 'Video')
@section('meta_description', 'Video profil dan dokumentasi Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Video"
        subtitle="Profil dan dokumentasi kegiatan Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($videos->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($videos as $item)
                    <article class="group overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="aspect-video w-full bg-ink-950">
                            @if ($item->embed_url && $item->platform !== 'lainnya')
                                <iframe
                                    src="{{ $item->embed_url }}"
                                    title="{{ $item->title }}"
                                    class="h-full w-full"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                ></iframe>
                            @else
                                <a href="{{ $item->video_url }}" target="_blank" rel="noopener" class="flex h-full w-full items-center justify-center bg-ink-950">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-brand-500 text-white transition group-hover:scale-110">
                                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                    </span>
                                </a>
                            @endif
                        </div>
                        <div class="p-5">
                            @if ($item->category)
                                <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $item->category->name }}</p>
                            @endif
                            <h2 class="mt-1 font-display text-base font-semibold text-ink-900">{{ $item->title }}</h2>
                            @if ($item->description)
                                <p class="mt-2 line-clamp-2 text-sm text-ink-500">{{ $item->description }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $videos->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada video.</p>
            </div>
        @endif
    </section>
@endsection
