@props(['title', 'description' => null, 'actions' => null])

<div class="mb-6 flex flex-wrap items-start justify-between gap-4">
    <div>
        <h1 class="text-2xl font-bold text-ink-900">{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-ink-500">{{ $description }}</p>
        @endif
    </div>
    @if ($actions)
        <div class="flex items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
