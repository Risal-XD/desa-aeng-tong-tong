@props(['name', 'label' => null, 'value' => null, 'accept' => 'image/*', 'hint' => null, 'preview' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-ink-700">
            {{ $label }}
        </label>
    @endif

    <div x-data="{ preview: @js($preview) }" class="flex items-start gap-4">
        <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-ink-200 bg-ink-50">
            <template x-if="preview">
                <img :src="preview" alt="Pratinjau" class="h-full w-full object-cover">
            </template>
            <template x-if="!preview">
                <span class="text-xs text-ink-400">Belum ada</span>
            </template>
        </div>
        <div class="flex-1">
            <input
                id="{{ $name }}"
                type="file"
                name="{{ $name }}"
                accept="{{ $accept }}"
                class="w-full text-sm text-ink-700 file:mr-3 file:rounded-md file:border-0 file:bg-brand-50 file:px-3 file:py-2 file:text-sm file:font-medium file:text-brand-700 hover:file:bg-brand-100"
                @change="preview = URL.createObjectURL($event.target.files[0])"
            >
            @if ($hint)
                <p class="mt-1 text-xs text-ink-500">{{ $hint }}</p>
            @endif
        </div>
    </div>

    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
