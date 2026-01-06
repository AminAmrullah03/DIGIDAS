@if ($rekap->isEmpty())
    <div class="text-center py-16">
        <div class="mx-auto mb-3 w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tidak ada data absensi</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">Coba ubah tanggal atau pencarian.</p>
    </div>
@else
    <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow">
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

                        $waktu = \Carbon\Carbon::parse($a->waktu)->setTimezone('Asia/Jakarta')->format('H:i:s');
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
@endif
