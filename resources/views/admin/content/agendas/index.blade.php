@extends('admin.layouts.app')

@section('title', 'Agenda')

@section('content')
    <x-admin.page-header title="Agenda" description="Kelola agenda dan kegiatan desa.">
        @can('create', App\Models\Agenda::class)
            <x-slot:actions>
                <a href="{{ route('admin.content.agendas.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah Agenda
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
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Jam</th>
                        <th class="px-4 py-3">Lokasi</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($agendas as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if ($item->is_featured)
                                        <span class="inline-flex rounded-full bg-brand-100 px-2 py-0.5 text-xs font-medium text-brand-700">Unggulan</span>
                                    @endif
                                    <p class="font-medium text-ink-900">{{ $item->title }}</p>
                                </div>
                                <p class="text-xs text-ink-500">Oleh: {{ $item->author?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->event_date->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-ink-600">
                                {{ $item->start_time?->format('H:i') }}–{{ $item->end_time?->format('H:i') }}
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->location ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.content.agendas.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.content.agendas.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-ink-500">
                                Belum ada agenda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $agendas->links() }}
        </div>
    </x-admin.card>
@endsection
