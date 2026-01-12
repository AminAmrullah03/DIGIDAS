<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rekap Absensi') }} - Wali Santri</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/dashboard" class="flex items-center gap-2">
                        <span class="text-2xl">📚</span>
                        <span class="font-bold text-xl text-gray-900 dark:text-white">Rekap Absensi</span>
                    </a>
                </div>
                
                <div class="flex items-center gap-4">
                    @auth('wali')
                        <div class="hidden sm:flex items-center gap-3">
                            <a href="/dashboard" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium {{ request()->is('dashboard') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                Dashboard
                            </a>
                            <a href="/rekap" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 text-sm font-medium {{ request()->is('rekap') ? 'text-blue-600 dark:text-blue-400' : '' }}">
                                Rekap Lengkap
                            </a>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="text-sm text-gray-600 dark:text-gray-400 hidden sm:block">
                                {{ Auth::guard('wali')->user()->nama_wali }}
                            </span>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation -->
    @auth('wali')
    <div class="sm:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-around py-2">
            <a href="/dashboard" class="flex flex-col items-center px-4 py-2 text-xs {{ request()->is('dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }}">
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="/rekap" class="flex flex-col items-center px-4 py-2 text-xs {{ request()->is('rekap') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }}">
                <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Rekap
            </a>
        </div>
    </div>
    @endauth

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</body>
</html>
