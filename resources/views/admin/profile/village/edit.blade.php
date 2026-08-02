@extends('admin.layouts.app')

@section('title', 'Profil Desa')

@section('content')
    <x-admin.page-header
        title="Profil Desa"
        description="Kelola gambaran umum, geografis, dan ringkasan demografis desa."
    />

    @if (! $village)
        <x-admin.card>
            <p class="text-sm text-amber-600">
                Data desa belum tersedia. Silakan buat data desa terlebih dahulu pada menu
                <a href="{{ route('admin.master-data.villages.index') }}" class="font-semibold text-brand-600 underline">Master Data → Data Desa</a>.
            </p>
        </x-admin.card>
    @else
        <form method="POST" action="{{ route('admin.profile.village.update') }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2">
                    <x-admin.card title="Konten Profil">
                        <div class="space-y-4">
                            <div>
                                <label for="overview" class="mb-1.5 block text-sm font-medium text-ink-700">Gambaran Umum</label>
                                <textarea
                                    id="overview"
                                    name="overview"
                                    rows="6"
                                    x-data
                                    x-init="initCkeditor($el)"
                                    class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                >{{ old('overview', $village->profile?->overview) }}</textarea>
                                @error('overview')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="geographic" class="mb-1.5 block text-sm font-medium text-ink-700">Kondisi Geografis</label>
                                <textarea
                                    id="geographic"
                                    name="geographic"
                                    rows="6"
                                    x-data
                                    x-init="initCkeditor($el)"
                                    class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                >{{ old('geographic', $village->profile?->geographic) }}</textarea>
                                @error('geographic')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="demographics_summary" class="mb-1.5 block text-sm font-medium text-ink-700">Ringkasan Demografis</label>
                                <textarea
                                    id="demographics_summary"
                                    name="demographics_summary"
                                    rows="5"
                                    x-data
                                    x-init="initCkeditor($el)"
                                    class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                                >{{ old('demographics_summary', $village->profile?->demographics_summary) }}</textarea>
                                @error('demographics_summary')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </x-admin.card>
                </div>

                <div class="space-y-6">
                    <x-admin.card title="Navigasi">
                        <div class="space-y-2">
                            <a href="{{ route('admin.profile.history.index') }}" class="flex items-center justify-between rounded-md border border-ink-200 px-3 py-2.5 text-sm text-ink-700 transition hover:bg-ink-50">
                                <span>Sejarah Desa</span>
                                <span>&rarr;</span>
                            </a>
                            <a href="{{ route('admin.profile.vision-mission.index') }}" class="flex items-center justify-between rounded-md border border-ink-200 px-3 py-2.5 text-sm text-ink-700 transition hover:bg-ink-50">
                                <span>Visi &amp; Misi</span>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </x-admin.card>

                    <x-admin.card>
                        <div class="flex items-center justify-end gap-3">
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
