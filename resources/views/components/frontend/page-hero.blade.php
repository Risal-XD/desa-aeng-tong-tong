@props(['title', 'subtitle' => null, 'image' => null, 'imagePosition' => 'center', 'backgroundSize' => 'cover'])

@php
    $imageUrl = $image ? (str_starts_with($image, 'images/') ? asset($image) : asset('storage/'.$image)) : null;
@endphp

<section class="relative overflow-hidden" :style="image ? `background-image: url('{{ $imageUrl }}'); background-size: {{ $backgroundSize }}; background-position: {{ $imagePosition }};` : ''">
    @if ($image)
        <img src="{{ $imageUrl }}" alt="{{ $title }}" class="absolute inset-0 h-full w-full object-cover" style="object-position: {{ $imagePosition }};" />
    @else
        <div class="absolute inset-0 bg-ink-950"></div>
    @endif
    
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-primary via-primary/70 to-primary/10"></div>
    @if ($image)
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-primary/90 via-primary/30 to-transparent"></div>
    @endif
    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,rgba(212,138,30,0.25),transparent_60%)]"></div>
    
    <div class="relative mx-auto max-w-6xl px-4 py-14 sm:px-6 sm:py-16">
        <nav class="mb-3 flex items-center gap-1.5 text-xs text-ink-400" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-brand-400">Beranda</a>
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
            <span class="text-ink-200">{{ $title }}</span>
        </nav>
        <h1 class="font-display text-3xl font-semibold text-white sm:text-4xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-ink-300">{{ $subtitle }}</p>
        @endif
    </div>
</section>
