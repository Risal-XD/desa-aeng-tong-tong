@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-ink-200 bg-white shadow-sm']) }}>
    @if ($title)
        <div class="border-b border-ink-200 px-4 py-3">
            <h3 class="text-sm font-semibold text-ink-900">{{ $title }}</h3>
        </div>
    @endif

    <div class="p-4 sm:p-5">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="border-t border-ink-200 bg-ink-50 px-4 py-3">
            {{ $footer }}
        </div>
    @endif
</div>
