@props(['village' => null])

<footer class="mt-auto border-t border-ink-800 bg-ink-950 text-ink-300">
    <div class="mx-auto grid max-w-6xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-3">
        <div>
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-500 font-display text-lg font-semibold text-white">AT</span>
                <span class="leading-tight">
                    <span class="block font-display text-base font-semibold text-white">Desa Aeng Tong-Tong</span>
                    <span class="block text-xs text-ink-400">Kec. Saronggi, Kab. Sumenep</span>
                </span>
            </div>
            <p class="mt-4 text-sm leading-relaxed text-ink-400">
                Website resmi Desa Aeng Tong-Tong — desa wisata sentra kerajinan keris dan peraih Juara 1
                Anugerah Desa Wisata Indonesia (ADWI) 2022.
            </p>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Navigasi</h3>
            <ul class="mt-4 grid grid-cols-2 gap-2 text-sm">
                <li><a href="{{ route('home') }}" class="transition hover:text-brand-400">Beranda</a></li>
                <li><a href="{{ route('about.sejarah') }}" class="transition hover:text-brand-400">Sejarah</a></li>
                <li><a href="{{ route('about.visi-misi') }}" class="transition hover:text-brand-400">Visi &amp; Misi</a></li>
                <li><a href="{{ route('about.struktur') }}" class="transition hover:text-brand-400">Struktur</a></li>
                <li><a href="{{ route('about.perangkat') }}" class="transition hover:text-brand-400">Perangkat</a></li>
                <li><a href="{{ route('potensi') }}" class="transition hover:text-brand-400">Potensi</a></li>
                <li><a href="{{ route('kontak') }}" class="transition hover:text-brand-400">Kontak</a></li>
                <li><a href="{{ route('faq') }}" class="transition hover:text-brand-400">FAQ</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-white">Kontak</h3>
            <ul class="mt-4 space-y-3 text-sm text-ink-400">
                @if ($village)
                    <li class="flex gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $village->address }}</span>
                    </li>
                    <li class="flex gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <span>Kec. {{ $village->district }}, Kab. {{ $village->regency }}, {{ $village->province }}</span>
                    </li>
                @endif
                <li class="flex gap-2.5">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>desa.aengtongtong@gmail.com</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="border-t border-ink-800 py-4">
        <p class="mx-auto max-w-6xl px-4 text-center text-xs text-ink-500 sm:px-6">
            &copy; {{ date('Y') }} Pemerintah Desa Aeng Tong-Tong · Kec. Saronggi, Kab. Sumenep, Jawa Timur.
        </p>
    </div>
</footer>
