@extends('admin.layouts.app')

@section('title', 'Edit UMKM')

@section('content')
    <x-admin.page-header title="Edit UMKM" description="Perbarui data usaha masyarakat." />

    <form method="POST" action="{{ route('admin.economy.umkms.update', $umkm) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Usaha">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="name" label="Nama Usaha" :value="$umkm->name" required />
                            <x-admin.input name="owner_name" label="Nama Pemilik" :value="$umkm->owner_name" />
                        </div>
                        <x-admin.input name="slug" label="Slug" :value="$umkm->slug" hint="Otomatis diisi dari nama bila dikosongkan." />
                        <x-admin.input name="category" label="Kategori" :value="$umkm->category" placeholder="Kuliner, Kerajinan, Batik, ..." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="6"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('description', $umkm->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="logo" label="Ganti Logo" :preview="$umkm->logo ? asset('storage/'.$umkm->logo) : null" hint="Kosongkan bila tidak diubah, JPG/PNG/WebP, maks 2 MB" />
                    <div class="mt-4">
                        <x-admin.file-input name="cover_image" label="Ganti Gambar Sampul" :preview="$umkm->cover_image ? asset('storage/'.$umkm->cover_image) : null" hint="Kosongkan bila tidak diubah, JPG/PNG/WebP, maks 8 MB" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Kontak">
                    <div class="space-y-4">
                        <x-admin.input name="address" label="Alamat" :value="$umkm->address" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="phone" label="Telepon" :value="$umkm->phone" />
                            <x-admin.input name="email" label="Email" type="email" :value="$umkm->email" />
                        </div>
                        <x-admin.input name="website" label="Situs" type="url" :value="$umkm->website" />
                        <x-admin.input name="instagram" label="Instagram" :value="$umkm->instagram" placeholder="@username" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.checkbox name="is_featured" label="Jadikan usaha unggulan" :checked="$umkm->is_featured" />
                        <x-admin.checkbox name="is_active" label="Aktif" :checked="$umkm->is_active" />
                        <x-admin.input name="sort_order" label="Urutan" type="number" :value="$umkm->sort_order" />
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
