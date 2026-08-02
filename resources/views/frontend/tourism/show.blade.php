@extends('frontend.layouts.app')

@section('title', $tourism_destination->title)
@section('meta_description', $tourism_destination->description ? Str::limit(strip_tags((string) $tourism_destination->description), 160) : 'Destinasi wisata Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero title="Wisata" />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <article>
            <div class="flex items-center gap-3 text-xs text-ink-400">
                @if ($tourism_destination->category)
                    <span class="rounded-full bg-brand-50 px-3 py-1 font-semibold uppercase tracking-wide text-brand-700">{{ $tourism_destination->category }}</span>
                @endif
                <span>{{ number_format($tourism_destination->views_count) }} kali dilihat</span>
            </div>

            <h1 class="mt-4 font-display text-3xl font-semibold leading-tight text-ink-900 sm:text-4xl">
                {{ $tourism_destination->title }}
            </h1>

            @if ($tourism_destination->image)
                <div class="mt-8 overflow-hidden rounded-2xl">
                    <img src="{{ asset('storage/'.$tourism_destination->image) }}" alt="{{ $tourism_destination->title }}" class="h-80 w-full object-cover">
                </div>
            @endif

            @if ($tourism_destination->description)
                <div class="prose prose-ink mt-8 max-w-none text-sm leading-relaxed text-ink-600 sm:text-base">
                    {!! $tourism_destination->description !!}
                </div>
            @endif

            @if ($tourism_destination->gallery)
                <div class="mt-10">
                    <h2 class="font-display text-xl font-semibold text-ink-900">Galeri</h2>
                    <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach ($tourism_destination->gallery as $image)
                            <a href="{{ asset('storage/'.$image) }}" target="_blank" class="aspect-square overflow-hidden rounded-xl">
                                <img src="{{ asset('storage/'.$image) }}" alt="Galeri {{ $tourism_destination->title }}" class="h-full w-full object-cover transition duration-300 hover:scale-105">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($tourism_destination->address || $tourism_destination->open_hours || $tourism_destination->entrance_fee)
                <div class="mt-10 rounded-2xl border border-ink-200 bg-ink-50 p-6">
                    <h2 class="font-display text-lg font-semibold text-ink-900">Informasi Kunjungan</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        @if ($tourism_destination->address)
                            <div class="flex gap-3">
                                <dt class="w-28 shrink-0 text-ink-500">Alamat</dt>
                                <dd class="text-ink-700">{{ $tourism_destination->address }}</dd>
                            </div>
                        @endif
                        @if ($tourism_destination->open_hours)
                            <div class="flex gap-3">
                                <dt class="w-28 shrink-0 text-ink-500">Jam Buka</dt>
                                <dd class="text-ink-700">{{ $tourism_destination->open_hours }}</dd>
                            </div>
                        @endif
                        @if ($tourism_destination->entrance_fee)
                            <div class="flex gap-3">
                                <dt class="w-28 shrink-0 text-ink-500">Harga Tiket</dt>
                                <dd class="text-ink-700">{{ $tourism_destination->entrance_fee }}</dd>
                            </div>
                        @endif
                        @if ($tourism_destination->latitude && $tourism_destination->longitude)
                            <div class="flex gap-3">
                                <dt class="w-28 shrink-0 text-ink-500">Koordinat</dt>
                                <dd class="text-ink-700">{{ $tourism_destination->latitude }}, {{ $tourism_destination->longitude }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif
        </article>

        @if ($related->isNotEmpty())
            <div class="mt-16 border-t border-ink-200 pt-10">
                <h2 class="font-display text-xl font-semibold text-ink-900">Wisata Lainnya</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    @foreach ($related as $item)
                        <a href="{{ route('tourism.show', $item) }}" class="group rounded-xl border border-ink-200 bg-white p-5 transition hover:border-brand-300 hover:shadow-md">
                            @if ($item->category)
                                <p class="text-xs font-semibold uppercase tracking-wide text-brand-600">{{ $item->category }}</p>
                            @endif
                            <h3 class="mt-1 font-display text-sm font-semibold text-ink-900 group-hover:text-brand-600">{{ $item->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
