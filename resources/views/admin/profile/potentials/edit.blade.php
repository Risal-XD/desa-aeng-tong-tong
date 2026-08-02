@extends('admin.layouts.app')

@section('title', 'Edit Potensi')

@section('content')
    <x-admin.page-header title="Edit Potensi" description="Perbarui potensi desa." />

    @if (! $village)
        <x-admin.card>
            <p class="text-sm text-amber-600">
                Data desa belum tersedia. Silakan buat data desa terlebih dahulu pada menu
                <a href="{{ route('admin.master-data.villages.index') }}" class="font-semibold text-brand-600 underline">Master Data → Data Desa</a>.
            </p>
        </x-admin.card>
    @else
        <form method="POST" action="{{ route('admin.profile.potentials.update', $potential) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <x-admin.card title="Detail">
                        <div class="space-y-4">
                            <x-admin.input name="title" label="Judul Potensi" :value="$potential->title" required />
                            <x-admin.input name="slug" label="Slug" :value="$potential->slug" />
                            <x-admin.input name="category" label="Kategori Potensi" :value="$potential->category" />

                            <div>
                                <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                                <textarea
                                    id="description"
                                    name="description"
                                    rows="8"
                                    x-data
                                    x-init="initCkeditor($el)"
                                    class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                >{{ old('description', $potential->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-admin.card>
                </div>

                <div class="space-y-6">
                    <x-admin.card title="Media">
                        <x-admin.file-input
                            name="image"
                            label="Gambar"
                            hint="JPG/PNG/WebP, maks 4 MB. Kosongkan bila tidak diganti."
                            :preview="$potential->image ? asset('storage/'.$potential->image) : null"
                        />
                        <div class="mt-4">
                            <x-admin.input name="icon" label="Ikon (nama ikon)" :value="$potential->icon" />
                        </div>
                    </x-admin.card>

                    <x-admin.card title="Pengaturan">
                        <div class="space-y-4">
                            <x-admin.checkbox name="is_featured" label="Jadikan potensi unggulan" :checked="$potential->is_featured" />
                            <x-admin.checkbox name="is_active" label="Aktif" :checked="$potential->is_active" />
                            <x-admin.input name="sort_order" label="Urutan" type="number" :value="$potential->sort_order" />
                        </div>
                    </x-admin.card>

                    <x-admin.card>
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.profile.potentials.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
    @endif
@endsection
