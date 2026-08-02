@extends('admin.layouts.app')

@section('title', 'Edit Perangkat')

@section('content')
    <x-admin.page-header title="Edit Perangkat" description="Perbarui data perangkat/aparat desa." />

    <form method="POST" action="{{ route('admin.master-data.officials.update', $official) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-admin.input name="name" label="Nama Lengkap" :value="$official->name" required />
                        <x-admin.input name="position" label="Jabatan" :value="$official->position" required />
                        <x-admin.select name="structure_id" label="Struktur" :options="$structures->pluck('name', 'id')" :selected="$official->structure_id" placeholder="— Tidak ada —" />
                        <x-admin.input name="nip" label="NIP" :value="$official->nip" />
                        <x-admin.input name="email" label="Email" type="email" :value="$official->email" />
                        <x-admin.input name="phone" label="Telepon" :value="$official->phone" />
                        <x-admin.input name="sort_order" label="Urutan" type="number" :value="$official->sort_order" />
                        <div class="flex items-end pb-1">
                            <x-admin.checkbox name="is_active" label="Aktif" :checked="$official->is_active" />
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input
                        name="photo"
                        label="Foto"
                        hint="JPG/PNG/WebP, maks 2 MB. Kosongkan bila tidak diganti."
                        :preview="$official->photo ? asset('storage/'.$official->photo) : null"
                    />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.master-data.officials.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
@endsection
