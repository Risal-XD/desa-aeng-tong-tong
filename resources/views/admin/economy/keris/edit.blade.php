@extends('admin.layouts.app')

@section('title', 'Edit Mpu')

@section('content')
    <x-admin.page-header title="Edit Mpu" description="Perbarui data Mpu/empu keris." />

    <form method="POST" action="{{ route('admin.economy.keris.update', $keris_artisan) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Mpu">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="name" label="Nama Mpu" :value="$keris_artisan->name" required />
                            <x-admin.input name="title" label="Gelar" :value="$keris_artisan->title" placeholder="Mpu, Empu, ..." />
                        </div>
                        <x-admin.input name="slug" label="Slug" :value="$keris_artisan->slug" hint="Otomatis diisi dari nama bila dikosongkan." />
                        <x-admin.input name="specialties" label="Keahlian" :value="$keris_artisan->specialties ? implode(', ', $keris_artisan->specialties) : null" placeholder="Pamor, Bilah, Warangka, ..." hint="Pisahkan dengan koma." />

                        <div>
                            <label for="bio" class="mb-1.5 block text-sm font-medium text-ink-700">Biografi</label>
                            <textarea
                                id="bio"
                                name="bio"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('bio', $keris_artisan->bio) }}</textarea>
                            @error('bio')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="photo" label="Ganti Foto" :preview="$keris_artisan->photo ? asset('storage/'.$keris_artisan->photo) : null" hint="Kosongkan bila tidak diubah, JPG/PNG/WebP, maks 4 MB" />
                </x-admin.card>

                <x-admin.card title="Prestasi & Kontak">
                    <div class="space-y-4">
                        <x-admin.input name="experience_years" label="Lama Berkarya" :value="$keris_artisan->experience_years" placeholder="30 tahun" />
                        <x-admin.input name="award" label="Penghargaan" :value="$keris_artisan->award" />
                        <x-admin.input name="address" label="Alamat" :value="$keris_artisan->address" />
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="phone" label="Telepon" :value="$keris_artisan->phone" />
                            <x-admin.input name="email" label="Email" type="email" :value="$keris_artisan->email" />
                        </div>
                        <x-admin.input name="website" label="Situs" type="url" :value="$keris_artisan->website" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.input name="sort_order" label="Urutan" type="number" :value="$keris_artisan->sort_order" />
                        <x-admin.checkbox name="is_active" label="Aktif" :checked="$keris_artisan->is_active" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.economy.keris.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
