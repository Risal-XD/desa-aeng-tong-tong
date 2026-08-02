@extends('admin.layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
    <x-admin.page-header title="Edit Pengumuman" description="Perbarui informasi pengumuman." />

    <form method="POST" action="{{ route('admin.content.announcements.update', $announcement) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Pengumuman">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Pengumuman" :value="$announcement->title" required />
                        <x-admin.input name="slug" label="Slug" :value="$announcement->slug" hint="Otomatis diisi dari judul bila dikosongkan." />

                        <div>
                            <label for="content" class="mb-1.5 block text-sm font-medium text-ink-700">Isi Pengumuman</label>
                            <textarea
                                id="content"
                                name="content"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('content', $announcement->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    @if ($announcement->attachment)
                        <a href="{{ asset('storage/'.$announcement->attachment) }}" target="_blank" class="mb-3 inline-flex items-center gap-1 rounded-md bg-brand-50 px-3 py-1.5 text-xs font-semibold text-brand-700 hover:bg-brand-100">
                            Lihat Lampiran Saat Ini
                        </a>
                    @endif
                    <x-admin.file-input name="attachment" label="Ganti Lampiran" accept=".pdf,.doc,.docx,.xls,.xlsx,image/*" hint="Kosongkan bila tidak diubah, maks 10 MB" />
                </x-admin.card>

                <x-admin.card title="Penerbitan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" :selected="$announcement->status" />
                        <x-admin.input
                            name="published_at"
                            label="Waktu Tayang"
                            type="datetime-local"
                            :value="$announcement->published_at ? \Illuminate\Support\Carbon::parse($announcement->published_at)->format('Y-m-d\TH:i') : null"
                        />
                        <x-admin.input
                            name="expired_at"
                            label="Waktu Berakhir"
                            type="datetime-local"
                            :value="$announcement->expired_at ? \Illuminate\Support\Carbon::parse($announcement->expired_at)->format('Y-m-d\TH:i') : null"
                            hint="Opsional."
                        />
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
