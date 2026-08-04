<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-surface">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|work-sans:400,500,600,700|jetbrains-mono:400,500,600" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/admin.js'])
    @stack('styles')

    <script>
        // Polyfill x-collapse for older Alpine versions
        document.addEventListener('alpine:init', () => {
            if (window.Alpine && !window.Alpine.directive('collapse')) {
                window.Alpine.directive('collapse', (el, {}, { effect }) => {
                    effect(() => {
                        const show = el.style.display !== 'none';
                        el.style.display = show ? 'none' : '';
                    });
                });
            }
        });
    </script>
</head>
<body class="h-full bg-surface font-sans text-on-surface antialiased">
    <div x-data="{ sidebarOpen: true }" class="min-h-full lg:flex">
        <x-admin.sidebar />

        <div class="flex min-w-0 flex-1 flex-col">
            <x-admin.topbar />

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <x-admin.flash />
                @yield('content')
            </main>

            <footer class="border-t border-ink-200 bg-white px-6 py-3 text-center text-xs text-ink-500">
                &copy; {{ date('Y') }} {{ config('app.name') }} · Kec. Saronggi, Kab. Sumenep, Jawa Timur
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
