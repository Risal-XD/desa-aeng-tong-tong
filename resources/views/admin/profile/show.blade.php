@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-ink-900">Profil Saya</h1>
        <p class="mt-1 text-sm text-ink-500">Perbarui informasi akun dan kata sandi Anda.</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <x-admin.card title="Informasi Akun">
            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-full bg-brand-100 text-xl font-bold text-brand-800">
                        @if ($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                        @else
                            {{ mb_substr($user->name, 0, 1) }}
                        @endif
                    </div>
                    <div>
                        <label for="avatar" class="cursor-pointer rounded-md border border-ink-300 bg-white px-3 py-1.5 text-sm text-ink-700 hover:bg-ink-50">
                            Ganti Foto
                        </label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="hidden">
                    </div>
                </div>

                <div>
                    <label for="name" class="mb-1.5 block text-sm font-medium text-ink-700">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40
                            {{ $errors->has('name') ? 'border-red-500' : '' }}">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-ink-700">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40
                            {{ $errors->has('email') ? 'border-red-500' : '' }}">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="border-t border-ink-100 pt-4">
                    <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </x-admin.card>

        <x-admin.card title="Ganti Kata Sandi">
            <form method="POST" action="{{ route('admin.profile.update-password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="mb-1.5 block text-sm font-medium text-ink-700">Kata Sandi Saat Ini</label>
                    <input id="current_password" type="password" name="current_password" required autocomplete="current-password"
                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40
                            {{ $errors->has('current_password') ? 'border-red-500' : '' }}">
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-ink-700">Kata Sandi Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40
                            {{ $errors->has('password') ? 'border-red-500' : '' }}">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-ink-700">Ulangi Kata Sandi Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full rounded-lg border border-ink-300 px-3 py-2.5 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40">
                </div>

                <p class="text-xs text-ink-500">Minimal 8 karakter, mengandung huruf dan angka.</p>

                <div class="border-t border-ink-100 pt-4">
                    <button type="submit" class="rounded-lg bg-ink-900 px-4 py-2 text-sm font-semibold text-white hover:bg-ink-800">
                        Ganti Kata Sandi
                    </button>
                </div>
            </form>
        </x-admin.card>
    </div>
@endsection
