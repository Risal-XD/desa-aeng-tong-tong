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
                    'officials' => [
                        (object)['name' => 'Achmad Fauzi', 'position' => 'SEKRETARIS DESA', 'email' => 'a.fauzi@desa.id', 'phone' => '+62 812-0001', 'photo' => null],
                        (object)['name' => 'Siti Aminah', 'position' => 'KAUR KEUANGAN', 'email' => 's.aminah@desa.id', 'phone' => '+62 812-0002', 'photo' => null],
                        (object)['name' => 'Bambang S.', 'position' => 'KAUR PERENCANAAN', 'email' => 'bambang.s@desa.id', 'phone' => '+62 812-0003', 'photo' => null],
                    ]
                ]
            ];

            $otherGroups = collect($groups)->filter(fn($g) => $g['position'] !== 'Kepala Desa');
            $displayGroups = $otherGroups->isNotEmpty() ? $otherGroups : $defaultPerangkatGroups;
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
                <h3 class="text-3xl font-bold text-ink-900 uppercase">HADI SUDIRFAN, S.PD.I</h3>
                <p class="mt-1 text-sm font-semibold uppercase tracking-wide text-brand-600">KEPALA DESA {{ mb_strtoupper($village->name ?? 'AENG TONG-TONG') }}</p>
                <p class="mt-4 text-ink-900 text-justify">Sebagai Kepala Desa {{ $village->name ?? '' }}, beliau memiliki peran dalam memimpin penyelenggaraan pemerintahan desa, pemberdayaan masyarakat, serta pengembangan potensi desa sebagai desa wisata berbasis budaya dan kerajinan keris.</p>
                <hr class="my-8 border-ink-200">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Nama Lengkap</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">HADI SUDIRFAN, S.PD.I</p>
                    </div>
                    <div>
                        <label class="text-xs font-bold uppercase tracking-widest text-ink-500">Jabatan</label>
                        <p class="text-lg font-bold text-ink-900 uppercase">KEPALA DESA</p>
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
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($officials as $official)
                        <div class="group rounded-2xl border border-ink-200 bg-white overflow-hidden shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                            <div class="aspect-[3/4] w-full bg-gray-100 overflow-hidden">
                                @if (isset($official->photo) && $official->photo)
                                    <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="h-full w-full object-cover">
                                @else
                                    <img src="{{ asset('foto/Kades.jpeg') }}" alt="{{ $official->name }}" class="h-full w-full object-cover opacity-90">
                                @endif
                            </div>
                            <div class="p-6 text-center">
                                <h3 class="text-lg font-bold text-ink-900">{{ $official->name }}</h3>
                                <p class="mt-1 text-xs font-bold uppercase tracking-widest text-brand-600">{{ $official->position }}</p>
                                <hr class="my-5 border-ink-100">
                                <div class="space-y-2 text-xs text-ink-500">
                                    @if(isset($official->email) && $official->email)
                                        <p class="flex items-center justify-center gap-2">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                                            <span>{{ $official->email }}</span>
                                        </p>
                                    @endif
                                    @if(isset($official->phone) && $official->phone)
                                        <p class="flex items-center justify-center gap-2">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                            <span>{{ $official->phone }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

    {{-- Lokasi Desa Section --}}
    <section class="mx-auto max-w-6xl px-4 pt-4 pb-48 sm:px-6 mb-16" data-aos="fade-up">
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

