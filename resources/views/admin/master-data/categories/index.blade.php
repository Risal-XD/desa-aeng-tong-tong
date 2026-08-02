@extends('admin.layouts.app')

@section('title', 'Kategori')

@section('content')
    @php
        $titles = ['news' => 'Kategori Berita', 'gallery' => 'Kategori Galeri', 'video' => 'Kategori Video'];
    @endphp

    <x-admin.page-header
        :title="$titles[$type] ?? 'Kategori'"
        description="Kelola kategori untuk konten {{ $type === 'news' ? 'berita' : ($type === 'gallery' ? 'galeri foto' : 'video') }}."
    >
        @can('create', App\Models\NewsCategory::class)
            <x-slot:actions>
                <a
                    href="{{ route('admin.master-data.categories.'.$type.'.create') }}"
                    class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600"
                >
                    + Tambah Kategori
                </a>
            </x-slot:actions>
        @endcan
    </x-admin.page-header>

    <div class="mb-6 flex flex-wrap gap-2">
        @foreach (['news' => 'Berita', 'gallery' => 'Galeri', 'video' => 'Video'] as $key => $label)
            <a
                href="{{ route('admin.master-data.categories.'.$key.'.index') }}"
                class="rounded-lg border px-4 py-2 text-sm font-semibold transition
                    {{ $type === $key ? 'border-brand-500 bg-brand-500 text-white' : 'border-ink-200 bg-white text-ink-700 hover:bg-ink-50' }}"
            >
                {{ $label }}
            </a>
        @endforeach
    </div>

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-ink-500">{{ $category->slug }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $category->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-ink-100 text-ink-500' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a
                                        href="{{ route('admin.master-data.categories.'.$type.'.edit', $category->getKey()) }}"
                                        class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50"
                                    >
                                        Edit
                                    </a>
                                    <x-admin.delete-form
                                        :action="route('admin.master-data.categories.'.$type.'.destroy', $category->getKey())"
                                        label="Hapus"
                                    />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-10 text-center text-ink-500">
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-1 py-3">
            {{ $categories->links() }}
        </div>
    </x-admin.card>
@endsection
