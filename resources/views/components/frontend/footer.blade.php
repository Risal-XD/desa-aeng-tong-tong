@props(['village' => null])

@php
    $settings = app(\App\Services\SettingService::class);
    $contactEmail = $settings->get('contact_email', 'desa.aengtongtong@gmail.com');
    $contactPhone = $settings->get('contact_phone', null);
    $contactAddress = $settings->get('contact_address', null);
    $sosmed = [
        'facebook' => $settings->get('sosmed_facebook', null),
        'instagram' => $settings->get('sosmed_instagram', null),
        'twitter' => $settings->get('sosmed_twitter', null),
        'youtube' => $settings->get('sosmed_youtube', null),
        'tiktok' => $settings->get('sosmed_tiktok', null),
    ];
@endphp

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
                @if ($contactAddress)
                    <li class="flex gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $contactAddress }}</span>
                    </li>
                @elseif ($village)
                    <li class="flex gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>{{ $village->address }}</span>
                    </li>
                @endif
                @if ($contactPhone)
                    <li class="flex gap-2.5">
                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        <span>{{ $contactPhone }}</span>
                    </li>
                @endif
                <li class="flex gap-2.5">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-brand-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>{{ $contactEmail }}</span>
                </li>
            </ul>

            @if (array_filter($sosmed))
                <div class="mt-4 flex items-center gap-2">
                    @foreach ($sosmed as $label => $url)
                        @if ($url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($label) }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-ink-800 text-ink-300 transition hover:bg-brand-500 hover:text-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    @if ($label === 'facebook')
                                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                                    @elseif ($label === 'instagram')
                                        <rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                    @elseif ($label === 'twitter')
                                        <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/>
                                    @elseif ($label === 'youtube')
                                        <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"/><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"/>
                                    @else
                                        <circle cx="12" cy="12" r="10"/>
                                    @endif
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-ink-800 py-4">
        <p class="mx-auto max-w-6xl px-4 text-center text-xs text-ink-500 sm:px-6">
            &copy; {{ date('Y') }} Pemerintah Desa Aeng Tong-Tong · Kec. Saronggi, Kab. Sumenep, Jawa Timur.
        </p>
    </div>
</footer>
