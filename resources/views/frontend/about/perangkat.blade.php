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
        @php
            $chiefGroup = collect($groups)->firstWhere('position', 'Kepala Desa');
            $chief = $chiefGroup['officials'][0] ?? null;

            // Data dummy perangkat desa jika data dari DB baru ada Kepala Desa
            $defaultPerangkatGroups = [
                [
                    'position' => 'Perangkat Desa',
                    'officials' => collect([
                        ['Abdus Siddik', 1],
                        ['Sadili', 2],
                        ['Fengki Andriadi', 3],
                        ['Hermanto', 4],
                        ['Masluki', 5],
                        ['Wafiqurrahman', 6],
                        ['Wawan Noviyanto', 7],
                        ['Moh Khudzaifi', 8],
                        ['Suhabib', 9],
                        ['Joko Harmanto', 11],
                        ['Junaidi', 12],
                        ['Sabda Rianto', 13],
                        ['Rahmaniyatun', 14],
                        ['Nanang Setiyadi', 15],
                        ['Sugianto', 16],
                        ['Perangkat Desa', 17],
                    ])->map(fn ($item) => (object)[
                        'name' => $item[0],
                        'position' => 'Perangkat Desa',
                        'email' => null,
                        'phone' => null,
                        'photo' => sprintf('foto/aparat desa/%02d.jpg', $item[1]),
                    ])->all(),
                ]
            ];

            $perangkatGroup = collect($groups)->firstWhere('position', 'Perangkat Desa');
            $displayGroups = !empty($perangkatGroup['officials'])
                ? collect([$perangkatGroup])
                : collect($defaultPerangkatGroups);
        @endphp

        {{-- Section Kepala Desa --}}
        <h2 class="mb-6 font-display text-2xl font-semibold text-ink-900 uppercase">Kepala Desa</h2>
        <div class="flex flex-col lg:flex-row bg-white rounded-2xl shadow-sm overflow-hidden mb-20">
            <div class="w-full lg:w-2/5 flex-shrink-0">
                @if ($chief && $chief->photo)
                    <img src="{{ asset('storage/'.$chief->photo) }}" alt="{{ $chief->name }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('foto/Kades.jpeg') }}" alt="Kades" class="w-full h-full object-cover">
                @endif
            </div>
            <div class="flex-1 p-8 lg:p-10">
                <h3 class="text-3xl font-bold text-ink-900 uppercase">{{ mb_strtoupper($chief->name ?? 'HADI SUDIRFAN, S.PD.I') }}</h3>
                <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-brand-600">{{ mb_strtoupper($chief->position ?? 'KEPALA DESA') }} {{ mb_strtoupper($village->name ?? 'AENG TONG-TONG') }}</p>
                <p class="mt-4 text-ink-900 text-justify">Sebagai Kepala Desa {{ $village->name ?? '' }}, beliau memiliki peran dalam memimpin penyelenggaraan pemerintahan desa, pemberdayaan masyarakat, serta pengembangan potensi desa sebagai desa wisata berbasis budaya dan kerajinan keris.</p>
                <hr class="my-8 border-ink-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Nama Lengkap</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">{{ mb_strtoupper($chief->name ?? 'HADI SUDIRFAN, S.PD.I') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Jabatan</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">{{ mb_strtoupper($chief->position ?? 'KEPALA DESA') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Desa</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">{{ mb_strtoupper($village->name ?? 'AENG TONG-TONG') }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Periode</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">{{ $chief->period ?? '2020 - 2026' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section Perangkat Desa --}}
        @foreach ($displayGroups as $group)
            @php 
                $groupName = is_array($group) ? $group['position'] : $group->position;
                $officials = is_array($group) ? $group['officials'] : $group->officials;
            @endphp
            <div class="mb-10" data-aos="fade-up">
                <h2 class="mb-8 border-b border-ink-200 pb-4 font-display text-2xl font-semibold text-ink-900">
                    {{ $groupName }}
                </h2>

                <div class="marquee-row-viewport py-2">
                    <div class="marquee-row-track marquee-row-seq">
                        @for ($i = 0; $i < 2; $i++)
                            @foreach ($officials as $official)
                                <div class="group w-56 flex-shrink-0 overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg sm:w-64">
                                    <div class="aspect-[3/4] w-full overflow-hidden bg-gray-100">
                                        @if (isset($official->photo) && $official->photo)
                                            <img src="{{ str_starts_with($official->photo, 'foto/') ? asset($official->photo) : asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="h-full w-full object-cover">
                                        @else
                                            <img src="{{ asset('foto/Kades.jpeg') }}" alt="{{ $official->name }}" class="h-full w-full object-cover opacity-90">
                                        @endif
                                    </div>
                                    <div class="p-5 text-center">
                                        <h3 class="text-lg font-bold text-ink-900">{{ $official->name }}</h3>
                                        <p class="mt-1 text-xs font-bold uppercase tracking-widest text-brand-600">{{ $official->position }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @endfor
                    </div>
                </div>
            </div>
        @endforeach
    </section>

    {{-- Lokasi Desa Section --}}
    <section class="mx-auto max-w-6xl px-4 pt-4 pb-32 sm:px-6 mb-24" data-aos="fade-up">
        <h2 class="mb-6 font-display text-2xl font-semibold text-ink-900 uppercase">Lokasi Desa</h2>
        <div class="h-[650px] w-full rounded-2xl overflow-hidden shadow-xl border border-ink-200">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3950.740211018331!2d113.7923879!3d-7.0836785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd9e0f1c0000001%3A0xb87b864f563299d8!2sBalai%20Desa%20Aeng%20Tong-Tong!5e0!3m2!1sid!2sid!4v1723199999999"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
            ></iframe>
        </div>
    </section>
@endsection

