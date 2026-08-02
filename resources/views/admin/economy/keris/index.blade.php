@extends('admin.layouts.app')

@section('title', 'Kerajinan Keris & Mpu')

@section('content')
    <x-admin.page-header title="Kerajinan Keris & Mpu" description="Kelola data para Mpu/empu keris desa.">
        @can('create', App\Models\KerisArtisan::class)
            <x-slot:actions>
                <a href="{{ route('admin.economy.keris.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah Mpu
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
                        <th class="px-4 py-3">Gelar</th>
                        <th class="px-4 py-3">Keahlian</th>
                        <th class="px-4 py-3">Pengalaman</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($artisans as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-full bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($item->photo)
                                            <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($item->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <p class="font-medium text-ink-900">{{ $item->name }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->title ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-600">
                                {{ $item->specialties ? implode(', ', $item->specialties) : '—' }}
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->experience_years ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.economy.keris.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.economy.keris.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-ink-500">
                                Belum ada data Mpu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $artisans->links() }}
        </div>
    </x-admin.card>
@endsection
