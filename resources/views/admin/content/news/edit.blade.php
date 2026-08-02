@extends('admin.layouts.app')

@section('title', 'Edit Berita')

@section('content')
    <x-admin.page-header title="Edit Berita" description="Perbarui informasi berita." />

    <form method="POST" action="{{ route('admin.content.news.update', $news) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Berita">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Berita" :value="$news->title" required />
                        <x-admin.input name="slug" label="Slug" :value="$news->slug" hint="Otomatis diisi dari judul bila dikosongkan." />
                        <x-admin.select
                            name="news_category_id"
                            label="Kategori"
                            :options="$categories->pluck('name', 'id')->all()"
                            :selected="$news->news_category_id"
                            placeholder="— Pilih Kategori —"
                        />
                        <x-admin.input name="excerpt" label="Ringkasan" :value="$news->excerpt" hint="Ringkasan singkat untuk halaman daftar." />

                        <div>
                            <label for="content" class="mb-1.5 block text-sm font-medium text-ink-700">Konten <span class="text-red-500">*</span></label>
                            <textarea
                                id="content"
                                name="content"
                                rows="10"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-ink-700">Tag</label>
                            <input
                                type="text"
                                name="tags"
                                placeholder="wisata, keris, budaya"
                                value="{{ old('tags', $news->tags ? implode(', ', $news->tags) : '') }}"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >
                            <p class="mt-1 text-xs text-ink-500">Pisahkan tag dengan koma, mis. wisata, keris, budaya.</p>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Media">
                    <x-admin.file-input name="cover_image" label="Gambar Sampul" :preview="$news->cover_image ? asset('storage/'.$news->cover_image) : null" hint="JPG/PNG/WebP, maks 4 MB" />
                    <div class="mt-4">
                        <x-admin.file-input name="thumbnail" label="Thumbnail" :preview="$news->thumbnail ? asset('storage/'.$news->thumbnail) : null" hint="Opsional, maks 2 MB" />
                    </div>
                    <div class="mt-4">
                        <x-admin.input name="source" label="Sumber" :value="$news->source" hint="Sumber berita, opsional." />
                    </div>
                </x-admin.card>

                <x-admin.card title="Penerbitan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" :selected="$news->status" />
                        <x-admin.input
                            name="published_at"
                            label="Waktu Terbit"
                            type="datetime-local"
                            :value="$news->published_at ? \Illuminate\Support\Carbon::parse($news->published_at)->format('Y-m-d\TH:i') : null"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.content.news.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
