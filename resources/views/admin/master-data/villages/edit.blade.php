@extends('admin.layouts.app')

@section('title', 'Edit Data Desa')

@section('content')
    <x-admin.page-header title="Edit Data Desa" description="Perbarui identitas dan informasi desa." />

    <form method="POST" action="{{ route('admin.master-data.villages.update', $village) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Identitas">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-admin.input name="name" label="Nama Desa" :value="$village->name" required />
                        <x-admin.input name="code" label="Kode Desa" :value="$village->code" required />
                        <x-admin.input name="district" label="Kecamatan" :value="$village->district" required />
                        <x-admin.input name="regency" label="Kabupaten" :value="$village->regency" required />
                        <x-admin.input name="province" label="Provinsi" :value="$village->province" required />
                        <x-admin.input name="address" label="Alamat Kantor" :value="$village->address" />
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <x-admin.input name="latitude" label="Latitude" type="number" step="0.00000001" :value="$village->latitude" />
                        <x-admin.input name="longitude" label="Longitude" type="number" step="0.00000001" :value="$village->longitude" />
                        <x-admin.input name="total_hamlet" label="Jumlah Dusun" type="number" :value="$village->total_hamlet" />
                    </div>

                    <div class="mt-4">
                        <x-admin.textarea name="description" label="Deskripsi Singkat" rows="4" :value="$village->description" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <div class="space-y-4">
                        <x-admin.file-input
                            name="logo"
                            label="Logo Desa"
                            hint="JPG/PNG/WebP/SVG, maks 2 MB. Kosongkan bila tidak diganti."
                            :preview="$village->logo ? asset('storage/'.$village->logo) : null"
                        />
                        <x-admin.file-input
                            name="cover_image"
                            label="Gambar Sampul"
                            hint="JPG/PNG/WebP, maks 4 MB. Kosongkan bila tidak diganti."
                            :preview="$village->cover_image ? asset('storage/'.$village->cover_image) : null"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.master-data.villages.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
