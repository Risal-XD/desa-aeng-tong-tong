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
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3" style="perspective: 1000px">
                    <template x-for="(item, index) in items" :key="index">
                        <button
                            type="button"
                            x-data="tiltCard"
                            @mousemove="tilt($event)"
                            @mouseleave="reset"
                            @click="open(index)"
                            :style="'transform: rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) scale(1.02); transform-style: preserve-3d; transition: transform 0.3s ease'"
                            class="group relative aspect-[16/10] w-full overflow-hidden rounded-2xl bg-brand-100 text-left shadow-sm"
                        >
                            <img x-show="item.image" :src="item.image" :alt="item.title" x-cloak class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div x-show="!item.image" x-cloak class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-brand-400 to-brand-700">
                                <span class="font-display text-6xl font-semibold text-white/90" x-text="item.first"></span>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-ink-950/80 via-ink-950/10 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-5">
                                <p class="text-[11px] font-semibold uppercase tracking-widest text-brand-300">Galeri Desa</p>
                                <h3 class="mt-1 font-display text-lg font-semibold text-white" x-text="item.title"></h3>
                                <span class="mt-3 inline-flex items-center gap-2 rounded-full bg-white/90 px-4 py-1.5 text-xs font-semibold text-ink-900 opacity-0 transition group-hover:opacity-100">
                                    Lihat Foto
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </span>
                            </div>
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
