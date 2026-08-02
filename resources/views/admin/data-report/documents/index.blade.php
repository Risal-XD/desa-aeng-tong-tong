@extends('admin.layouts.app')

@section('title', 'Dokumen')

@section('content')
    <x-admin.page-header title="Dokumen" description="Kelola dokumen publik yang dapat diunduh masyarakat.">
        @can('create', App\Models\Document::class)
            <x-slot:actions>
                <a href="{{ route('admin.data-report.documents.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Unggah Dokumen
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Dokumen</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Ukuran</th>
                        <th class="px-4 py-3 text-center">Unduhan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($documents as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-md bg-brand-100 text-xs font-bold text-brand-800">
                                        PDF
                                    </div>
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $item->title }}</p>
                                        <p class="text-xs text-ink-500">Oleh: {{ $item->author?->name ?? '-' }} · {{ $item->file_name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->file_size ?? '—' }}</td>
                            <td class="px-4 py-3 text-center text-ink-600">{{ number_format($item->download_count) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->status === \App\Enums\DocumentStatus::PUBLISHED ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $item->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.data-report.documents.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.data-report.documents.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-ink-500">
                                Belum ada dokumen.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $documents->links() }}
        </div>
    </x-admin.card>
@endsection
