@extends('frontend.layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Informasi kontak dan alamat Kantor Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Hubungi Kami"
        subtitle="Sampaikan pertanyaan atau informasi kepada Pemerintah Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <div class="grid gap-10 lg:grid-cols-2">
            <div>
                <h2 class="font-display text-2xl font-semibold text-ink-900">Informasi Kontak</h2>
                <p class="mt-3 text-sm leading-relaxed text-ink-500">
                    Kantor Desa melayani masyarakat pada hari kerja. Silakan hubungi kami melalui informasi di bawah ini.
                </p>

                <div class="mt-8 space-y-5">
                    @if ($village)
                        <div class="flex gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-ink-900">Alamat Kantor</p>
                                <p class="mt-1 text-sm text-ink-500">{{ $village->getFullAddressAttribute() }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-ink-900">Email</p>
                                <p class="mt-1 text-sm text-ink-500">desa.aengtongtong@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-100 text-brand-700">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            </span>
                            <div>
                                <p class="text-sm font-semibold text-ink-900">Koordinat</p>
                                <p class="mt-1 text-sm text-ink-500">{{ $village->latitude }}, {{ $village->longitude }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-ink-500">Data kontak desa belum tersedia.</p>
                    @endif
                </div>
            </div>

            <div class="rounded-3xl border border-ink-200 bg-white p-6 shadow-sm sm:p-8">
                <h2 class="font-display text-xl font-semibold text-ink-900">Kirim Pesan</h2>
                <p class="mt-2 text-sm text-ink-500">Formulir pesan akan aktif pada pengembangan selanjutnya.</p>
                <form class="mt-6 space-y-4" method="POST" action="{{ route('kontak') }}">
                    @csrf
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium text-ink-700">Nama</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            disabled
                            class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 disabled:bg-ink-50 disabled:text-ink-400"
                        >
                    </div>
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-ink-700">Email</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            disabled
                            class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 disabled:bg-ink-50 disabled:text-ink-400"
                        >
                    </div>
                    <div>
                        <label for="subject" class="mb-1.5 block text-sm font-medium text-ink-700">Subjek</label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            disabled
                            class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 disabled:bg-ink-50 disabled:text-ink-400"
                        >
                    </div>
                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-medium text-ink-700">Pesan</label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            disabled
                            class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40 disabled:bg-ink-50 disabled:text-ink-400"
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        disabled
                        class="w-full rounded-xl bg-brand-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600 disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
