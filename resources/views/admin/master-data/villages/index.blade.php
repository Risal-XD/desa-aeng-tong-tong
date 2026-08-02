@extends('admin.layouts.app')

@section('title', 'Data Desa')

@section('content')
    <x-admin.page-header
        title="Data Desa"
        description="Kelola identitas dan informasi umum Desa Aeng Tong-Tong."
    >
        @can('create', App\Models\Village::class)
            <x-slot:actions>
                <a
                    href="{{ route('admin.master-data.villages.create') }}"
                    class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600"
                >
                    + Tambah Desa
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Nama Desa</th>
                        <th class="px-4 py-3">Wilayah</th>
                        <th class="px-4 py-3">Dusun</th>
                        <th class="px-4 py-3">Potensi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($villages as $village)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-md bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($village->logo)
                                            <img src="{{ asset('storage/'.$village->logo) }}" alt="{{ $village->name }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($village->name, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $village->name }}</p>
                                        <p class="text-xs text-ink-500">Kode: {{ $village->code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">
                                {{ $village->district }}, {{ $village->regency }}
                                <span class="block text-xs text-ink-400">{{ $village->province }}</span>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $village->total_hamlet }}</td>
                            <td class="px-4 py-3 text-ink-600">{{ $village->potentials_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.master-data.villages.edit', $village) }}"
                                        class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50"
                                    >
                                        Edit
                                    </a>
                                    @can('delete', $village)
                                        <x-admin.delete-form
                                            :action="route('admin.master-data.villages.destroy', $village)"
                                            label="Hapus"
                                        />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada data desa. Klik "Tambah Desa" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $villages->links() }}
        </div>
    </x-admin.card>
@endsection
