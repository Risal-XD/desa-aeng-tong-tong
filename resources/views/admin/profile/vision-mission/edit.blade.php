@extends('admin.layouts.app')

@section('title', 'Visi & Misi')

@section('content')
    <x-admin.page-header
        title="Visi & Misi"
        description="Kelola visi dan misi Desa Aeng Tong-Tong."
    />

    @if (! $village)
        <x-admin.card>
            <p class="text-sm text-amber-600">
                Data desa belum tersedia. Silakan buat data desa terlebih dahulu pada menu
                <a href="{{ route('admin.master-data.villages.index') }}" class="font-semibold text-brand-600 underline">Master Data → Data Desa</a>.
            </p>
        </x-admin.card>
    @else
        <form method="POST" action="{{ route('admin.profile.vision-mission.update') }}" x-data="{
            missions: @js($missions->pluck('mission')->values()->toArray() ?: [''])
        }">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <x-admin.card title="Visi">
                        <div>
                            <label for="vision" class="mb-1.5 block text-sm font-medium text-ink-700">Visi</label>
                            <textarea
                                id="vision"
                                name="vision"
                                rows="3"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('vision', $visions->first()?->vision) }}</textarea>
                            @error('vision')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </x-admin.card>

                    <div class="mt-6">
                        <x-admin.card title="Misi">
                            <div class="space-y-3">
                                <template x-for="(mission, index) in missions" :key="index">
                                    <div class="flex items-start gap-2">
                                        <input
                                            type="text"
                                            x-model="missions[index]"
                                            :name="'missions[' + index + ']'"
                                            placeholder="Misi ke-" + (index + 1)
                                            class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                        >
                                        <button
                                            type="button"
                                            @click="missions.splice(index, 1)"
                                            class="rounded-md border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                                        >
                                            Hapus
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4">
                                <button
                                    type="button"
                                    @click="missions.push('')"
                                    class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50"
                                >
                                    + Tambah Misi
                                </button>
                            </div>
                        </x-admin.card>
                    </div>
                </div>

                <div class="space-y-6">
                    <x-admin.card title="Pengaturan">
                        <div class="space-y-4">
                            <x-admin.input name="sort_order" label="Urutan" type="number" :value="$visions->first()?->sort_order ?? 0" />
                            <x-admin.checkbox name="is_active" label="Tampilkan di publik" :checked="(bool) ($visions->first()?->is_active ?? true)" />
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
