@extends('admin.layouts.app')

@section('title', 'Unggah Dokumen')

@section('content')
    <x-admin.page-header title="Unggah Dokumen" description="Unggah dokumen publik desa." />

    <form method="POST" action="{{ route('admin.data-report.documents.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Dokumen">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Dokumen" required placeholder="Buku Profil Desa" />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari judul bila dikosongkan." />
                        <x-admin.input name="category" label="Kategori" placeholder="Profil, Laporan, Peraturan, ..." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Keterangan</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                x-data
                                x-init="initCkeditor($el)"
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
                <x-admin.card title="File">
                    <x-admin.file-input
                        name="file"
                        label="File Dokumen"
                        :accept="'.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.jpg,.jpeg,.png,.webp'"
                        hint="PDF, Word, Excel, ZIP, atau gambar — maks 20 MB"
                        required
                    />
                </x-admin.card>

                <x-admin.card title="Pengaturan">
                    <x-admin.select
                        name="status"
                        label="Status"
                        :options="\App\Enums\DocumentStatus::options()"
                        :selected="old('status', 'published')"
                        required
                    />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.data-report.documents.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
