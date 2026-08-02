@extends('admin.layouts.app')

@section('title', 'Potensi Desa')

@section('content')
    <x-admin.page-header
        title="Potensi Desa"
        description="Kelola potensi wisata, kerajinan, UMKM, dan lainnya."
    >
        @can('create', App\Models\VillagePotential::class)
            <x-slot:actions>
                <a
                    href="{{ route('admin.profile.potentials.create') }}"
                    class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600"
                >
                    + Tambah Potensi
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Judul</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Unggulan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($potentials as $potential)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-md bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($potential->image)
                                            <img src="{{ asset('storage/'.$potential->image) }}" alt="{{ $potential->title }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($potential->title, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $potential->title }}</p>
                                        <p class="text-xs text-ink-500">Oleh: {{ $potential->author?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $potential->category ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($potential->is_featured)
                                    <span class="inline-flex rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-700">Unggulan</span>
                                @else
                                    <span class="text-xs text-ink-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $potential->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $potential->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.profile.potentials.edit', $potential) }}"
                                        class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50"
                                    >
                                        Edit
                                    </a>
                                    @can('delete', $potential)
                                        <x-admin.delete-form
                                            :action="route('admin.profile.potentials.destroy', $potential)"
                                            label="Hapus"
                                        />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada potensi desa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $potentials->links() }}
        </div>
    </x-admin.card>
@endsection
