@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
    <x-admin.page-header title="Edit Pengguna" description="Perbarui data akun dan role {{ $user->name }}." />

    <form method="POST" action="{{ route('admin.system.users.update', $user) }}" class="max-w-2xl">
        @csrf
        @method('PUT')

        <x-admin.card>
            <div class="grid gap-4">
                <x-admin.input name="name" label="Nama Lengkap" :value="$user->name" required autofocus />
                <x-admin.input name="email" label="Email" type="email" :value="$user->email" required />
                <x-admin.input name="password" label="Password Baru" type="password" hint="Kosongkan jika tidak ingin mengganti." />
                <x-admin.input name="password_confirmation" label="Konfirmasi Password" type="password" />
                <x-admin.checkbox name="is_active" label="Aktifkan akun" :checked="$user->is_active" />
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
                            @if (old('roles') ? in_array($role->slug, old('roles'), true) : $user->hasRole($role->slug)) checked @endif
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
                Simpan Perubahan
            </button>
            <a href="{{ route('admin.system.users.index') }}" class="rounded-lg border border-ink-300 px-5 py-2.5 text-sm font-semibold text-ink-700 transition hover:bg-ink-50">
                Batal
            </a>
        </div>
    </form>
@endsection
