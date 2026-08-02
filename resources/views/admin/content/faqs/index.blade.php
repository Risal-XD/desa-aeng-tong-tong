@extends('admin.layouts.app')

@section('title', 'FAQ')

@section('content')
    <x-admin.page-header title="FAQ" description="Kelola pertanyaan yang sering diajukan.">
        @can('create', App\Models\Faq::class)
            <x-slot:actions>
                <a href="{{ route('admin.content.faqs.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah FAQ
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Pertanyaan</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Urutan</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($faqs as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-medium text-ink-900">{{ $item->question }}</p>
                                <p class="text-xs text-ink-500">Oleh: {{ $item->author?->name ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->category ?? '—' }}</td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->sort_order }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.content.faqs.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.content.faqs.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada FAQ.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $faqs->links() }}
        </div>
    </x-admin.card>
@endsection
