@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
    <x-admin.page-header title="Edit FAQ" description="Perbarui pertanyaan yang sering diajukan." />

    <form method="POST" action="{{ route('admin.content.faqs.update', $faq) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail FAQ">
                    <div class="space-y-4">
                        <x-admin.input name="question" label="Pertanyaan" :value="$faq->question" required />

                        <div>
                            <label for="answer" class="mb-1.5 block text-sm font-medium text-ink-700">Jawaban <span class="text-red-500">*</span></label>
                            <textarea
                                id="answer"
                                name="answer"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('answer', $faq->answer) }}</textarea>
                            @error('answer')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.input name="category" label="Kategori" :value="$faq->category" hint="Mis. administrasi, wisata, umum." />
                        <x-admin.input name="sort_order" label="Urutan" type="number" :value="$faq->sort_order" />
                        <x-admin.checkbox name="is_active" label="Aktif" :checked="$faq->is_active" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.content.faqs.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
