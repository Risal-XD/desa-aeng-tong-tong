@extends('admin.layouts.app')

@section('title', 'UMKM')

@section('content')
    <x-admin.page-header title="UMKM" description="Kelola usaha mikro, kecil, dan menengah desa.">
        @can('create', App\Models\Umkm::class)
            <x-slot:actions>
                <a href="{{ route('admin.economy.umkms.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah UMKM
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Nama Usaha</th>
                        <th class="px-4 py-3">Pemilik</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Unggulan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($umkms as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-md bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($item->logo)
                                            <img src="{{ asset('storage/'.$item->logo) }}" alt="{{ $item->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($item->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <p class="font-medium text-ink-900">{{ $item->name }}</p>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->owner_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->category ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($item->is_featured)
                                    <span class="inline-flex rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-700">Unggulan</span>
                                @else
                                    <span class="text-xs text-ink-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.economy.umkms.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.economy.umkms.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-ink-500">
                                Belum ada data UMKM.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $umkms->links() }}
        </div>
    </x-admin.card>
@endsection
