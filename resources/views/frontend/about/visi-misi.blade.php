@extends('frontend.layouts.app')

@section('title', 'Visi & Misi')
@section('meta_description', 'Visi dan misi pembangunan Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Visi & Misi"
        subtitle="Arah dan tujuan pembangunan Desa Aeng Tong-Tong."
        :image="$heroImage"
        imagePosition="right center"
        backgroundSize="280%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($village && ($village->visions->isNotEmpty() || $village->missions->isNotEmpty()))
            <div class="grid gap-10 lg:grid-cols-5">
                <div class="lg:col-span-2">
                    <div class="rounded-2xl border border-brand-200 bg-brand-50 p-8">
                        <p class="text-xs font-semibold uppercase tracking-widest text-brand-700">Visi</p>
                        @if ($village->visions->isNotEmpty())
                            <blockquote class="mt-4 font-display text-xl font-medium leading-relaxed text-ink-900">
                                “{{ $village->visions->first()->vision }}”
                            </blockquote>
                        @else
                            <p class="mt-4 text-sm text-ink-500">Visi belum ditetapkan.</p>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <h2 class="mb-6 font-display text-2xl font-semibold text-ink-900">Misi</h2>
                    @if ($village->missions->isNotEmpty())
                        <ol class="space-y-4">
                            @foreach ($village->missions as $index => $mission)
                                <li class="flex gap-4 rounded-2xl border border-ink-200 bg-white p-5 shadow-sm">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-500 text-sm font-semibold text-white">{{ $index + 1 }}</span>
                                    <p class="pt-1.5 text-sm leading-relaxed text-ink-600">{{ $mission->mission }}</p>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-sm text-ink-500">Misi belum ditetapkan.</p>
                    @endif
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Visi &amp; misi desa belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection
