@extends('admin.layouts.app')

@section('title', 'Tambah Pos APBDes')

@section('content')
    <x-admin.page-header title="Tambah Pos APBDes" description="Tambahkan pos anggaran desa." />

    <form method="POST" action="{{ route('admin.data-report.apbdes.store') }}">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Pos Anggaran">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="year" label="Tahun" type="number" :value="old('year', now()->year)" required />
                            <x-admin.select
                                name="type"
                                label="Jenis"
                                :options="\App\Enums\ApbdesType::options()"
                                :selected="old('type', 'pendapatan')"
                                required
                            />
                        </div>
                        <x-admin.input name="name" label="Nama Pos Anggaran" required placeholder="Dana Desa" />
                        <x-admin.input name="category" label="Kategori" placeholder="Transfer, PADes, Bidang Pembangunan, ..." />

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="budget_amount" label="Nilai Anggaran (Rp)" type="number" step="any" min="0" value="0" required />
                            <x-admin.input name="realization_amount" label="Nilai Realisasi (Rp)" type="number" step="any" min="0" value="0" required />
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
            </div>

            <div class="space-y-6">
                <x-admin.card title="Pengaturan">
                    <x-admin.checkbox name="is_active" label="Aktif" checked />
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
