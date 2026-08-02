@extends('admin.layouts.app')

@section('title', 'Tambah Banner')

@section('content')
    <x-admin.page-header title="Tambah Banner" description="Tambahkan banner untuk halaman beranda." />

    <form method="POST" action="{{ route('admin.media.banners.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Banner">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Banner" required />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari judul bila dikosongkan." />
                        <x-admin.input name="link" label="Tautan" hint="URL tujuan saat banner diklik, opsional." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Keterangan</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
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
                    <x-admin.file-input name="image" label="Gambar Banner" hint="JPG/PNG/WebP, maks 8 MB, rasio disarankan 16:6" />
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" selected="active" />
                        <x-admin.input name="position" label="Posisi" value="slider" hint="Mis. slider, promo." />
                        <x-admin.input name="sort_order" label="Urutan" type="number" value="0" />
                    </div>
                </x-admin.card>

                <x-admin.card title="Jadwal Tayang">
                    <div class="space-y-4">
                        <x-admin.input name="started_at" label="Mulai Tayang" type="date" />
                        <x-admin.input name="ended_at" label="Akhir Tayang" type="date" hint="Opsional." />
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
