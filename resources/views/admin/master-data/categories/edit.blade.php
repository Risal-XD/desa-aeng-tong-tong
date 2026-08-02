@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    @php
        $titles = ['news' => 'Kategori Berita', 'gallery' => 'Kategori Galeri', 'video' => 'Kategori Video'];
    @endphp

    <x-admin.page-header :title="'Edit ' . $titles[$type] ?? 'Kategori'" />

    <form method="POST" action="{{ route('admin.master-data.categories.'.$type.'.update', $category->getKey()) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail">
                    <div class="space-y-4">
                        <x-admin.input name="name" label="Nama Kategori" :value="$category->name" required />
                        <x-admin.input name="slug" label="Slug" :value="$category->slug" />
                        <x-admin.textarea name="description" label="Deskripsi" rows="4" :value="$category->description" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Status">
                    <x-admin.checkbox name="is_active" label="Aktif" :checked="$category->is_active" />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.master-data.categories.'.$type.'.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
                            Batal
                        </a>
                        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                            Simpan Perubahan
                        </button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
