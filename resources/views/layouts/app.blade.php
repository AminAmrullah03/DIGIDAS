<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- ── PWA Meta ── --}}
        <meta name="theme-color" content="#059669">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="DIGIDAS">
        <meta name="application-name" content="DIGIDAS">
        <meta name="description" content="Aplikasi Sistem Digital untuk Pondok Pesantren Darus Sholah Jember">

        {{-- ── Icons ── --}}
        <link rel="icon" type="image/png" href="{{ asset('images/logo1.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
        <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/icon-192.png') }}">
        <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('images/icon-512.png') }}">

        {{-- ── Manifest ── --}}
        <link rel="manifest" href="{{ asset('manifest.json') }}">

        <title>DIGIDAS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- ── Register Service Worker ── --}}
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker
                        .register('/sw.js', { scope: '/' })
                        .then(reg => {
                            console.log('[DIGIDAS] SW registered:', reg.scope);

                            // Cek update SW
                            reg.addEventListener('updatefound', () => {
                                const newSW = reg.installing;
                                newSW.addEventListener('statechange', () => {
                                    if (newSW.state === 'installed' && navigator.serviceWorker.controller) {
                                        console.log('[DIGIDAS] Update tersedia, refresh untuk memperbarui.');
                                    }
                                });
                            });
                        })
                        .catch(err => console.warn('[DIGIDAS] SW gagal register:', err));
                });
            }
        </script>
    </body>
</html>