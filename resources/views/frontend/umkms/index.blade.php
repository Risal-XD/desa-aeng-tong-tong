@extends('frontend.layouts.app')

@section('title', 'UMKM')
@section('meta_description', 'Daftar UMKM dan usaha masyarakat Desa Aeng Tong-Tong.')

@section('content')
    <x-frontend.page-hero
        title="UMKM Desa"
        subtitle="Produk dan usaha unggulan masyarakat Desa Aeng Tong-Tong."
        :image="$heroImage"
        imagePosition="right center"
        backgroundSize="280%"
    />

    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        @if ($umkms->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($umkms as $item)
                    <a href="{{ route('umkms.show', $item) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-ink-200 bg-white shadow-sm transition hover:-translate-y-1 hover:border-brand-300 hover:shadow-lg">
                        <div class="relative flex h-40 items-center justify-center overflow-hidden bg-brand-100">
                            @if ($item->cover_image)
                                <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <span class="font-display text-4xl font-semibold text-brand-600">{{ mb_substr($item->name, 0, 1) }}</span>
                            @endif
                            @if ($item->is_featured)
                                <span class="absolute left-3 top-3 rounded-full bg-brand-500 px-2.5 py-1 text-[10px] font-semibold text-white">Unggulan</span>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            @if ($item->category)
                                <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $item->category }}</p>
                            @endif
                            <h2 class="mt-1 font-display text-base font-semibold text-ink-900 group-hover:text-brand-600">{{ $item->name }}</h2>
                            @if ($item->owner_name)
                                <p class="mt-1 text-xs text-ink-500">Pemilik: {{ $item->owner_name }}</p>
                            @endif
                            @if ($item->description)
                                <div class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-ink-500">
                                    {!! Str::limit(strip_tags((string) $item->description), 120) !!}
                                </div>
                            @endif
                            @if ($item->instagram)
                                <p class="mt-3 text-xs font-semibold text-brand-600">{{ $item->instagram }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $umkms->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-ink-200 bg-white p-10 text-center shadow-sm">
                <p class="text-sm text-ink-500">Belum ada data UMKM.</p>
            </div>
        @endif
    </section>
@endsection
