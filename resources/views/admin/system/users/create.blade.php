@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <x-admin.page-header title="Tambah Pengguna" description="Buat akun baru untuk pengelola website." />

    <form method="POST" action="{{ route('admin.system.users.store') }}" class="max-w-2xl">
        @csrf

        <x-admin.card>
            <div class="grid gap-4">
                <x-admin.input name="name" label="Nama Lengkap" required autofocus />
                <x-admin.input name="email" label="Email" type="email" required />
                <x-admin.input name="password" label="Password" type="password" required hint="Minimal 8 karakter." />
                <x-admin.input name="password_confirmation" label="Konfirmasi Password" type="password" required />
                <x-admin.checkbox name="is_active" label="Aktifkan akun" :checked="true" />
            </div>
        </x-admin.card>

        <x-admin.card title="Role">
            <div class="grid gap-2 sm:grid-cols-2">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-2 rounded-lg border border-ink-200 px-3 py-2 text-sm text-ink-700 hover:bg-ink-50">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->slug }}"
                            @if (old('roles') && in_array($role->slug, old('roles'), true)) checked @endif
                            class="h-4 w-4 rounded border-ink-300 text-brand-600 focus:ring-brand-500"
                        >
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
            @error('roles')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </x-admin.card>

        <div class="mt-4 flex gap-2">
            <button type="submit" class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                Simpan Pengguna
            </button>
            <a href="{{ route('admin.system.users.index') }}" class="rounded-lg border border-ink-300 px-5 py-2.5 text-sm font-semibold text-ink-700 transition hover:bg-ink-50">
                Batal
            </a>
        </div>
    </form>
@endsection
