<x-wali-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl p-6 mb-8 text-white shadow-lg">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold mb-2">
                            Assalamu'alaikum, {{ $wali->nama_wali }} 👋
                        </h1>
                        <p class="text-emerald-100">
                            Portal Rekap Absensi - Pondok Pesantren Darus Sholah
                        </p>
                    </div>
                    <div class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Info Santri -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Santri
                </h2>
                @if($santri)
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nama</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $santri->nama }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">NIS</p>
                        <p class="font-semibold text-gray-900 dark:text-white font-mono">{{ $santri->nis }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelas</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $santri->kelas }}</p>
                    </div>
                </div>
                @else
                <p class="text-gray-500 dark:text-gray-400">Data santri tidak ditemukan.</p>
                @endif
            </div>

            <!-- Statistik Bulan Ini -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
                <!-- Hadir -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hadir</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Bulan {{ now()->translatedFormat('F Y') }}</p>
                </div>

                <!-- Izin/Sakit -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Izin/Sakit</p>
                            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $totalIzin }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Bulan {{ now()->translatedFormat('F Y') }}</p>
                </div>

                <!-- Alpha -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Alpha</p>
                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $totalAlpha }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">Bulan {{ now()->translatedFormat('F Y') }}</p>
                </div>
            </div>

            <!-- Rekap 7 Hari Terakhir -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Kehadiran 7 Hari Terakhir
                    </h2>
                    <a href="{{ url('/rekap') }}" class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 font-medium">
                        Lihat semua →
                    </a>
                </div>

                @if($rekapMingguan->isEmpty())
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada data absensi dalam 7 hari terakhir</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kegiatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Waktu</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($rekapMingguan as $absen)
                            @php
                                $status = strtolower($absen->status ?? '');
                                $badge = match (true) {
                                    str_contains($status, 'hadir') => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                                    str_contains($status, 'izin') => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                                    str_contains($status, 'sakit') => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
                                    str_contains($status, 'alpha') => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                                    default => 'bg-slate-100 text-slate-800 dark:bg-slate-900/40 dark:text-slate-200'
                                };
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700/50">
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($absen->waktu)->translatedFormat('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $absen->kegiatan }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($absen->waktu)->format('H:i') }} WIB
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                        {{ ucfirst($absen->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-wali-layout>
