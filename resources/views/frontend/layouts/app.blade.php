<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (session('success'))
        <meta name="flash-success" content="{{ session('success') }}">
    @endif
    <meta name="description" content="@yield('meta_description', 'Website resmi Desa Aeng Tong-Tong, Kecamatan Saronggi, Kabupaten Sumenep, Jawa Timur — desa wisata sentra kerajinan keris.')">
    <title>@yield('title', 'Desa Aeng Tong-Tong') · Website Resmi Desa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|instrument-serif:400,500,600" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="flex min-h-screen flex-col bg-ink-50 font-sans text-ink-700 antialiased">
    <x-frontend.navbar />

    <main class="flex-1">
        @yield('content')
    </main>

    <x-frontend.footer />

    @stack('scripts')
</body>
</html>
