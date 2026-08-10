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
                        <div class="flex flex-col lg:flex-row items-center gap-8 bg-white p-6 rounded-2xl shadow-sm">
                            <div class="w-full lg:w-1/3">
                                @if ($chief->photo)
                                    <img src="{{ asset('storage/'.$chief->photo) }}" alt="{{ $chief->name }}" class="w-full h-auto object-cover rounded-lg">
                                @else
                                    <div class="flex items-center justify-center w-full h-64 bg-gray-200 rounded-lg">
                                        {{ $chief->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-2xl font-bold text-ink-900">{{ $chief->name }}</h3>
                                <p class="text-lg text-ink-700 mt-1">Kepala Desa {{ $village->name ?? '' }}</p>
                                <p class="mt-4 text-ink-600">Sebagai Kepala Desa {{ $village->name ?? '' }}, beliau memiliki peran dalam memimpin penyelenggaraan pemerintahan desa, pemberdayaan masyarakat, serta pengembangan potensi desa sebagai desa wisata berbasis budaya dan kerajinan keris.</p>
                                <ul class="mt-4 space-y-1 text-ink-600">
                                    <li><strong>Nama Lengkap:</strong> {{ $chief->name }}</li>
                                    <li><strong>Jabatan:</strong> Kepala Desa</li>
                                    <li><strong>Desa:</strong> {{ $village->name ?? '' }}</li>
                                    <li><strong>Periode Jabatan:</strong> {{ $chief->period ?? '' }}</li>
                                </ul>
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
                                <div class="group rounded-2xl border border-ink-200 bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                                    @if ($official->photo)
                                        <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="mx-auto h-20 w-20 rounded-lg object-cover">
                                    @else
                                        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-lg bg-brand-100 font-display text-2xl font-semibold text-brand-700">
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

