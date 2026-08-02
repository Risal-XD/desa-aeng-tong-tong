@extends('admin.layouts.app')

@section('title', 'Kontak Desa')

@section('content')
    <x-admin.page-header title="Kontak Desa" description="Kelola informasi kontak dan media sosial yang tampil di halaman publik." />

    <form method="POST" action="{{ route('admin.service.contacts.update') }}">
        @csrf
        @method('PUT')

        <x-admin.card title="Informasi Kontak">
            <div class="grid gap-4 sm:grid-cols-2">
                <x-admin.input name="contact[contact_phone]" label="Telepon" :value="$contact['contact_phone'] ?? null" />
                <x-admin.input name="contact[contact_email]" label="Email" type="email" :value="$contact['contact_email'] ?? null" />
                <x-admin.input name="contact[contact_whatsapp]" label="WhatsApp" :value="$contact['contact_whatsapp'] ?? null" />
                <x-admin.input name="contact[office_hours]" label="Jam Operasional" :value="$contact['office_hours'] ?? null" />
            </div>
            <div class="mt-4">
                <x-admin.textarea name="contact[contact_address]" label="Alamat" rows="2" :value="$contact['contact_address'] ?? null" />
            </div>
        </x-admin.card>

        <div class="mt-4">
            <x-admin.card title="Media Sosial">
                <div class="grid gap-4 sm:grid-cols-2">
                    <x-admin.input name="sosmed[sosmed_facebook]" label="Facebook" type="url" :value="$sosmed['sosmed_facebook'] ?? null" />
                    <x-admin.input name="sosmed[sosmed_instagram]" label="Instagram" type="url" :value="$sosmed['sosmed_instagram'] ?? null" />
                    <x-admin.input name="sosmed[sosmed_twitter]" label="Twitter / X" type="url" :value="$sosmed['sosmed_twitter'] ?? null" />
                    <x-admin.input name="sosmed[sosmed_youtube]" label="YouTube" type="url" :value="$sosmed['sosmed_youtube'] ?? null" />
                    <x-admin.input name="sosmed[sosmed_tiktok]" label="TikTok" type="url" :value="$sosmed['sosmed_tiktok'] ?? null" />
                </div>
            </x-admin.card>
        </div>

        <div class="mt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                Simpan Kontak
            </button>
        </div>
    </form>
@endsection
