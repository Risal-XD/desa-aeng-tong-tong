@props(['title', 'subtitle' => null, 'align' => 'left'])

<div class="mb-10 {{ $align === 'center' ? 'text-center' : '' }}">
    <p class="mb-2 inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-brand-600">
        <span class="h-px w-8 bg-brand-500"></span>
        {{ $eyebrow ?? 'Profil Desa' }}
        <span class="h-px w-8 bg-brand-500"></span>
    </p>
    <h2 class="font-display text-2xl font-semibold text-ink-900 sm:text-3xl">{{ $title }}</h2>
    @if ($subtitle)
        <p class="mt-3 max-w-2xl text-sm leading-relaxed text-ink-500 {{ $align === 'center' ? 'mx-auto' : '' }}">{{ $subtitle }}</p>
    @endif
</div>
