@extends('frontend.layouts.app')

@section('title', 'Perangkat Desa')
@section('meta_description', 'Daftar perangkat Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Perangkat Desa"
        subtitle="Perangkat yang mengabdi untuk masyarakat Desa Aeng Tong-Tong."
        :image="$heroImage"
        imagePosition="right center"
        backgroundSize="280%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if (! empty($groups))
            @foreach ($groups as $group)
                <div class="mb-14">
                    <h2 class="mb-6 border-b border-ink-200 pb-3 font-display text-xl font-semibold text-ink-900">
                        {{ $group['position'] }}
                    </h2>
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        @foreach ($group['officials'] as $official)
                            <div class="group rounded-2xl border border-ink-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                                @if ($official->photo)
                                    <img
                                        src="{{ asset('storage/'.$official->photo) }}"
                                        alt="{{ $official->name }}"
                                        class="mx-auto h-20 w-20 rounded-full object-cover"
                                    >
                                @else
                                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-100 font-display text-2xl font-semibold text-brand-700">
                                        {{ collect(array_filter(explode(' ', trim($official->name))))->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                                    </div>
                                @endif
                                <h3 class="mt-4 font-semibold text-ink-900">{{ $official->name }}</h3>
                                <p class="mt-1 text-sm text-brand-600">{{ $official->position }}</p>
                                @if ($official->nip)
                                    <p class="mt-2 text-xs text-ink-400">NIP. {{ $official->nip }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Data perangkat desa belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection
