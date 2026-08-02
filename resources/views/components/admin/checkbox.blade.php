@props(['name', 'label' => null, 'checked' => false, 'value' => '1'])

<label class="flex items-center gap-2 text-sm text-ink-700">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        @if ((bool) old($name, $checked)) checked @endif
        {{ $attributes->merge(['class' => 'h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500']) }}
    >
    @if ($label)
        <span>{{ $label }}</span>
    @endif
</label>

@error($name)
    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
@enderror
