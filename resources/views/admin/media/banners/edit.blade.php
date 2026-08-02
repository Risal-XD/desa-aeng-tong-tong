@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
    <x-admin.page-header title="Edit Banner" description="Perbarui informasi banner." />

    <form method="POST" action="{{ route('admin.media.banners.update', $banner) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Banner">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Banner" :value="$banner->title" required />
                        <x-admin.input name="slug" label="Slug" :value="$banner->slug" hint="Otomatis diisi dari judul bila dikosongkan." />
                        <x-admin.input name="link" label="Tautan" :value="$banner->link" hint="URL tujuan saat banner diklik, opsional." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Keterangan</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="image" label="Ganti Gambar Banner" :preview="$banner->image ? asset('storage/'.$banner->image) : null" hint="Kosongkan bila tidak diubah, JPG/PNG/WebP, maks 8 MB" />
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" :selected="$banner->status" />
                        <x-admin.input name="position" label="Posisi" :value="$banner->position" hint="Mis. slider, promo." />
                        <x-admin.input name="sort_order" label="Urutan" type="number" :value="$banner->sort_order" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Jadwal Tayang">
                    <div class="space-y-4">
                        <x-admin.input name="started_at" label="Mulai Tayang" type="date" :value="$banner->started_at?->format('Y-m-d')" />
                        <x-admin.input name="ended_at" label="Akhir Tayang" type="date" :value="$banner->ended_at?->format('Y-m-d')" hint="Opsional." />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.media.banners.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
