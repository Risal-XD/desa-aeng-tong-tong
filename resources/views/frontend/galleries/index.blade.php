@extends('frontend.layouts.app')

@section('title', 'Galeri Foto')
@section('meta_description', 'Galeri foto kegiatan dan potensi Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="Galeri Foto"
        subtitle="Dokumentasi kegiatan dan keindahan Desa Aeng Tong-Tong."
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($galleries->isNotEmpty())
            @php
                $items = $galleries->map(fn ($item) => [
                    'title' => $item->title,
                    'image' => $item->image ? asset('storage/'.$item->image) : null,
                    'first' => mb_substr($item->title, 0, 1),
                ])->values();
            @endphp

            <div x-data="galleryLightbox(@js($items))">
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-4">
                    <template x-for="(item, index) in items" :key="index">
                        <button
                            type="button"
                            @click="open(index)"
                            class="group relative flex aspect-square items-center justify-center overflow-hidden rounded-2xl bg-brand-100"
                        >
                            <img x-show="item.image" :src="item.image" :alt="item.title" x-cloak class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            <span x-show="!item.image" x-cloak class="font-display text-2xl font-semibold text-brand-600" x-text="item.first"></span>
                            <span class="absolute inset-0 flex items-end bg-gradient-to-t from-ink-950/70 via-transparent to-transparent p-3 text-left opacity-0 transition group-hover:opacity-100">
                                <span class="text-xs font-semibold text-white" x-text="item.title"></span>
                            </span>
                        </button>
                    </template>
                </div>

                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>

                <div x-show="openIndex !== null" x-cloak x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-ink-950/90 p-4" @click="close">
                    <div @click.stop class="w-full max-w-3xl">
                        <template x-if="openIndex !== null">
                            <div>
                                <img
                                    x-show="current.image"
                                    :src="current.image"
                                    :alt="current.title"
                                    x-cloak
                                    class="max-h-[70vh] w-full rounded-2xl object-contain"
                                >
                                <p x-show="!current.image" x-cloak class="py-20 text-center font-display text-4xl font-semibold text-white" x-text="current.first"></p>
                            </div>
                        </template>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-sm font-semibold text-white" x-text="current.title"></p>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="prev" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">←</button>
                                <button type="button" @click="next" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">→</button>
                                <button type="button" @click="close" class="rounded-lg bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/20">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada foto galeri.</p>
            </div>
        @endif
    </section>
@endsection
