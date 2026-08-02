@extends('admin.layouts.app')

@section('title', 'Edit Agenda')

@section('content')
    <x-admin.page-header title="Edit Agenda" description="Perbarui informasi agenda." />

    <form method="POST" action="{{ route('admin.content.agendas.update', $agenda) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-admin.card title="Detail Agenda">
                    <div class="space-y-4">
                        <x-admin.input name="title" label="Judul Agenda" :value="$agenda->title" required />
                        <x-admin.input name="slug" label="Slug" :value="$agenda->slug" hint="Otomatis diisi dari judul bila dikosongkan." />

                        <div>
                            <label for="description" class="mb-1.5 block text-sm font-medium text-ink-700">Deskripsi</label>
                            <textarea
                                id="description"
                                name="description"
                                rows="8"
                                x-data
                                x-init="initCkeditor($el)"
                                class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40"
                            >{{ old('description', $agenda->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="event_date" label="Tanggal Kegiatan" type="date" :value="$agenda->event_date->format('Y-m-d')" required />
                            <x-admin.input name="location" label="Lokasi" :value="$agenda->location" />
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-admin.input name="start_time" label="Jam Mulai" type="time" :value="$agenda->start_time?->format('H:i')" />
                            <x-admin.input name="end_time" label="Jam Selesai" type="time" :value="$agenda->end_time?->format('H:i')" />
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card title="Pengaturan">
                    <div class="space-y-4">
                        <x-admin.select name="status" label="Status" :options="$statuses" :selected="$agenda->status" />
                        <x-admin.checkbox name="is_featured" label="Jadikan agenda unggulan" :checked="$agenda->is_featured" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.content.agendas.index') }}" class="rounded-lg border border-ink-200 px-4 py-2 text-sm font-semibold text-ink-700 hover:bg-ink-50">
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
