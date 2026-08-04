@extends('frontend.layouts.app')

@section('title', 'Sejarah Desa')
@section('meta_description', 'Sejarah berdirinya Desa Aeng Tong-Tong dan tradisi pembuatan keris oleh para Mpu.')

@section('content')
    <x-frontend.page-hero
        title="Sejarah Desa"
        subtitle="Perjalanan panjang Desa Aeng Tong-Tong hingga menjadi desa wisata keris yang dikenal luas."
        :image="$heroImage"
        imagePosition="right top"
        backgroundSize="220%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($village?->history?->history_content)
            <div class="grid gap-10 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <div class="prose prose-ink max-w-none rounded-2xl border border-ink-200 bg-white p-6 text-sm leading-relaxed text-ink-600 shadow-sm sm:p-8">
                        {!! $village->history->history_content !!}
                    </div>
                </div>

                <aside class="space-y-4">
                    <div class="rounded-2xl border border-ink-200 bg-white p-6 shadow-sm">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-ink-900">Informasi</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            @if ($village->history->founder_name)
                                <div>
                                    <dt class="text-ink-500">Pendiri / Tokoh</dt>
                                    <dd class="mt-0.5 font-medium text-ink-800">{{ $village->history->founder_name }}</dd>
                                </div>
                            @endif
                            @if ($village->history->founded_year)
                                <div>
                                    <dt class="text-ink-500">Berdiri Sejak</dt>
                                    <dd class="mt-0.5 font-medium text-ink-800">{{ $village->history->founded_year }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <div class="rounded-2xl bg-brand-50 p-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-brand-800">Berlanjut</h3>
                        <p class="mt-2 text-sm text-ink-600">Pelajari visi dan misi pembangunan desa selanjutnya.</p>
                        <a href="{{ route('about.visi-misi') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-600 transition hover:text-brand-700">
                            Visi &amp; Misi
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </aside>
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Konten sejarah desa belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection
