@extends('admin.layouts.app')

@section('title', 'Tambah Struktur')

@section('content')
    <x-admin.page-header title="Tambah Struktur" description="Tambahkan unit/jabatan pada bagan organisasi desa." />

    <form method="POST" action="{{ route('admin.master-data.structures.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-admin.input name="name" label="Nama Struktur" placeholder="Kepala Desa, BPD, LPM, ..." required />
                        <x-admin.input name="position" label="Jabatan" placeholder="Kepala Desa" />
                        <x-admin.select name="parent_id" label="Struktur Induk" :options="$parents->pluck('name', 'id')" placeholder="— Tidak ada —" />
                        <x-admin.input name="level" label="Level" type="number" value="0" />
                        <x-admin.input name="sort_order" label="Urutan" type="number" value="0" />
                        <div class="flex items-end pb-1">
                            <x-admin.checkbox name="is_active" label="Aktif" checked />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-admin.textarea name="description" label="Deskripsi" rows="4" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="image" label="Gambar" hint="JPG/PNG/WebP, maks 2 MB" />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.master-data.structures.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
