@extends('frontend.layouts.app')

@section('title', $keris_artisan->name)
@section('meta_description', $keris_artisan->bio ? Str::limit(strip_tags((string) $keris_artisan->bio), 160) : 'Profil Mpu Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero title="Kerajinan Keris" />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <article class="grid gap-8 sm:grid-cols-3">
            <div class="sm:col-span-1">
                <div class="flex h-40 w-40 items-center justify-center overflow-hidden rounded-full bg-brand-100">
                    @if ($keris_artisan->photo)
                        <img src="{{ asset('storage/'.$keris_artisan->photo) }}" alt="{{ $keris_artisan->name }}" class="h-full w-full object-cover">
                    @else
                        <span class="font-display text-5xl font-semibold text-brand-700">{{ mb_substr($keris_artisan->name, 0, 1) }}</span>
                    @endif
                </div>
                @if ($keris_artisan->title)
                    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $keris_artisan->title }}</p>
                @endif
                <h1 class="mt-1 font-display text-2xl font-semibold text-ink-900">{{ $keris_artisan->name }}</h1>

                @if ($keris_artisan->specialties)
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($keris_artisan->specialties as $specialty)
                            <span class="rounded-full bg-ink-100 px-3 py-1 text-xs font-medium text-ink-600">{{ $specialty }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="sm:col-span-2">
                @if ($keris_artisan->bio)
                    <div class="prose prose-ink max-w-none text-sm leading-relaxed text-ink-600 sm:text-base">
                        {!! $keris_artisan->bio !!}
                    </div>
                @endif

                <dl class="mt-6 space-y-3 rounded-2xl border border-ink-200 bg-ink-50 p-6 text-sm">
                    @if ($keris_artisan->experience_years)
                        <div class="flex gap-3">
                            <dt class="w-32 shrink-0 text-ink-500">Pengalaman</dt>
                            <dd class="text-ink-700">{{ $keris_artisan->experience_years }}</dd>
                        </div>
                    @endif
                    @if ($keris_artisan->award)
                        <div class="flex gap-3">
                            <dt class="w-32 shrink-0 text-ink-500">Penghargaan</dt>
                            <dd class="text-ink-700">{{ $keris_artisan->award }}</dd>
                        </div>
                    @endif
                    @if ($keris_artisan->address)
                        <div class="flex gap-3">
                            <dt class="w-32 shrink-0 text-ink-500">Alamat</dt>
                            <dd class="text-ink-700">{{ $keris_artisan->address }}</dd>
                        </div>
                    @endif
                    @if ($keris_artisan->phone)
                        <div class="flex gap-3">
                            <dt class="w-32 shrink-0 text-ink-500">Telepon</dt>
                            <dd class="text-ink-700">{{ $keris_artisan->phone }}</dd>
                        </div>
                    @endif
                    @if ($keris_artisan->website)
                        <div class="flex gap-3">
                            <dt class="w-32 shrink-0 text-ink-500">Situs</dt>
                            <dd class="text-ink-700">{{ $keris_artisan->website }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </article>

        <div class="mt-12">
            <a href="{{ route('keris.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Daftar Mpu
            </a>
        </div>
    </section>
@endsection
