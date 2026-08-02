@extends('admin.layouts.app')

@section('title', 'Tambah Video')

@section('content')
    <x-admin.page-header title="Tambah Video" description="Tambahkan video profil atau dokumentasi desa." />

    <form method="POST" action="{{ route('admin.media.videos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Video">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Video" required />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari judul bila dikosongkan." />
                        <x-admin.select
                            name="video_category_id"
                            label="Kategori"
                            :options="$categories->pluck('name', 'id')->all()"
                            placeholder="— Pilih Kategori —"
                        />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.select name="platform" label="Platform" :options="$platforms" selected="youtube" required />
                            <x-admin.input name="video_url" label="URL Video" placeholder="https://youtube.com/watch?v=..." required />
                        </div>

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Keterangan</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="thumbnail" label="Thumbnail" hint="JPG/PNG/WebP, maks 4 MB. Kosongkan untuk memakai thumbnail otomatis platform." />
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.checkbox name="is_active" label="Aktif" checked />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.media.videos.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
                            Batal
                        </a>
                        <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                            Simpan
                        </button>
                    </div>
                </x-admin.card>
            </div>
        </div>
    </form>
@endsection
