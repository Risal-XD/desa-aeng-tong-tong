@if (session('success'))
    <div x-data x-init="$nextTick(() => Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @js(session('success')),
        timer: 3000,
        showConfirmButton: false,
        timerProgressBar: true,
    }))"></div>
@endif

@if (session('error'))
    <div x-data x-init="$nextTick(() => Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: @js(session('error')),
        showConfirmButton: true,
    }))"></div>
@endif
