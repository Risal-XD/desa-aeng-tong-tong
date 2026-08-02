@extends('admin.layouts.app')

@section('title', 'APBDes')

@section('content')
    <x-admin.page-header title="APBDes" description="Kelola anggaran pendapatan, belanja, dan pembiayaan desa.">
        @can('create', App\Models\Apbdes::class)
            <x-slot:actions>
                <a href="{{ route('admin.data-report.apbdes.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah Pos APBDes
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Nama Pos</th>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Jenis</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3 text-right">Anggaran</th>
                        <th class="px-4 py-3 text-right">Realisasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($items as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium text-ink-900">{{ $item->name }}</p>
                                <p class="text-xs text-ink-500">Oleh: {{ $item->author?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->year }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->type === \App\Enums\ApbdesType::INCOME ? 'bg-emerald-100 text-emerald-700' : ($item->type === \App\Enums\ApbdesType::EXPENSE ? 'bg-amber-100 text-amber-700' : 'bg-sky-100 text-sky-700') }}">
                                    {{ $item->type->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-right text-ink-600">Rp {{ number_format($item->budget_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-ink-600">Rp {{ number_format($item->realization_amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.data-report.apbdes.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.data-report.apbdes.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-10 text-center text-ink-500">
                                Belum ada data APBDes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $items->links() }}
        </div>
    </x-admin.card>
@endsection
