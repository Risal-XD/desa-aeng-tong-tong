@extends('admin.layouts.app')

@section('title', 'Sejarah Desa')

@section('content')
    <x-admin.page-header
        title="Sejarah Desa"
        description="Kelola riwayat dan asal-usul Desa Aeng Tong-Tong."
    />

    @if (! $village)
        <x-admin.card>
            <p class="text-sm text-amber-600">
                Data desa belum tersedia. Silakan buat data desa terlebih dahulu pada menu
                <a href="{{ route('admin.master-data.villages.index') }}" class="font-semibold text-brand-600 underline">Master Data → Data Desa</a>.
            </p>
        </x-admin.card>
    @else
        <form method="POST" action="{{ route('admin.profile.history.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <x-admin.card title="Konten Sejarah">
                        <div>
                            <label for="history_content" class="mb-1.5 block text-sm font-medium text-ink-700">Konten Sejarah</label>
                            <textarea
                                id="history_content"
                                name="history_content"
                                rows="12"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('history_content', $village->history?->history_content) }}</textarea>
                            @error('history_content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </x-admin.card>
                </div>

                <div class="space-y-6">
                    <x-admin.card title="Informasi">
                        <div class="space-y-4">
                            <x-admin.input name="founder_name" label="Nama Pendiri" :value="$village->history?->founder_name" />
                            <x-admin.input name="founded_year" label="Tahun Berdiri" type="number" :value="$village->history?->founded_year" />
                            <x-admin.select
                                name="status"
                                label="Status Publikasi"
                                :options="['draft' => 'Draft', 'published' => 'Published']"
                                :selected="$village->history?->status ?? 'draft'"
                            />
                        </div>
                    </x-admin.card>

                    <x-admin.card>
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.profile.village.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
                                Kembali
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
