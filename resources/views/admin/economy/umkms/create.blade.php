@extends('admin.layouts.app')

@section('title', 'Tambah UMKM')

@section('content')
    <x-admin.page-header title="Tambah UMKM" description="Tambahkan data usaha masyarakat." />

    <form method="POST" action="{{ route('admin.economy.umkms.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Usaha">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="name" label="Nama Usaha" required />
                            <x-admin.input name="owner_name" label="Nama Pemilik" />
                        </div>
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari nama bila dikosongkan." />
                        <x-admin.input name="category" label="Kategori" placeholder="Kuliner, Kerajinan, Batik, ..." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
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
                    <x-admin.file-input name="logo" label="Logo" hint="JPG/PNG/WebP, maks 2 MB" />
                    <div class="mt-4">
                        <x-admin.file-input name="cover_image" label="Gambar Sampul" hint="JPG/PNG/WebP, maks 8 MB" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Kontak">
                    <div class="space-y-4">
                        <x-admin.input name="address" label="Alamat" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="phone" label="Telepon" />
                            <x-admin.input name="email" label="Email" type="email" />
                        </div>
                        <x-admin.input name="website" label="Situs" type="url" />
                        <x-admin.input name="instagram" label="Instagram" placeholder="@username" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.checkbox name="is_featured" label="Jadikan usaha unggulan" />
                        <x-admin.checkbox name="is_active" label="Aktif" checked />
                        <x-admin.input name="sort_order" label="Urutan" type="number" value="0" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.economy.umkms.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
