@props(['action', 'label' => 'Hapus', 'message' => 'Data akan dihapus permanen dan tidak dapat dikembalikan.'])

<form method="POST" action="{{ $action }}" x-data="{
    confirmDelete(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: @js($message),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }
}">
    @csrf
    @method('DELETE')

    <button
        type="button"
        @click="confirmDelete"
        {{ $attributes->merge(['class' => 'rounded-md border border-red-200 bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-100']) }}
    >
        {{ $label }}
    </button>
</form>
