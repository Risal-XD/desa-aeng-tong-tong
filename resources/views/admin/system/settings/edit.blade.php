@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
    <x-admin.page-header title="Pengaturan Website" description="Kelola identitas, SEO, kontak, dan media sosial website." />

    <form method="POST" action="{{ route('admin.system.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div x-data="{ tab: 'general' }">
            <div class="mb-4 flex flex-wrap gap-2">
                @foreach ([
                    'general' => 'Umum',
                    'seo' => 'SEO',
                    'contact' => 'Kontak',
                    'sosmed' => 'Media Sosial',
                ] as $key => $label)
                    <button
                        type="button"
                        @click="tab = '{{ $key }}'"
                        class="rounded-lg px-4 py-2 text-sm font-semibold transition"
                        :class="tab === '{{ $key }}' ? 'bg-brand-500 text-white' : 'bg-white text-ink-600 border border-ink-200 hover:bg-ink-50'"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>

            <x-admin.card>
                <div x-show="tab === 'general'" x-cloak>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.input name="general[site_name]" label="Nama Situs" :value="$general['site_name'] ?? null" required />
                        <x-admin.input name="general[site_tagline]" label="Tagline" :value="$general['site_tagline'] ?? null" />
                    </div>
                    <div class="mt-4">
                        <x-admin.textarea name="general[site_description]" label="Deskripsi Singkat" rows="3" :value="$general['site_description'] ?? null" />
                    </div>
                    <div class="mt-4">
                        <x-admin.file-input
                            name="general[site_logo]"
                            label="Logo Website"
                            accept="image/*"
                            hint="PNG/JPG/SVG/WebP, maks. 2 MB"
                            :preview="$general['site_logo'] ?? null ? asset('storage/'.$general['site_logo']) : null"
                        />
                    </div>
                </div>

                <div x-show="tab === 'seo'" x-cloak>
                    <div class="grid gap-4">
                        <x-admin.input name="seo[meta_title]" label="Meta Title" :value="$seo['meta_title'] ?? null" />
                        <x-admin.input name="seo[meta_keywords]" label="Meta Keywords" hint="Pisahkan dengan koma." :value="$seo['meta_keywords'] ?? null" />
                    </div>
                    <div class="mt-4">
                        <x-admin.textarea name="seo[meta_description]" label="Meta Description" rows="3" :value="$seo['meta_description'] ?? null" />
                    </div>
                </div>

                <div x-show="tab === 'contact'" x-cloak>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.input name="contact[contact_phone]" label="Telepon" :value="$contact['contact_phone'] ?? null" />
                        <x-admin.input name="contact[contact_email]" label="Email" type="email" :value="$contact['contact_email'] ?? null" />
                        <x-admin.input name="contact[contact_whatsapp]" label="WhatsApp" :value="$contact['contact_whatsapp'] ?? null" />
                        <x-admin.input name="contact[office_hours]" label="Jam Operasional" :value="$contact['office_hours'] ?? null" />
                    </div>
                    <div class="mt-4">
                        <x-admin.textarea name="contact[contact_address]" label="Alamat" rows="2" :value="$contact['contact_address'] ?? null" />
                    </div>
                </div>

                <div x-show="tab === 'sosmed'" x-cloak>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-admin.input name="sosmed[sosmed_facebook]" label="Facebook" type="url" :value="$sosmed['sosmed_facebook'] ?? null" />
                        <x-admin.input name="sosmed[sosmed_instagram]" label="Instagram" type="url" :value="$sosmed['sosmed_instagram'] ?? null" />
                        <x-admin.input name="sosmed[sosmed_twitter]" label="Twitter / X" type="url" :value="$sosmed['sosmed_twitter'] ?? null" />
                        <x-admin.input name="sosmed[sosmed_youtube]" label="YouTube" type="url" :value="$sosmed['sosmed_youtube'] ?? null" />
                        <x-admin.input name="sosmed[sosmed_tiktok]" label="TikTok" type="url" :value="$sosmed['sosmed_tiktok'] ?? null" />
                    </div>
                </div>
            </x-admin.card>
        </div>

        <div class="mt-4">
            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
