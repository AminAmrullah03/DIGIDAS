<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SppPembayaran;
use App\Models\SppTagihan;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SppController extends Controller
{
    private const NOMINAL_SPP = 50000;

    private const BULAN_HIJRIAH = [
        1 => 'Muharram',
        2 => 'Safar',
        3 => 'Rabiul Awal',
        4 => 'Rabiul Akhir',
        5 => 'Jumadil Awal',
        6 => 'Jumadil Akhir',
        7 => 'Rajab',
        8 => 'Syaban',
        9 => 'Ramadhan',
        10 => 'Syawal',
        11 => 'Dzulqaidah',
        12 => 'Dzulhijjah',
    ];

    public function tagihan(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'exists:santri,nis'],
            'tahun' => ['nullable', 'integer', 'min:1300', 'max:1700'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->firstOrFail();
        $tahun = $validated['tahun'] ?? 1446;

        $this->generateTagihanTahunan($santri->nis, $tahun);

        $tagihan = SppTagihan::where('nis', $santri->nis)
            ->where('tahun', $tahun)
            ->orderBy('bulan')
            ->get();

        $totalTanggungan = 0;
        $bulanBelum = [];

        $tagihanFormatted = $tagihan->map(function (SppTagihan $item) use (&$totalTanggungan, &$bulanBelum) {
            $totalBayar = (int) SppPembayaran::where('nis', $item->nis)
                ->where('bulan', $item->bulan)
                ->where('tahun', $item->tahun)
                ->sum('nominal_bayar');

            $nominal = (int) $item->nominal;
            $sisa = max($nominal - $totalBayar, 0);

            if ($sisa > 0) {
                $totalTanggungan += $sisa;
                $bulanBelum[] = self::BULAN_HIJRIAH[$item->bulan];
            }

            return [
                'id' => $item->id,
                'bulan' => $item->bulan,
                'nama_bulan' => self::BULAN_HIJRIAH[$item->bulan],
                'tahun' => (int) $item->tahun,
                'nominal' => $nominal,
                'total_bayar' => $totalBayar,
                'sisa' => $sisa,
                'status' => $item->status,
            ];
        });

        return ApiResponse::success([
            'santri' => [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
            ],
            'tagihan' => $tagihanFormatted,
            'tahun' => $tahun,
            'total_tanggungan' => $totalTanggungan,
            'jumlah_bulan_belum' => count($bulanBelum),
            'bulan_belum' => $bulanBelum,
        ], 'Data tagihan SPP berhasil diambil.');
    }

    public function bayar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'exists:santri,nis'],
            'tahun' => ['required', 'integer', 'min:1300', 'max:1700'],
            'nominal_bayar' => ['required', 'numeric', 'min:1'],
            'metode' => ['required', 'in:cash,transfer'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $sisaNominal = (int) $validated['nominal_bayar'];
        $tahun = (int) $validated['tahun'];
        $bulanDibayar = [];

        while ($sisaNominal > 0) {
            $this->generateTagihanTahunan($validated['nis'], $tahun);

            $tagihanBelumLunas = SppTagihan::where('nis', $validated['nis'])
                ->where('tahun', $tahun)
                ->where('status', '!=', 'lunas')
                ->orderBy('bulan')
                ->get();

            if ($tagihanBelumLunas->isEmpty()) {
                $tahun++;
                continue;
            }

            foreach ($tagihanBelumLunas as $tagihan) {
                if ($sisaNominal <= 0) {
                    break;
                }

                $totalBayar = (int) SppPembayaran::where('nis', $validated['nis'])
                    ->where('bulan', $tagihan->bulan)
                    ->where('tahun', $tagihan->tahun)
                    ->sum('nominal_bayar');

                $sisaTagihan = (int) $tagihan->nominal - $totalBayar;

                if ($sisaTagihan <= 0) {
                    continue;
                }

                $bayarSekarang = min($sisaNominal, $sisaTagihan);

                SppPembayaran::create([
                    'nis' => $validated['nis'],
                    'bulan' => $tagihan->bulan,
                    'tahun' => $tagihan->tahun,
                    'nominal_bayar' => $bayarSekarang,
                    'metode' => $validated['metode'],
                    'keterangan' => $validated['keterangan'] ?? null,
                ]);

                $this->updateStatusTagihan($validated['nis'], $tagihan->bulan, $tagihan->tahun);

                $bulanDibayar[] = self::BULAN_HIJRIAH[$tagihan->bulan].' '.$tagihan->tahun.'H';
                $sisaNominal -= $bayarSekarang;
            }

            if ($sisaNominal > 0) {
                $tahun++;
            }

            if ($tahun > ((int) $validated['tahun']) + 3) {
                break;
            }
        }

        return ApiResponse::success(
            ['bulan_dibayar' => $bulanDibayar],
            'Pembayaran berhasil untuk '.count($bulanDibayar).' bulan.',
            201
        );
    }

    public function riwayat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['nullable', 'string', 'exists:santri,nis'],
            'tahun' => ['nullable', 'integer', 'min:1300', 'max:1700'],
            'period' => ['nullable', 'in:today,week,custom,all'],
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $tahun = $validated['tahun'] ?? 1446;
        $period = $validated['period'] ?? 'all';

        $query = SppPembayaran::with('santri')
            ->where('tahun', $tahun)
            ->orderByDesc('created_at');

        if (! empty($validated['nis'])) {
            $query->where('nis', $validated['nis']);
        }

        if ($period === 'today') {
            $query->whereDate('created_at', now('Asia/Jakarta')->toDateString());
        } elseif ($period === 'week') {
            $query->whereBetween('created_at', [
                now('Asia/Jakarta')->startOfWeek(),
                now('Asia/Jakarta')->endOfWeek(),
            ]);
        } elseif ($period === 'custom' && ! empty($validated['dari']) && ! empty($validated['sampai'])) {
            $query->whereBetween('created_at', [
                $validated['dari'].' 00:00:00',
                $validated['sampai'].' 23:59:59',
            ]);
        }

        $totalNominal = (int) (clone $query)->sum('nominal_bayar');
        $totalCount = (clone $query)->count();
        $pembayaran = $query->paginate((int) ($validated['per_page'] ?? 20))->withQueryString();

        return ApiResponse::success($pembayaran->items(), 'Data riwayat SPP berhasil diambil.', 200, [
            'summary' => [
                'total_nominal' => $totalNominal,
                'total_count' => $totalCount,
            ],
            'pagination' => [
                'current_page' => $pembayaran->currentPage(),
                'last_page' => $pembayaran->lastPage(),
                'per_page' => $pembayaran->perPage(),
                'total' => $pembayaran->total(),
            ],
        ]);
    }

    private function generateTagihanTahunan(string $nis, int $tahun): void
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            SppTagihan::firstOrCreate(
                ['nis' => $nis, 'bulan' => $bulan, 'tahun' => $tahun],
                ['nominal' => self::NOMINAL_SPP, 'status' => 'belum']
            );
        }
    }

    private function updateStatusTagihan(string $nis, int $bulan, int $tahun): void
    {
        $tagihan = SppTagihan::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if (! $tagihan) {
            return;
        }

        $totalBayar = (int) SppPembayaran::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->sum('nominal_bayar');

        if ($totalBayar >= (int) $tagihan->nominal) {
            $tagihan->status = 'lunas';
        } elseif ($totalBayar > 0) {
            $tagihan->status = 'sebagian';
        } else {
            $tagihan->status = 'belum';
        }

        $tagihan->save();
    }
}
