<x-app-layout>
    <div class="py-6 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">📊 Rekap Pembayaran SPP</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Data pembayaran SPP seluruh santri - Tahun {{ $tahun }} H</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('spp.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Input Pembayaran
                        </a>
                    </div>
                </div>

                <!-- Filter -->
                <form method="GET" class="mt-4 flex flex-wrap gap-3 items-end">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun Hijriah</label>
                        <select name="tahun" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @for($y = 1448; $y >= 1444; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }} H</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kelas</label>
                        <select name="kelas" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Kelas</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas }}" {{ $kelasFilter == $kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-all duration-200">
                        🔍 Filter
                    </button>
                </form>
            </div>

            <!-- Tabel Rekap SPP -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="sticky left-0 z-10 bg-gray-100 dark:bg-gray-700 px-3 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 border-r border-gray-200 dark:border-gray-600">No</th>
                                <th class="sticky left-10 z-10 bg-gray-100 dark:bg-gray-700 px-3 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 border-r border-gray-200 dark:border-gray-600 min-w-[100px]">NIS</th>
                                <th class="sticky left-28 z-10 bg-gray-100 dark:bg-gray-700 px-3 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 border-r border-gray-200 dark:border-gray-600 min-w-[180px]">Nama</th>
                                <th class="sticky left-56 z-10 bg-gray-100 dark:bg-gray-700 px-3 py-3 text-left font-semibold text-gray-700 dark:text-gray-200 border-r border-gray-200 dark:border-gray-600 min-w-[100px]">Kelas</th>
                                @php
                                    $bulanHijriah = [
                                        1 => 'Muh', 2 => 'Saf', 3 => 'R.Aw', 4 => 'R.Ak',
                                        5 => 'J.Aw', 6 => 'J.Ak', 7 => 'Raj', 8 => 'Sya',
                                        9 => 'Ram', 10 => 'Syw', 11 => 'Dzq', 12 => 'Dzh'
                                    ];
                                    $bulanFull = [
                                        1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal', 4 => 'Rabiul Akhir',
                                        5 => 'Jumadil Awal', 6 => 'Jumadil Akhir', 7 => 'Rajab', 8 => 'Syaban',
                                        9 => 'Ramadhan', 10 => 'Syawal', 11 => 'Dzulqaidah', 12 => 'Dzulhijjah'
                                    ];
                                @endphp
                                @for($b = 1; $b <= 12; $b++)
                                    <th class="px-2 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 min-w-[60px]" title="{{ $bulanFull[$b] }}">{{ $bulanHijriah[$b] }}</th>
                                @endfor
                                <th class="px-3 py-3 text-center font-semibold text-gray-700 dark:text-gray-200 bg-blue-100 dark:bg-blue-900 min-w-[100px]">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($rekapData as $index => $data)
                                @php
                                    $totalBayar = 0;
                                    $totalTagihan = 0;
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="sticky left-0 z-10 bg-white dark:bg-gray-800 px-3 py-2 text-gray-700 dark:text-gray-300 border-r border-gray-100 dark:border-gray-700">{{ $index + 1 }}</td>
                                    <td class="sticky left-10 z-10 bg-white dark:bg-gray-800 px-3 py-2 font-mono text-gray-900 dark:text-white border-r border-gray-100 dark:border-gray-700">{{ $data['santri']->nis }}</td>
                                    <td class="sticky left-28 z-10 bg-white dark:bg-gray-800 px-3 py-2 font-medium text-gray-900 dark:text-white border-r border-gray-100 dark:border-gray-700">{{ $data['santri']->nama }}</td>
                                    <td class="sticky left-56 z-10 bg-white dark:bg-gray-800 px-3 py-2 text-gray-700 dark:text-gray-300 border-r border-gray-100 dark:border-gray-700">{{ $data['santri']->kelas }}</td>
                                    @for($b = 1; $b <= 12; $b++)
                                        @php
                                            $tagihan = $data['tagihan'][$b] ?? null;
                                            $status = $tagihan ? $tagihan->status : 'belum';
                                            $nominal = $tagihan ? $tagihan->nominal : 50000;
                                            $totalTagihan += $nominal;
                                            if ($status === 'lunas') $totalBayar += $nominal;
                                            elseif ($status === 'sebagian') {
                                                $bayar = \App\Models\SppPembayaran::where('nis', $data['santri']->nis)
                                                    ->where('bulan', $b)->where('tahun', $tahun)->sum('nominal_bayar');
                                                $totalBayar += $bayar;
                                            }
                                        @endphp
                                        <td class="px-2 py-2 text-center">
                                            @if($status === 'lunas')
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400" title="Lunas">✔</span>
                                            @elseif($status === 'sebagian')
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400" title="Sebagian">◐</span>
                                            @else
                                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400" title="Belum">✗</span>
                                            @endif
                                        </td>
                                    @endfor
                                    <td class="px-3 py-2 text-center font-semibold bg-blue-50 dark:bg-blue-900/30">
                                        @if($totalBayar >= $totalTagihan)
                                            <span class="text-green-600 dark:text-green-400">Lunas</span>
                                        @else
                                            <span class="text-red-600 dark:text-red-400">{{ number_format($totalTagihan - $totalBayar, 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="17" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2 opacity-50">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                            <p>Belum ada data santri</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-4 bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Keterangan:</p>
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400">✔</span>
                        <span class="text-gray-600 dark:text-gray-400">Lunas</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400">◐</span>
                        <span class="text-gray-600 dark:text-gray-400">Sebagian</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400">✗</span>
                        <span class="text-gray-600 dark:text-gray-400">Belum Bayar</span>
                    </div>
                    <div class="ml-auto text-gray-600 dark:text-gray-400">
                        SPP per bulan: <strong class="text-gray-900 dark:text-white">Rp 50.000</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
