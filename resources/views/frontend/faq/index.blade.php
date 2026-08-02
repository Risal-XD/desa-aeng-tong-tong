@extends('frontend.layouts.app')

@section('title', 'FAQ')
@section('meta_description', 'Pertanyaan yang sering diajukan mengenai Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Pertanyaan Umum"
        subtitle="Jawaban atas pertanyaan yang sering diajukan tentang Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
        <div x-data="{ open: null }" class="space-y-3">
            @php
                $faqs = [
                    [
                        'q' => 'Di mana lokasi Desa Aeng Tong-Tong?',
                        'a' => 'Desa Aeng Tong-Tong terletak di Kecamatan Saronggi, Kabupaten Sumenep, Provinsi Jawa Timur.',
                    ],
                    [
                        'q' => 'Apa keunikan Desa Aeng Tong-Tong?',
                        'a' => 'Desa ini dikenal sebagai sentra kerajinan keris dengan puluhan Mpu (pembuat keris) dan meraih Rekor MURI sebagai desa dengan Mpu terbanyak di dunia, serta Juara 1 Anugerah Desa Wisata Indonesia (ADWI) 2022.',
                    ],
                    [
                        'q' => 'Apa saja potensi desa yang bisa dikunjungi?',
                        'a' => 'Potensi utama meliputi sentra kerajinan keris, wisata budaya desa, dan ekonomi kreatif UMKM masyarakat.',
                    ],
                    [
                        'q' => 'Bagaimana cara menghubungi pemerintah desa?',
                        'a' => 'Anda dapat mengunjungi halaman Kontak untuk melihat alamat kantor dan informasi kontak resmi Desa Aeng Tong-Tong.',
                    ],
                ];
            @endphp

            @foreach ($faqs as $index => $faq)
                <div class="overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm">
                    <button
                        type="button"
                        @click="open = open === {{ $index }} ? null : {{ $index }}"
                        class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left"
                    >
                        <span class="text-sm font-semibold text-ink-900">{{ $faq['q'] }}</span>
                        <svg class="h-5 w-5 shrink-0 text-brand-500" :class="open === {{ $index }} ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="open === {{ $index }}" x-cloak x-transition>
                        <p class="border-t border-ink-100 px-6 py-4 text-sm leading-relaxed text-ink-600">{{ $faq['a'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
