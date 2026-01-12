<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Wali Santri - Rekap Absensi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-700 p-12 flex-col justify-between relative overflow-hidden">
            <!-- Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-8">
                    <span class="text-5xl">📚</span>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Rekap Absensi</h1>
                        <p class="text-emerald-100">Portal Wali Santri</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 space-y-6">
                <h2 class="text-2xl font-semibold text-white">Pantau Kehadiran Putra/Putri Anda</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Rekap Harian</h3>
                            <p class="text-emerald-100 text-sm">Lihat kehadiran harian anak Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Statistik Bulanan</h3>
                            <p class="text-emerald-100 text-sm">Pantau tren kehadiran setiap bulan</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Riwayat Lengkap</h3>
                            <p class="text-emerald-100 text-sm">Akses riwayat absensi kapan saja</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-emerald-100 text-sm">© {{ date('Y') }} Pondok Pesantren Darus Sholah</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <span class="text-5xl">📚</span>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mt-2">Rekap Absensi</h1>
                    <p class="text-gray-600 dark:text-gray-400">Portal Wali Santri</p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Login Wali Santri</h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-2">Masukkan NIS dan password Anda</p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ url('/login') }}">
                        @csrf

                        <!-- NIS -->
                        <div class="mb-5">
                            <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                    </svg>
                                    NIS Santri
                                </span>
                            </label>
                            <input id="nis" type="text" name="nis" value="{{ old('nis') }}" required autofocus
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                placeholder="Masukkan NIS santri">
                        </div>

                        <!-- Password -->
                        <div class="mb-5">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Password
                                </span>
                            </label>
                            <input id="password" type="password" name="password" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition"
                                placeholder="Masukkan password">
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center mb-6">
                            <input id="remember" type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-emerald-600 bg-gray-50 dark:bg-gray-700 focus:ring-emerald-500">
                            <label for="remember" class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</label>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Masuk
                        </button>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Hubungi admin jika belum memiliki akun
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
