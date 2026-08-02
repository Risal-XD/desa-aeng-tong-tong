@extends('admin.layouts.app')

@section('title', 'Tambah Statistik')

@section('content')
    <x-admin.page-header title="Tambah Statistik" description="Tambahkan kelompok data statistik desa." />

    <form method="POST" action="{{ route('admin.data-report.statistics.store') }}">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Statistik">
                    <div class="space-y-4">
                        <x-admin.input name="name" label="Nama Statistik" required placeholder="Statistik Kependudukan" />
                        <x-admin.input name="slug" label="Slug" hint="Otomatis diisi dari nama bila dikosongkan." />

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.select
                                name="category"
                                label="Kategori"
                                :options="\App\Enums\StatisticCategory::options()"
                                :selected="old('category', 'kependudukan')"
                                required
                            />
                            <x-admin.input name="year" label="Tahun" type="number" :value="old('year', now()->year)" required />
                        </div>

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

                <x-admin.card title="Data Statistik (baris)">
                    <div class="space-y-3" x-data="populationRows(@js(old('population', [])))">
                        <template x-for="(row, index) in rows" :key="index">
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-12">
                                <div class="sm:col-span-6">
                                    <input
                                        type="text"
                                        x-model="row.label"
                                        :name="`population[${index}][label]`"
                                        placeholder="Label (mis. Laki-laki)"
                                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                    >
                                </div>
                                <div class="sm:col-span-3">
                                    <input
                                        type="number"
                                        step="any"
                                        min="0"
                                        x-model="row.value"
                                        :name="`population[${index}][value]`"
                                        placeholder="Nilai"
                                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                    >
                                </div>
                                <div class="sm:col-span-2">
                                    <input
                                        type="text"
                                        x-model="row.unit"
                                        :name="`population[${index}][unit]`"
                                        placeholder="Satuan"
                                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                    >
                                </div>
                                <div class="flex items-center justify-end sm:col-span-1">
                                    <button type="button" @click="rows.splice(index, 1)" class="rounded-md border border-ink-200 px-2 py-2 text-xs font-semibold text-red-600 hover:bg-red-50" aria-label="Hapus baris">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </template>
                        <button type="button" @click="rows.push({ label: '', value: 0, unit: '' })" class="rounded-lg border border-dashed border-brand-300 px-4 py-2.5 text-sm font-semibold text-brand-600 transition hover:bg-brand-50">
                            + Tambah Baris
                        </button>
                    </div>
                    @error('population')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Pengaturan">
                    <x-admin.checkbox name="is_active" label="Aktif" checked />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.data-report.statistics.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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

    @push('scripts')
        <script>
            function populationRows(initial = []) {
                const defaults = [{ label: '', value: 0, unit: '' }, { label: '', value: 0, unit: '' }];
                const seeded = Array.isArray(initial) && initial.length > 0
                    ? initial
                    : defaults;

                return {
                    rows: seeded.map((row) => ({ label: row.label ?? '', value: row.value ?? 0, unit: row.unit ?? '' })),
                };
            }
        </script>
    @endpush
@endsection
