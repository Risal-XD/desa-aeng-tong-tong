<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-ink-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/admin.js'])
</head>
<body class="flex min-h-full items-center justify-center bg-ink-950 px-4 py-10">
    <div class="w-full max-w-md">
        <div class="mb-6 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-500 text-xl font-bold text-white shadow-lg shadow-brand-500/30">
                AT
            </div>
            <h1 class="mt-4 text-2xl font-bold text-white">Desa Aeng Tong-Tong</h1>
            <p class="mt-1 text-sm text-ink-400">Panel Administrasi Website Desa</p>
        </div>

        <div class="rounded-2xl border border-ink-800 bg-ink-900 p-6 shadow-xl sm:p-8">
            <h2 class="text-lg font-semibold text-white">Masuk ke Akun</h2>
            <p class="mt-1 text-sm text-ink-400">Gunakan akun yang telah diberikan oleh administrator.</p>

            <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-ink-200">Alamat Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full rounded-lg border bg-ink-950 px-3 py-2.5 text-sm text-white placeholder-ink-500 outline-none transition
                            {{ $errors->has('email') ? 'border-red-500 focus:ring-2 focus:ring-red-500/40' : 'border-ink-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40' }}"
                        placeholder="admin@aengtongtong.desa.id"
                    >
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-ink-200">Kata Sandi</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-lg border bg-ink-950 px-3 py-2.5 text-sm text-white placeholder-ink-500 outline-none transition
                            {{ $errors->has('password') ? 'border-red-500 focus:ring-2 focus:ring-red-500/40' : 'border-ink-700 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/40' }}"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-ink-300">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-ink-600 bg-ink-950 text-brand-500 focus:ring-brand-500">
                        Ingat saya
                    </label>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-600 focus:ring-2 focus:ring-brand-500/50"
                >
                    Masuk
                </button>
            </form>
        </div>

        <p class="mt-6 text-center text-xs text-ink-500">
            &copy; {{ date('Y') }} {{ config('app.name') }} · Sentra Kerajinan Keris, Sumenep
        </p>
    </div>
</body>
</html>
