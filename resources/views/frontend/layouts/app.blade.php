<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (session('success'))
        <meta name="flash-success" content="{{ session('success') }}">
    @endif

    @php
        $seoSettings = app(App\Services\SettingService::class);
        $siteName = $seoSettings->get('site_name', 'Desa Aeng Tong-Tong');
        $seoDescription = $seoSettings->get('meta_description', 'Website resmi Desa Aeng Tong-Tong, Kecamatan Saronggi, Kabupaten Sumenep, Jawa Timur.');
        $siteLogo = $seoSettings->get('site_logo');
        
        $pageTitle = trim($__env->yieldContent('title'));
        $pageTitle = $pageTitle !== '' ? $pageTitle : 'Beranda';
        
        $pageDescription = trim($__env->yieldContent('meta_description'));
        $pageDescription = $pageDescription !== '' ? $pageDescription : $seoDescription;
        
        $canonicalUrl = trim($__env->yieldContent('canonical'));
        $canonicalUrl = $canonicalUrl !== '' ? $canonicalUrl : url()->current();
        
        $ogImage = trim($__env->yieldContent('og_image'));
        $ogImage = $ogImage ? url($ogImage) : ($siteLogo ? \Illuminate\Support\Facades\Storage::url($siteLogo) : null);
        
        $ogType = trim($__env->yieldContent('og_type'));
        $ogType = $ogType !== '' ? $ogType : 'website';
        
        $robots = trim($__env->yieldContent('robots'));
        $robots = $robots !== '' ? $robots : 'index, follow';
    @endphp

    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $robots }}">
    <meta name="author" content="{{ $siteName }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <title>{{ $pageTitle !== 'Beranda' ? $pageTitle . ' · ' . $siteName : $siteName }}</title>

    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    @if ($ogImage)
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    @if ($ogImage)
        <meta name="twitter:image" content="{{ $ogImage }}">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=be-vietnam-pro:400,500,600,700|work-sans:400,500,600" rel="stylesheet">

    @vite(['resources/css/frontend.css', 'resources/js/app.js'])
    @stack('styles')

    @php
        $at = '@';
    @endphp
    <script type="application/ld+json">
    {
        "{{ $at }}context": "https://schema.org",
        "{{ $at }}type": "WebSite",
        "name": {{ Illuminate\Support\Js::from($siteName) }},
        "url": {{ Illuminate\Support\Js::from(url('/')) }},
        "description": {{ Illuminate\Support\Js::from($seoDescription) }},
        "inLanguage": "id-ID",
        "publisher": {
            "{{ $at }}type": "Organization",
            "name": {{ Illuminate\Support\Js::from($siteName) }}
        }
    }
    </script>
</head>
<body class="flex min-h-screen flex-col bg-surface font-sans text-on-surface antialiased">
    <a href="#konten-utama" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-ink-900 focus:px-4 focus:py-2 focus:text-white">
        Langsung ke konten utama
    </a>

    <x-frontend.navbar />

    <main id="konten-utama" class="flex-1">
        @yield('content')
    </main>

    <x-frontend.footer />

    @stack('scripts')
</body>
</html>
