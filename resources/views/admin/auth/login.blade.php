<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#012d1d]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk · {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    <style>
        @keyframes login-border-beam {
            to { offset-distance: 100%; }
        }
        .login-beam {
            offset-path: rect(0 auto auto 0 round 1.5rem);
            animation: login-border-beam 4s linear infinite;
        }
    </style>
</head>
<body class="relative flex min-h-screen items-center justify-center bg-primary px-4 py-12 text-on-primary">
    <div class="pointer-events-none fixed inset-0 bg-[radial-gradient(circle_at_top_left,rgba(134,175,153,0.28),transparent_34%),radial-gradient(circle_at_bottom_right,rgba(125,86,45,0.24),transparent_38%)]"></div>
    <div class="pointer-events-none fixed inset-0 opacity-30 [background-image:linear-gradient(rgba(255,255,255,.05)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.05)_1px,transparent_1px)] [background-size:32px_32px]"></div>

    <main class="relative w-full max-w-md [perspective:1200px]">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-on-primary/20 bg-on-primary/10 shadow-2xl backdrop-blur">
                <svg class="h-8 w-8 text-secondary-container" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.5 2 20 7.5 8 19.5 3 21l1.5-5L14.5 2z"/>
                    <path d="M12 8l4 4"/>
                </svg>
            </div>
            <h1 class="mt-5 font-display text-2xl font-semibold tracking-tight text-white">Panel Administrasi</h1>
            <p class="mt-2 text-sm text-on-primary-container">Desa Aeng Tong-Tong</p>
        </div>

        <section
            x-data="card3D"
            @mousemove="handleMove($event)"
            @mouseleave="handleLeave()"
            :style="`transform: rotateX(${rotateX}deg) rotateY(${rotateY}deg); transition: transform 100ms ease-out;`"
            class="relative overflow-hidden rounded-3xl border border-on-primary/15 bg-primary-container/25 p-px shadow-2xl backdrop-blur-xl [transform-style:preserve-3d]"
        >
            <span class="login-beam pointer-events-none absolute left-0 top-0 h-20 w-20 rounded-full bg-secondary-container/90 blur-xl"></span>
            <div class="relative rounded-[1.4rem] bg-primary/90 p-6 sm:p-8">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary-container">Akses Terbatas</p>
                    <h2 class="mt-2 font-display text-xl font-semibold text-white">Masuk ke akun Anda</h2>
                    <p class="mt-2 text-sm leading-relaxed text-on-primary-container">Gunakan kredensial administrator yang terdaftar.</p>
                </div>

                @if ($errors->any())
                    <div class="mt-5 rounded-xl border border-error/40 bg-error/10 px-4 py-3 text-sm text-red-100" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-7 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-on-primary">Alamat Email</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-on-primary-container" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@aengtongtong.desa.id" class="w-full rounded-xl border border-on-primary/15 bg-on-primary/10 py-3 pl-11 pr-4 text-sm text-white placeholder-on-primary-container outline-none transition focus:border-secondary-container focus:bg-on-primary/15 focus:ring-2 focus:ring-secondary-container/30">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-on-primary">Kata Sandi</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-on-primary-container" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full rounded-xl border border-on-primary/15 bg-on-primary/10 py-3 pl-11 pr-4 text-sm text-white placeholder-on-primary-container outline-none transition focus:border-secondary-container focus:bg-on-primary/15 focus:ring-2 focus:ring-secondary-container/30">
                        </div>
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-on-primary-container">
                        <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-on-primary/30 bg-on-primary/10 text-secondary focus:ring-secondary-container">
                        Ingat saya di perangkat ini
                    </label>

                    <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-secondary px-4 py-3 text-sm font-semibold text-on-secondary shadow-lg shadow-secondary/20 transition hover:bg-secondary-container hover:text-on-secondary-container focus:outline-none focus:ring-2 focus:ring-secondary-container focus:ring-offset-2 focus:ring-offset-primary">
                        Masuk ke Panel
                        <svg class="h-4 w-4 transition group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>

                <p class="mt-6 border-t border-on-primary/10 pt-5 text-center text-xs leading-relaxed text-on-primary-container">Dibatasi hingga 5 percobaan masuk per menit untuk setiap email dan alamat IP.</p>
            </div>
        </section>

        <p class="mt-7 text-center text-xs text-on-primary-container/80">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </main>
</body>
</html>
