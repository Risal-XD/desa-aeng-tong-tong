@extends('admin.layouts.app')

@section('title', 'Tambah Data Desa')

@section('content')
    <x-admin.page-header title="Tambah Data Desa" description="Lengkapi identitas desa berikut." />

    <form method="POST" action="{{ route('admin.master-data.villages.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Identitas">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <x-admin.input name="name" label="Nama Desa" required />
                        <x-admin.input name="code" label="Kode Desa" placeholder="3529152001" required />
                        <x-admin.input name="district" label="Kecamatan" value="Saronggi" required />
                        <x-admin.input name="regency" label="Kabupaten" value="Sumenep" required />
                        <x-admin.input name="province" label="Provinsi" value="Jawa Timur" required />
                        <x-admin.input name="address" label="Alamat Kantor" placeholder="Jalan Desa Aeng Tong-Tong No. ..." />
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <x-admin.input name="latitude" label="Latitude" type="number" step="0.00000001" placeholder="-6.867..." />
                        <x-admin.input name="longitude" label="Longitude" type="number" step="0.00000001" placeholder="113.9..." />
                        <x-admin.input name="total_hamlet" label="Jumlah Dusun" type="number" value="0" />
                    </div>

                    <div class="mt-4">
                        <x-admin.textarea name="description" label="Deskripsi Singkat" rows="4" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <div class="space-y-4">
                        <x-admin.file-input name="logo" label="Logo Desa" hint="JPG/PNG/WebP/SVG, maks 2 MB" />
                        <x-admin.file-input name="cover_image" label="Gambar Sampul" hint="JPG/PNG/WebP, maks 4 MB" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.master-data.villages.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
