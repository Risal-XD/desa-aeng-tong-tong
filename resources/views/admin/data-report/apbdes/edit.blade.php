@extends('admin.layouts.app')

@section('title', 'Edit Pos APBDes')

@section('content')
    <x-admin.page-header title="Edit Pos APBDes" description="Perbarui pos anggaran desa." />

    <form method="POST" action="{{ route('admin.data-report.apbdes.update', $apbdes) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Pos Anggaran">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="year" label="Tahun" type="number" :value="old('year', $apbdes->year)" required />
                            <x-admin.select
                                name="type"
                                label="Jenis"
                                :options="\App\Enums\ApbdesType::options()"
                                :selected="old('type', $apbdes->type->value)"
                                required
                            />
                        </div>
                        <x-admin.input name="name" label="Nama Pos Anggaran" :value="$apbdes->name" required placeholder="Dana Desa" />
                        <x-admin.input name="category" label="Kategori" :value="$apbdes->category" placeholder="Transfer, PADes, Bidang Pembangunan, ..." />

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="budget_amount" label="Nilai Anggaran (Rp)" type="number" step="any" min="0" :value="old('budget_amount', $apbdes->budget_amount)" required />
                            <x-admin.input name="realization_amount" label="Nilai Realisasi (Rp)" type="number" step="any" min="0" :value="old('realization_amount', $apbdes->realization_amount)" required />
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
                            >{{ old('description', $apbdes->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Pengaturan">
                    <x-admin.checkbox name="is_active" label="Aktif" :checked="$apbdes->is_active" />
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.data-report.apbdes.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
