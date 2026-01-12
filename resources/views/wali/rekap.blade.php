<x-wali-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Rekap Absensi
                        </h1>
                        @if($santri)
                        <p class="text-gray-500 dark:text-gray-400 mt-1">
                            {{ $santri->nama }} ({{ $santri->kelas }})
                        </p>
                        @endif
                    </div>
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Filter Bulan -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <form method="GET" action="{{ url('/rekap') }}" class="flex flex-wrap items-end gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select name="bulan" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-emerald-500">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select name="tahun" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:ring-2 focus:ring-emerald-500">
                            @for($y = now()->year; $y >= now()->year - 2; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition">
                        Tampilkan
                    </button>
                </form>
            </div>

            <!-- Tabel Rekap -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Rekap Bulan {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }}
                    </h2>
                </div>

                @if($rekap->isEmpty())
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada data absensi untuk periode ini</p>
                </div>
                @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Hari</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kegiatan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Waktu</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($rekap as $i => $absen)
                            @php
                                $status = strtolower($absen->status ?? '');
                                $badge = match (true) {
                                    str_contains($status, 'hadir') => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                                    str_contains($status, 'izin') => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                                    str_contains($status, 'sakit') => 'bg-blue-100 text-blue-800 dark:bg-blue-900/40 dark:text-blue-200',
                                    str_contains($status, 'alpha') => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                                    default => 'bg-slate-100 text-slate-800 dark:bg-slate-900/40 dark:text-slate-200'
                                };
                                $waktu = \Carbon\Carbon::parse($absen->waktu);
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700/50">
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $i + 1 }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $waktu->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $waktu->translatedFormat('l') }}</td>
                                <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $absen->kegiatan }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $waktu->format('H:i') }} WIB</td>
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

                <!-- Summary -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex flex-wrap gap-6">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Hadir: <strong>{{ $rekap->where('status', 'Hadir')->count() }}</strong>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Izin: <strong>{{ $rekap->where('status', 'Izin')->count() }}</strong>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Sakit: <strong>{{ $rekap->where('status', 'Sakit')->count() }}</strong>
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-sm text-gray-600 dark:text-gray-300">
                                Alpha: <strong>{{ $rekap->where('status', 'Alpha')->count() }}</strong>
                            </span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-wali-layout>
