@extends('admin.layouts.app')

@section('title', 'Kelola Role: ' . $role->name)

@section('content')
    <x-admin.page-header :title="'Kelola Role: '.$role->name" description="Atur nama role dan pilih permission yang dapat diakses." />

    <form method="POST" action="{{ route('admin.system.roles.update', $role) }}">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Role">
            <div class="grid gap-4 sm:grid-cols-2">
                <x-admin.input name="name" label="Nama Role" :value="$role->name" required />
                <x-admin.input name="slug" label="Slug" :value="$role->slug" hint="Hanya huruf kecil, angka, dan tanda hubung." required />
            </div>
        </x-admin.card>

        <div class="mt-4">
            <x-admin.card title="Permission">
                @php
                    $actionColumns = ['view' => 'Lihat', 'create' => 'Buat', 'edit' => 'Ubah', 'delete' => 'Hapus'];
                @endphp
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-ink-200 text-sm">
                        <thead>
                            <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                                <th class="px-4 py-3">Modul</th>
                                @foreach ($actionColumns as $action)
                                    <th class="px-4 py-3 text-center">{{ $action }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ink-100">
                            @forelse ($matrix as $group => $actions)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-ink-800">{{ $group }}</td>
                                    @foreach ($actionColumns as $action => $label)
                                        <td class="px-4 py-2 text-center">
                                            @if (isset($actions[$action]))
                                                <input
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $actions[$action] }}"
                                                    @checked(in_array($actions[$action], $rolePermissions, true))
                                                    class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500"
                                                >
                                            @else
                                                <span class="text-ink-300">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-10 text-center text-ink-500">Belum ada permission.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-xs text-ink-500">
                    Centang kotak sesuai hak akses yang dimiliki role. Kosongkan untuk mencabut izin.
                </p>
                @error('permissions')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </x-admin.card>
        </div>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.system.roles.index') }}" class="rounded-lg border border-ink-300 px-5 py-2.5 text-sm font-semibold text-ink-700 transition hover:bg-ink-50">
                Batal
            </a>
        </div>
    </form>
@endsection
