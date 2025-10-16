<x-app-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden transition border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            📋 Rekap Absensi Santri
                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                            {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                    <a href="/dashboard" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9m0 0l9 9m-9-9v18" />
                        </svg>
                        Kembali
                    </a>
                </div>

                <div class="p-6">
                    @if ($rekap->isEmpty())
                        <div class="text-center py-16">
                            <div class="mx-auto mb-3 w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Belum ada absensi hari ini</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Data akan muncul setelah santri melakukan absen.</p>
                        </div>
                    @else
                    <div class="space-y-6">
                        <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">No</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">NIS</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Nama</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kelas</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kegiatan</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Waktu (WIB)</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach ($rekap as $i => $a)
                                        @php
                                            $status = strtolower($a->status ?? '');
                                            $badge = match (true) {
                                                str_contains($status, 'hadir') => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                                                str_contains($status, 'izin') => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                                                str_contains($status, 'alpha') => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                                                default => 'bg-slate-100 text-slate-800 dark:bg-slate-900/40 dark:text-slate-200'
                                            };

                                            $waktu = \Carbon\Carbon::parse($a->waktu)
                                                ->setTimezone('Asia/Jakarta')
                                                ->format('H:i:s');
                                        @endphp

                                        <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition">
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $i + 1 }}</td>
                                            <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-gray-100">{{ $a->nis }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $a->santri->nama ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $a->santri->kelas ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $a->kegiatan ?? '-' }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $waktu }}</td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                                    {{ ucfirst($a->status ?? '-') }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden space-y-3">
                            @foreach ($rekap as $i => $a)
                                @php
                                    $status = strtolower($a->status ?? '');
                                    $badge = match (true) {
                                        str_contains($status, 'hadir') => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                                        str_contains($status, 'izin') => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                                        str_contains($status, 'alpha') => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                                        default => 'bg-slate-100 text-slate-800 dark:bg-slate-900/40 dark:text-slate-200'
                                    };

                                    $waktu = \Carbon\Carbon::parse($a->waktu)
                                        ->setTimezone('Asia/Jakarta')
                                        ->format('H:i:s');
                                @endphp

                                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $a->santri->nama ?? '-' }}</div>
                                            <div class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">NIS {{ $a->nis }} • {{ $a->santri->kelas ?? '-' }}</div>
                                        </div>
                                        <span class="shrink-0 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($a->status ?? '-') }}</span>
                                    </div>
                                    <div class="mt-3 grid grid-cols-2 gap-3 text-xs">
                                        <div class="rounded-lg bg-gray-50 dark:bg-gray-700/50 p-2">
                                            <div class="text-gray-500 dark:text-gray-400">Kegiatan</div>
                                            <div class="mt-0.5 font-medium text-gray-800 dark:text-gray-100">{{ $a->kegiatan ?? '-' }}</div>
                                        </div>
                                        <div class="rounded-lg bg-gray-50 dark:bg-gray-700/50 p-2">
                                            <div class="text-gray-500 dark:text-gray-400">Waktu (WIB)</div>
                                            <div class="mt-0.5 font-medium text-gray-800 dark:text-gray-100">{{ $waktu }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
