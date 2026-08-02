@extends('admin.layouts.app')

@section('title', 'Tambah Pengumuman')

@section('content')
    <x-admin.page-header title="Tambah Pengumuman" description="Tambahkan pengumuman desa." />

    <form method="POST" action="{{ route('admin.content.announcements.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Pengumuman">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Pengumuman" required />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari judul bila dikosongkan." />

                        <div>
                            <label for="content" class="mb-1.5 block text-sm font-medium text-ink-700">Isi Pengumuman</label>
                            <textarea
                                id="content"
                                name="content"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="attachment" label="Lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,image/*" hint="Opsional, maks 10 MB" />
                </x-admin.card>

                <x-admin.card title="Penerbitan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" selected="published" />
                        <x-admin.input name="published_at" label="Waktu Tayang" type="datetime-local" />
                        <x-admin.input name="expired_at" label="Waktu Berakhir" type="datetime-local" hint="Opsional." />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.content.announcements.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
