@extends('admin.layouts.app')

@section('title', 'E-Booklet')

@section('content')
    <x-admin.page-header
        title="E-Booklet"
        description="Kelola sampul dan file PDF e-booklet yang ditampilkan di halaman publik."
    >
        <x-slot name="actions">
            @if (Route::has('ebooklet'))
                <a
                    href="{{ route('ebooklet') }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 rounded-lg border border-brand-200 bg-white px-4 py-2 text-sm font-semibold text-brand-700 transition hover:bg-brand-50"
                >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                    </svg>
                    Buka Halaman E-Booklet
                </a>
            @endif
        </x-slot>
    </x-admin.page-header>

    <form method="POST" action="{{ route('admin.data-report.ebooklet.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-admin.card title="Sampul E-Booklet">
            <x-admin.file-input
                name="ebooklet_cover"
                label="Gambar Sampul"
                accept="image/*"
                hint="PNG/JPG/WebP rasio 3:4, maks. 8 MB — akan dijadikan sampul buku 3D di halaman e-booklet."
                :preview="$ebookletCover ? asset('storage/'.$ebookletCover) : null"
            />
            @if (! $ebookletCover)
                <p class="mt-2 text-xs text-amber-600">
                    Sampul belum diunggah. Halaman e-booklet akan menampilkan placeholder hingga sampul tersedia.
                </p>
            @endif
        </x-admin.card>

        <div class="mt-4">
            <x-admin.card title="File PDF E-Booklet">
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-24 w-24 shrink-0 items-center justify-center rounded-lg border border-ink-200 bg-ink-50 text-ink-400"
                    >
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        @if ($ebookletPdf)
                            <p class="text-sm text-ink-700">
                                File terpasang:
                                <a
                                    href="{{ asset('storage/'.$ebookletPdf) }}"
                                    target="_blank"
                                    class="font-medium text-brand-600 underline hover:text-brand-700"
                                >
                                    {{ basename($ebookletPdf) }}
                                </a>
                            </p>
                        @else
                            <p class="text-sm text-amber-600">
                                Belum ada file PDF. Unggah untuk mengaktifkan viewer baca/dibalik.
                            </p>
                        @endif
                        <input
                            id="ebooklet_pdf"
                            type="file"
                            name="ebooklet_pdf"
                            accept=".pdf,application/pdf"
                            class="mt-3 w-full text-sm text-ink-700 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100"
                        >
                        <p class="mt-1 text-xs text-ink-500">PDF, maks. 60 MB.</p>
                        @error('ebooklet_pdf')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-admin.card>
        </div>

        <div class="mt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                Simpan E-Booklet
            </button>
        </div>
    </form>
@endsection