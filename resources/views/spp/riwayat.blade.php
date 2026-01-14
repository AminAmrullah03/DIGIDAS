<x-app-layout>
    @php
        $bulanHijriah = [
            1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal', 4 => 'Rabiul Akhir',
            5 => 'Jumadil Awal', 6 => 'Jumadil Akhir', 7 => 'Rajab', 8 => 'Syaban',
            9 => 'Ramadhan', 10 => 'Syawal', 11 => 'Dzulqaidah', 12 => 'Dzulhijjah'
        ];
    @endphp
    <div class="py-12 transition-colors duration-300 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">📜 Riwayat Pembayaran SPP</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Daftar transaksi pembayaran SPP</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('spp.rekap') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-white font-medium transition-all duration-200">
                            📊 Rekap
                        </a>
                        <a href="{{ route('spp.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Input Pembayaran
                        </a>
                    </div>
                </div>

                <!-- Filter -->
                <form method="GET" class="mt-4 flex flex-wrap gap-3">
                    <input type="text" name="nis" value="{{ $nis }}" placeholder="Filter NIS..."
                        class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <select name="tahun" class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @for($y = 1448; $y >= 1444; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }} H</option>
                        @endfor
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-white font-medium transition-all duration-200">
                        🔍 Filter
                    </button>
                </form>
            </div>

            <!-- Tabel -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bulan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Metode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($pembayaran as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->nis }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->santri->nama ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $bulanHijriah[$item->bulan] ?? '-' }} {{ $item->tahun }} H
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600 dark:text-green-400">
                                        Rp {{ number_format($item->nominal_bayar, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($item->metode === 'cash')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                💵 Cash
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                🏦 Transfer
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mb-2 opacity-50">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                            </svg>
                                            <p>Belum ada data pembayaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($pembayaran->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $pembayaran->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
