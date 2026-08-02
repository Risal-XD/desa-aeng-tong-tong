@extends('admin.layouts.app')

@section('title', 'Berita')

@section('content')
    <x-admin.page-header title="Berita" description="Kelola berita dan artikel desa.">
        @can('create', App\Models\News::class)
            <x-slot:actions>
                <a href="{{ route('admin.content.news.create') }}" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
                    + Tambah Berita
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
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Views</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($news as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-md bg-brand-100 text-xs font-bold text-brand-800">
                                        @if ($item->cover_image)
                                            <img src="{{ asset('storage/'.$item->cover_image) }}" alt="{{ $item->title }}" class="h-full w-full object-cover">
                                        @else
                                            {{ mb_substr($item->title, 0, 2) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-ink-900">{{ $item->title }}</p>
                                        <p class="text-xs text-ink-500">Oleh: {{ $item->author?->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $item->category?->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $item->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ number_format($item->views_count) }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.content.news.edit', $item) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                        Edit
                                    </a>
                                    @can('delete', $item)
                                        <x-admin.delete-form :action="route('admin.content.news.destroy', $item)" label="Hapus" />
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada berita.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $news->links() }}
        </div>
    </x-admin.card>
@endsection
