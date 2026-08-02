@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Selamat Datang, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-1 text-sm text-ink-500">
            Ringkasan kondisi Website Profil Desa Aeng Tong-Tong.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Pengguna Aktif</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['active_users'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Peran (Role)</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['total_roles'] }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-violet-100 text-violet-700">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-ink-500">Izin (Permission)</p>
                    <p class="text-2xl font-bold text-ink-900">{{ $stats['total_permissions'] }}</p>
                </div>
            </div>
        </x-admin.card>
    </div>

    <div class="mt-6">
        <x-admin.card title="Catatan Pengembangan">
            <p class="text-sm text-ink-600">
                Modul Autentikasi &amp; RBAC telah aktif. Menu di sisi kiri akan bertambah seiring
                penyelesaian modul berikutnya (Master Data, Konten, Media, Ekonomi &amp; Budaya, Data &amp; Laporan,
                dan Sistem).
            </p>
        </x-admin.card>
    </div>
@endsection
