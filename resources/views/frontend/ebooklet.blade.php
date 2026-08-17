@extends('frontend.layouts.app')

@section('title', 'E-Booklet')
@section('meta_description', 'E-Booklet Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="E-Booklet"
        subtitle="Jelajahi informasi dan potensi Desa Aeng Tong-Tong dalam satu booklet digital."
    />

    @php
        use App\Services\SettingService;
        $settings = app(SettingService::class);
        $ebookletCover = $settings->get('ebooklet_cover');
        $ebookletPdf = $settings->get('ebooklet_pdf');
    @endphp

    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 sm:py-10">
        <div class="flex items-start gap-6 overflow-x-auto" style="max-width: 896px; margin-left: auto; margin-right: auto;">
            <div class="shrink-0" style="margin-top: 88px;">
                <button
                    type="button"
                    class="book-root group cursor-pointer"
                    style="--book-color: #1b4332; --book-depth: 18px; --book-width: 176px; background: none; border: 0; padding: 0;"
                    @click="$dispatch('open-ebooklet')"
                    aria-label="Buka E-Booklet"
                >
                    <div class="book-inner">
                        <div class="book-cover">
                            @if ($ebookletCover)
                                <img src="{{ asset('storage/'.$ebookletCover) }}" alt="Sampul E-Booklet Desa Aeng Tong-Tong" class="absolute inset-0 h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-[#1b4332] p-4">
                                    <span class="text-center text-[10px] font-semibold uppercase tracking-[0.3em] text-white/70">E-Booklet</span>
                                </div>
                            @endif
                            <div class="book-bind"></div>
                        </div>
                        <div class="book-pages"></div>
                        <div class="book-back"></div>
                    </div>
                </button>
            </div>

            <div id="booklet" class="min-w-0 flex-1">
                <div class="flex flex-col gap-4 border-b border-outline-variant/40 pb-5 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="font-display text-xl font-bold text-primary sm:text-2xl">E-Booklet Desa Aeng Tong-Tong</h2>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full bg-secondary-container/50 px-3 py-1 text-[10px] font-semibold text-on-secondary-container">Budaya</span>
                            <span class="rounded-full bg-secondary-container/50 px-3 py-1 text-[10px] font-semibold text-on-secondary-container">Sejarah</span>
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex items-start gap-4">
                    <div class="flex-1 space-y-4 text-sm leading-relaxed text-justify text-on-surface-variant">
                    <p>
                        Dokumen komprehensif ini merangkum esensi dari Desa Aeng Tong-Tong, sebuah permata budaya yang tersimpan. Di dalamnya, Anda akan menemukan penelusuran mendalam mengenai sejarah awal desa, perkembangan tradisi pembuatan keris yang telah diwariskan secara turun-temurun, serta gambaran nyata mengenai potensi pariwisata edukasi yang ditawarkan.
                    </p>
                    <p>
                        Dirancang dengan estetika minimalis namun kaya akan informasi, e-booklet ini berfungsi tidak hanya sebagai panduan wisata, tetapi juga sebagai arsip digital pelestarian budaya lokal. Cocok bagi para akademisi, sejarawan, maupun wisatawan yang mencari pengalaman autentik.
                    </p>
                    </div>
                    @if ($ebookletPdf)
                        <a href="{{ route('ebooklet.pdf', [], false) }}" target="_blank" rel="noopener" class="inline-flex shrink-0 items-center justify-center gap-1.5 rounded-full bg-primary px-3 py-2 text-[10px] font-semibold text-on-primary transition hover:bg-primary-container">
                            <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v12"/><path d="m7 10 5 5 5-5"/><path d="M5 21h14"/></svg>
                            Download PDF
                        </a>
                    @endif
                </div>

                <div class="mt-6 flex flex-wrap gap-x-5 gap-y-3 border-t border-outline-variant/30 pt-5 text-[10px] font-medium text-on-surface-variant">
                    <button type="button" class="inline-flex items-center gap-2 text-left transition hover:text-primary" @click="$dispatch('open-ebooklet')">
                        <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Baca Online — Klik Buku di Samping
                    </button>
                    <span class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h6"/></svg>
                        Format: PDF
                    </span>
                </div>
            </div>
        </div>
    </section>

    <div
        x-data="{
            open: false,
            images: {{ Js::from(collect(range(1, 52))->map(fn($i) => asset('buku/buku pamor_page-'.str_pad($i, 4, '0', STR_PAD_LEFT).'.jpg'))) }},
            pageFlip: null,
            currentPage: 1,
            totalPages: 52,
            init() {},
            openViewer() {
                this.open = true;
                this.$nextTick(() => {
                    const el = this.$refs.book;
                    if (!this.pageFlip) {
                        this.pageFlip = new PageFlip(el, {
                            width: 550,
                            height: 780,
                            size: 'stretch',
                            minWidth: 315,
                            maxWidth: 1000,
                            minHeight: 420,
                            maxHeight: 1350,
                            maxShadowOpacity: 0.5,
                            showCover: false,
                            flippingTime: 650,
                            mobileScrollSupport: true,
                        });
                        this.pageFlip.loadFromImages(this.images);
                        this.pageFlip.on('flip', (e) => {
                            this.currentPage = e.data + 1;
                        });
                    }
                });
            },
            closeViewer() {
                this.open = false;
                if (this.pageFlip) {
                    this.pageFlip.destroy();
                    this.pageFlip = null;
                }
            },
            nextPage() { if (this.pageFlip) this.pageFlip.flipNext(); },
            prevPage() { if (this.pageFlip) this.pageFlip.flipPrev(); }
        }"
        @open-ebooklet.window="openViewer()"
    >
        <template x-if="open">
            <div class="ebooklet-overlay" @keydown.escape.window="closeViewer()" @click.self="closeViewer()" x-cloak>
                <button type="button" class="ebooklet-close" @click="closeViewer()" aria-label="Tutup e-booklet">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
                <div class="ebooklet-modal">
                    <div class="ebooklet-stage">
                        <button type="button" class="ebooklet-side-button ebooklet-side-button-left" @click="prevPage()" aria-label="Halaman sebelumnya">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <div x-ref="book" class="stf__parent"></div>
                        <button type="button" class="ebooklet-side-button ebooklet-side-button-right" @click="nextPage()" aria-label="Halaman berikutnya">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m9 6 6 6-6 6"/></svg>
                        </button>
                    </div>
                    <div class="ebooklet-toolbar" aria-label="Kontrol e-booklet">
                        <button type="button" class="btn" @click="prevPage()" aria-label="Halaman sebelumnya">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <span class="count" x-text="currentPage + '/' + totalPages"></span>
                        <button type="button" class="btn" @click="nextPage()" aria-label="Halaman berikutnya">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="m9 6 6 6-6 6"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
@endsection
