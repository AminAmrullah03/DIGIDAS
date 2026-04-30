<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/ppd.png') }}">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#059669">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-title" content="DIGIDAS">
        <link rel="apple-touch-icon" href="/images/icon-192.png">

        <title>Login - DIGIDAS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding (Hidden on mobile) -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                            </pattern>
                        </defs>
                        <rect width="100" height="100" fill="url(#grid)" />
                    </svg>
                </div>
                
                <!-- Content -->
                <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                    <div>
                        <img src="{{ asset('images/ppd.png') }}" alt="Logo" class="object-contain drop-shadow-2xl" style="width: 450px; height: 450px;">
                    </div>
                    <h1 class="text-4xl font-bold text-center mb-4">DIGIDAS <br> Digital Sistem Darus Sholah</h1>
                    <p class="text-xl text-blue-100 text-center mb-8">Pondok Pesantren Darus Sholah</p>
                    
                    <!-- Features -->
                    <!-- <div class="space-y-4 mt-8">
                        <div class="flex items-center gap-3 text-blue-100">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                </svg>
                            </div>
                            <span>Scan QR Code Cepat & Akurat</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-100">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </div>
                            <span>Rekap Otomatis Real-time</span>
                        </div>
                        <div class="flex items-center gap-3 text-blue-100">
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                            </div>
                            <span>Jadwal Kegiatan Fleksibel</span>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50 dark:bg-gray-900">
                <!-- Mobile Logo -->
                <div class="lg:hidden mb-8 text-center">
                    <img src="{{ asset('images/ppd.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Digital System</h1>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Darus Sholah</h1>
                </div>

                <div class="w-full max-w-md">
                    <!-- Login Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
                        {{ $slot }}
                    </div>

                    <!-- Footer -->
                    <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
                        &copy; {{ date('Y') }} Digital System Darus Sholah
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
