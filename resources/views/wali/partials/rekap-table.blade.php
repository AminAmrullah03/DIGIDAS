@php
    $rows = $rows ?? collect();
@endphp

<div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700 shadow">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">No</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">NIS</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kelas</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Kegiatan</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Waktu (WIB)</th>
                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
            @if($rows->isEmpty())
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">Tidak ada absensi pada tanggal ini</td>
                </tr>
            @else
                @foreach($rows as $i => $a)
                    @php
                        $santri = $a->santri;
                        $statusLabel = $a->status ?? '-';
                        $status = strtolower((string) $statusLabel);

                        $badge = match (true) {
                            str_contains($status, 'hadir') => 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200',
                            str_contains($status, 'izin') => 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200',
                            str_contains($status, 'alpha') => 'bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-200',
                            default => 'bg-slate-100 text-slate-800 dark:bg-slate-900/40 dark:text-slate-200'
                        };

                        $kegiatan = $a->jadwal->nama_kegiatan ?? $a->kegiatan ?? '-';
                        $waktu = \Carbon\Carbon::parse($a->waktu)->setTimezone('Asia/Jakarta')->format('H:i:s');
                    @endphp
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 transition">
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">{{ $santri->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm font-mono text-gray-800 dark:text-gray-100">{{ $a->nis }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $santri->kelas ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $kegiatan }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $waktu }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
