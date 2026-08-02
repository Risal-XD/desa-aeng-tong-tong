@extends('frontend.layouts.app')

@section('title', 'Kerajinan Keris')
@section('meta_description', 'Sentra kerajinan keris dan para Mpu Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Kerajinan Keris & Mpu"
        subtitle="Sentra keris dengan Rekor MURI — rumah para Mpu pewaris tradisi."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($artisans->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($artisans as $item)
                    <a href="{{ route('keris.show', $item) }}" class="group rounded-2xl border border-ink-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="mx-auto flex h-20 w-20 items-center justify-center overflow-hidden rounded-full bg-brand-100">
                            @if ($item->photo)
                                <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                            @else
                                <span class="font-display text-2xl font-semibold text-brand-700">{{ mb_substr($item->name, 0, 1) }}</span>
                            @endif
                        </div>
                        @if ($item->title)
                            <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $item->title }}</p>
                        @endif
                        <h2 class="mt-1 font-display text-lg font-semibold text-ink-900 group-hover:text-brand-600">{{ $item->name }}</h2>
                        @if ($item->specialties)
                            <div class="mt-3 flex flex-wrap justify-center gap-2">
                                @foreach ($item->specialties as $specialty)
                                    <span class="rounded-full bg-ink-100 px-3 py-1 text-xs font-medium text-ink-600">{{ $specialty }}</span>
                                @endforeach
                            </div>
                        @endif
                        @if ($item->experience_years)
                            <p class="mt-3 text-xs text-ink-500">{{ $item->experience_years }} berkarya</p>
                        @endif
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada data Mpu.</p>
            </div>
        @endif
    </section>
@endsection
