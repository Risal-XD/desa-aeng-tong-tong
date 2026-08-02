@extends('admin.layouts.app')

@section('title', 'Edit Wisata')

@section('content')
    <x-admin.page-header title="Edit Wisata" description="Perbarui informasi destinasi wisata." />

    <form method="POST" action="{{ route('admin.economy.tourism.update', $tourism_destination) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Wisata">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Nama Destinasi" :value="$tourism_destination->title" required />
                        <x-admin.input name="slug" label="Slug" :value="$tourism_destination->slug" hint="Otomatis diisi dari nama bila dikosongkan." />
                        <x-admin.input name="category" label="Kategori" :value="$tourism_destination->category" placeholder="Alam, Budaya, Edukasi, ..." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('description', $tourism_destination->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="image" label="Ganti Gambar Utama" :preview="$tourism_destination->image ? asset('storage/'.$tourism_destination->image) : null" hint="Kosongkan bila tidak diubah, JPG/PNG/WebP, maks 8 MB" />
                    <div class="mt-4">
                        <x-admin.file-input name="gallery[]" label="Tambah Galeri" hint="Pilih beberapa gambar, opsional" />
                    </div>
                    @if ($tourism_destination->gallery)
                        <p class="mt-3 text-xs font-semibold text-ink-700">Galeri Saat Ini ({{ count($tourism_destination->gallery) }})</p>
                    @endif
                </x-admin.card>

                <x-admin.card title="Lokasi & Akses">
                    <div class="space-y-4">
                        <x-admin.input name="address" label="Alamat" :value="$tourism_destination->address" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="latitude" label="Latitude" :value="$tourism_destination->latitude" placeholder="-7.12345" />
                            <x-admin.input name="longitude" label="Longitude" :value="$tourism_destination->longitude" placeholder="113.12345" />
                        </div>
                        <x-admin.input name="open_hours" label="Jam Buka" :value="$tourism_destination->open_hours" placeholder="08.00 – 17.00 WIB" />
                        <x-admin.input name="entrance_fee" label="Harga Tiket" :value="$tourism_destination->entrance_fee" placeholder="Rp 10.000" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.checkbox name="is_featured" label="Jadikan wisata unggulan" :checked="$tourism_destination->is_featured" />
                        <x-admin.checkbox name="is_active" label="Aktif" :checked="$tourism_destination->is_active" />
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
