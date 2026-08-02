@extends('frontend.layouts.app')

@section('title', 'Struktur Organisasi')
@section('meta_description', 'Struktur organisasi Pemerintah Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Struktur Organisasi"
        subtitle="Bagan struktur pemerintahan Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($structureTree->isNotEmpty())
            <div class="space-y-10">
                @foreach ($structureTree as $root)
                    <div class="rounded-3xl border border-ink-200 bg-white p-6 shadow-sm sm:p-10">
                        <div class="flex flex-col items-center text-center">
                            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-ink-950 text-white">
                                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </span>
                            <h2 class="mt-4 font-display text-xl font-semibold text-ink-900">{{ $root->position }}</h2>
                            <p class="mt-1 text-sm text-ink-500">{{ $root->name }}</p>
                            @if ($root->description)
                                <p class="mt-3 max-w-lg text-sm leading-relaxed text-ink-500">{{ $root->description }}</p>
                            @endif
                        </div>

                        @if ($root->children->isNotEmpty())
                            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($root->children as $child)
                                    <div class="rounded-2xl border border-ink-200 bg-ink-50 p-5 text-center">
                                        <p class="font-semibold text-ink-900">{{ $child->position }}</p>
                                        <p class="mt-1 text-xs text-ink-500">{{ $child->name }}</p>
                                        @if ($child->children->isNotEmpty())
                                            <ul class="mt-4 space-y-2 border-t border-ink-200 pt-4 text-left">
                                                @foreach ($child->children as $grandchild)
                                                    <li class="text-sm text-ink-600">
                                                        <span class="mr-1 text-brand-500">•</span>{{ $grandchild->position }}
                                                        <span class="block pl-3 text-xs text-ink-400">{{ $grandchild->name }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Data struktur organisasi belum tersedia.</p>
            </div>
        @endif
    </section>
@endsection
