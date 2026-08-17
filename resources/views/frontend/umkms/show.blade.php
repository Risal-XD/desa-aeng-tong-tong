@extends('frontend.layouts.app')

@section('title', $umkm->name)
@section('meta_description', $umkm->description ? Str::limit(strip_tags((string) $umkm->description), 160) : 'UMKM Desa Aeng Tong-Tong.')
@section('og_image', $umkm->cover_image ? asset('storage/'.$umkm->cover_image) : '')

@section('content')
    <x-frontend.page-hero title="UMKM" />

    <section class="mx-auto max-w-4xl px-4 py-16 sm:px-6">
        <article class="grid grid-cols-1 gap-8 sm:grid-cols-3">
            <div class="min-w-0 sm:col-span-1">
                <div class="flex h-40 w-40 items-center justify-center overflow-hidden rounded-2xl bg-brand-100">
                    @if ($umkm->logo)
                        <img src="{{ asset('storage/'.$umkm->logo) }}" alt="{{ $umkm->name }}" class="h-full w-full object-cover">
                    @else
                        <span class="font-display text-5xl font-semibold text-brand-700">{{ mb_substr($umkm->name, 0, 1) }}</span>
                    @endif
                </div>
                @if ($umkm->category)
                    <p class="mt-4 text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $umkm->category }}</p>
                @endif
                <h1 class="mt-1 font-display text-2xl font-semibold text-ink-900">{{ $umkm->name }}</h1>
                @if ($umkm->owner_name)
                    <p class="mt-1 text-sm text-ink-500">Pemilik: {{ $umkm->owner_name }}</p>
                @endif
            </div>

            <div class="min-w-0 sm:col-span-2">
                @if ($umkm->cover_image)
                    <div class="overflow-hidden rounded-2xl">
                        <img src="{{ asset('storage/'.$umkm->cover_image) }}" alt="{{ $umkm->name }}" class="h-56 w-full object-cover">
                    </div>
                @endif

                @if ($umkm->description)
                    <div class="prose prose-ink mt-6 max-w-none text-sm leading-relaxed text-ink-600 sm:text-base">
                        {!! $umkm->description !!}
                    </div>
                @endif

                <dl class="mt-6 space-y-3 rounded-2xl border border-ink-200 bg-ink-50 p-6 text-sm">
                    @if ($umkm->address)
                        <div class="flex gap-3">
                            <dt class="w-28 shrink-0 text-ink-500">Alamat</dt>
                            <dd class="text-ink-700">{{ $umkm->address }}</dd>
                        </div>
                    @endif
                    @if ($umkm->phone)
                        <div class="flex gap-3">
                            <dt class="w-28 shrink-0 text-ink-500">Telepon</dt>
                            <dd class="text-ink-700">{{ $umkm->phone }}</dd>
                        </div>
                    @endif
                    @if ($umkm->email)
                        <div class="flex gap-3">
                            <dt class="w-28 shrink-0 text-ink-500">Email</dt>
                            <dd class="text-ink-700">{{ $umkm->email }}</dd>
                        </div>
                    @endif
                    @if ($umkm->instagram)
                        <div class="flex gap-3">
                            <dt class="w-28 shrink-0 text-ink-500">Instagram</dt>
                            <dd class="text-ink-700">{{ $umkm->instagram }}</dd>
                        </div>
                    @endif
                    @if ($umkm->website)
                        <div class="flex gap-3">
                            <dt class="w-28 shrink-0 text-ink-500">Situs</dt>
                            <dd class="text-ink-700">{{ $umkm->website }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </article>

        <div class="mt-12">
            <a href="{{ route('umkms.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Daftar UMKM
            </a>
        </div>
    </section>
@endsection
