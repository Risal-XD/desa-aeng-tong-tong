@extends('frontend.layouts.app')

@section('title', 'Wisata')
@section('meta_description', 'Destinasi wisata Desa Aeng Tong-Tong, Kecamatan Saronggi, Sumenep.')

@section('content')
    <x-frontend.page-hero
        title="Wisata Desa"
        subtitle="Menjelajahi destinasi dan keindahan Desa Aeng Tong-Tong."
        :image="$heroImage"
        imagePosition="right center"
        backgroundSize="280%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($destinations->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($destinations as $item)
                    <a href="{{ route('tourism.show', $item) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="relative flex h-48 items-center justify-center overflow-hidden bg-brand-100">
                            @if ($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <span class="font-display text-4xl font-semibold text-brand-600">{{ mb_substr($item->title, 0, 1) }}</span>
                            @endif
                            @if ($item->category)
                                <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide text-brand-700">
                                    {{ $item->category }}
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <h2 class="font-display text-base font-semibold text-ink-900 group-hover:text-brand-600">{{ $item->title }}</h2>
                            @if ($item->address)
                                <p class="mt-1 flex items-center gap-1.5 text-xs text-ink-500">
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                    {{ $item->address }}
                                </p>
                            @endif
                            @if ($item->description)
                                <div class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500">
                                    {!! Str::limit(strip_tags((string) $item->description), 140) !!}
                                </div>
                            @endif
                            @if ($item->entrance_fee)
                                <p class="mt-3 text-xs font-semibold text-brand-600">{{ $item->entrance_fee }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $destinations->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada destinasi wisata.</p>
            </div>
        @endif
    </section>
@endsection
