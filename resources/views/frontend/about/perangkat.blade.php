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

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6" data-aos="fade-up">
        @if (! empty($groups))
            @foreach ($groups as $group)
                @if (strtolower($group['position']) === 'kepala desa')
                    {{-- Featured Kepala Desa Profile --}}
                    @php $chief = $group['officials'][0] ?? null; @endphp
                    @if ($chief)
                        <h2 class="mb-6 font-display text-2xl font-semibold text-ink-900">Kepala Desa</h2>
                        <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-sm overflow-hidden">
                            <div class="w-full lg:w-2/5 flex-shrink-0">
                                    @if ($chief->photo)
                                        <img src="{{ asset('storage/'.$chief->photo) }}" alt="{{ $chief->name }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('foto/Kades.jpeg') }}" alt="{{ $chief->name }}" class="w-full h-full object-cover">
                                    @endif
                            </div>
                            <div class="flex-1 p-8 lg:p-10">
                                <h3 class="text-3xl font-bold text-ink-900 uppercase">HADI SUDIRFAN, S.PD.I</h3>
                                <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-brand-600">KEPALA DESA {{ mb_strtoupper($village->name ?? 'AENG TONG-TONG') }}</p>
                                <p class="mt-4 text-ink-900 text-justify">Sebagai Kepala Desa {{ $village->name ?? '' }}, beliau memiliki peran dalam memimpin penyelenggaraan pemerintahan desa, pemberdayaan masyarakat, serta pengembangan potensi desa sebagai desa wisata berbasis budaya dan kerajinan keris.</p>
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Regular Perangkat Group --}}
                    <div class="mb-14" data-aos="fade-up">
                        <h2 class="mb-6 border-b border-ink-200 pb-3 font-display text-xl font-semibold text-ink-900">
                            {{ $group['position'] }}
                        </h2>
                        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                            @foreach ($group['officials'] as $official)
                                <div class="group rounded-2xl border border-ink-200 bg-white overflow-hidden shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                                    <div class="aspect-[3/4] w-full bg-gray-100 overflow-hidden">
                                        @if ($official->photo)
                                            <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="h-full w-full object-cover">
                                        @else
                                            <div class="flex h-full w-full items-center justify-center bg-brand-100 font-display text-4xl font-semibold text-brand-700">
                                                {{ collect(array_filter(explode(' ', trim($official->name))))->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 text-center">
                                        <h3 class="font-semibold text-ink-900">{{ $official->name }}</h3>
                                        <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-brand-600">{{ $official->position }}</p>
                                        @if ($official->email || $official->phone)
                                            <div class="mt-4 space-y-1 text-xs text-ink-500">
                                                @if ($official->email)
                                                    <p class="flex items-center justify-center gap-1.5">
                                                        <svg class="h-3.5 w-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                                                        <span>{{ $official->email }}</span>
                                                    </p>
                                                @endif
                                                @if ($official->phone)
                                                    <p class="flex items-center justify-center gap-1.5">
                                                        <svg class="h-3.5 w-3.5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                                        <span>{{ $official->phone }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        @if ($official->nip)
                                            <p class="mt-3 text-xs text-ink-400">NIP. {{ $official->nip }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Data perangkat desa belum tersedia.</p>
            </div>
        @endif
    </section>

    {{-- Lokasi Desa Section --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6" data-aos="fade-up">
        <h2 class="mb-6 font-display text-2xl font-semibold text-ink-900">Lokasi Desa</h2>
        <p class="mb-4 text-ink-600">Kunjungi Desa Aeng Tong-Tong dan temukan lokasi Balai Desa kami.</p>
        <div class="grid gap-8 lg:grid-cols-2">
            <div class="space-y-4">
                <h3 class="text-xl font-semibold text-ink-800">Balai Desa Aeng Tong-Tong</h3>
                <p class="text-ink-600">
                    Desa Aeng Tong-Tong,<br>
                    Kecamatan Saronggi,<br>
                    Kabupaten Sumenep,<br>
                    Jawa Timur, Indonesia
                </p>
                <p class="text-ink-600"><strong>Latitude:</strong> -7.0836785</p>
                <p class="text-ink-600"><strong>Longitude:</strong> 113.7923879</p>
                <a href="https://www.google.com/maps/place/Balai+Desa+Aeng+Tong-Tong/@-7.0836732,113.789813,17z/data=!3m1!4b1!4m6!3m5!1s0x2dd9e0f1c0000001:0xb87b864f563299d8!8m2!3d-7.0836785!4d113.7923879!16s%2Fg%2F11c2pmnf94" target="_blank" class="inline-block bg-primary text-on-primary px-4 py-2 rounded-lg shadow hover:bg-primary-dark transition">Petunjuk Arah</a>
            </div>
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.740211018331!2d113.7923879!3d-7.0836785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e0f1c0000001%3A0xb87b864f563299d8!2sBalai%20Desa%20Aeng%20Tong-Tong!5e0!3m2!1sid!2sid!4v1723199999999"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                ></iframe>
            </div>
        </div>
    </section>
@endsection

