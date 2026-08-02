@extends('admin.layouts.app')

@section('title', 'Tambah Wisata')

@section('content')
    <x-admin.page-header title="Tambah Wisata" description="Tambahkan destinasi wisata desa." />

    <form method="POST" action="{{ route('admin.economy.tourism.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Wisata">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Nama Destinasi" required />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari nama bila dikosongkan." />
                        <x-admin.input name="category" label="Kategori" placeholder="Alam, Budaya, Edukasi, ..." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
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
                    <x-admin.file-input name="image" label="Gambar Utama" hint="JPG/PNG/WebP, maks 8 MB" />
                    <div class="mt-4">
                        <x-admin.file-input name="gallery[]" label="Galeri (multiple)" hint="Pilih beberapa gambar, opsional" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Lokasi & Akses">
                    <div class="space-y-4">
                        <x-admin.input name="address" label="Alamat" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="latitude" label="Latitude" placeholder="-7.12345" />
                            <x-admin.input name="longitude" label="Longitude" placeholder="113.12345" />
                        </div>
                        <x-admin.input name="open_hours" label="Jam Buka" placeholder="08.00 – 17.00 WIB" />
                        <x-admin.input name="entrance_fee" label="Harga Tiket" placeholder="Rp 10.000" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.checkbox name="is_featured" label="Jadikan wisata unggulan" />
                        <x-admin.checkbox name="is_active" label="Aktif" checked />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.economy.tourism.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
