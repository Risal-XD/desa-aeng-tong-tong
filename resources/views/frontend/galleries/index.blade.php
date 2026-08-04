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
                    'description' => $item->description,
                    'image' => $item->image ? asset('storage/'.$item->image) : null,
                    'first' => mb_substr($item->title, 0, 1),
                ])->values();
            @endphp

            <div x-data="stackingGallery(@js($items))">
                <template x-for="(item, index) in items" :key="index">
                    <div data-stack-card class="flex h-screen w-full items-center justify-center sticky top-0">
                        <button
                            type="button"
                            @click="open(index)"
                            :style="`background-color: ${accentFor(index)}; top: calc(-5vh + ${index * 25}px); transform: scale(${scaleFor(index)});`"
                            class="relative -top-[25%] flex h-[450px] w-[70%] origin-top flex-col overflow-hidden rounded-2xl p-4 text-left text-white shadow-2xl transition-transform lg:p-10 sm:p-4"
                        >
                            <h2 class="text-center font-display text-2xl font-semibold" x-text="item.title"></h2>
                            <div class="mt-5 flex h-full gap-10">
                                <div class="relative top-[10%] hidden w-[40%] md:block">
                                    <p class="text-sm leading-relaxed text-white/90" x-text="item.description"></p>
                                    <span class="mt-3 inline-flex items-center gap-2 text-sm font-semibold underline underline-offset-4">
                                        Lihat Foto
                                        <svg width="22" height="12" viewBox="0 0 22 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.5303 6.53033C21.8232 6.23744 21.8232 5.76256 21.5303 5.46967L16.7574 0.696699C16.4645 0.403806 15.9896 0.403806 15.6967 0.696699C15.4038 0.989592 15.4038 1.46447 15.6967 1.75736L19.9393 6L15.6967 10.2426C15.4038 10.5355 15.4038 11.0104 15.6967 11.3033C15.9896 11.5962 16.4645 11.5962 16.7574 11.3033L21.5303 6.53033ZM0 6.75L21 6.75V5.25L0 5.25L0 6.75Z" fill="white"/>
                                        </svg>
                                    </span>
                                </div>
                                <div class="relative h-full w-full overflow-hidden rounded-lg md:w-[60%]">
                                    <div class="h-full w-full" :style="`transform: scale(${imageScales[index]})`">
                                        <img x-show="item.image" :src="item.image" :alt="item.title" x-cloak class="h-full w-full object-cover">
                                        <div x-show="!item.image" x-cloak class="flex h-full w-full items-center justify-center bg-gradient-to-br from-white/20 to-white/5">
                                            <span class="font-display text-6xl font-semibold text-white/90" x-text="item.first"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </button>
                    </div>
                </template>

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
