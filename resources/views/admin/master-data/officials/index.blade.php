@extends('admin.layouts.app')

@section('title', 'Perangkat Desa')

@section('content')
    <x-admin.page-header
        title="Perangkat Desa"
        description="Kelola daftar perangkat dan aparat desa."
    >
        @can('create', App\Models\VillageOfficial::class)
            <x-slot:actions>
                <a
                    href="{{ route('admin.master-data.officials.create') }}"
                    class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600"
                >
                    + Tambah Perangkat
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jabatan</th>
                        <th class="px-4 py-3">Struktur</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($officials as $official)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-full bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($official->photo)
                                            <img src="{{ asset('storage/'.$official->photo) }}" alt="{{ $official->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($official->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $official->name }}</p>
                                        @if ($official->nip)
                                            <p class="text-xs text-ink-500">NIP: {{ $official->nip }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $official->position }}</td>
                            <td class="px-4 py-3 text-ink-600">{{ $official->structure?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-600">
                                @if ($official->phone)
                                    <span class="block text-xs">{{ $official->phone }}</span>
                                @endif
                                @if ($official->email)
                                    <span class="block text-xs text-ink-400">{{ $official->email }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $official->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $official->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.master-data.officials.edit', $official) }}"
                                        class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50"
                                    >
                                        Edit
                                    </a>
                                    @can('delete', $official)
                                        <x-admin.delete-form
                                            :action="route('admin.master-data.officials.destroy', $official)"
                                            label="Hapus"
                                        />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-ink-500">
                                Belum ada perangkat desa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $officials->links() }}
        </div>
    </x-admin.card>
@endsection
