<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriKelas;
use App\Models\SppPembayaran;
use App\Models\SppTagihan;
use App\Models\TahunAjaran;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SppController extends Controller
{
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
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tahun' => ['nullable', 'integer', 'min:1300', 'max:1700'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->firstOrFail();
        $tahunAjaran = $this->resolveTahunAjaran($validated);

        if (! $tahunAjaran) {
            return ApiResponse::error('Tidak ada tahun ajaran aktif.', 422);
        }

        $this->generateTagihanTahunan($santri->nis, $tahunAjaran);

        $tagihan = SppTagihan::where('nis', $santri->nis)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->orderBy('bulan')
            ->get();

        $totalTanggungan = 0;
        $bulanBelum = [];

        $tagihanFormatted = $tagihan->map(function (SppTagihan $item) use (&$totalTanggungan, &$bulanBelum) {
            $totalBayar = (int) SppPembayaran::where('nis', $item->nis)
                ->where('bulan', $item->bulan)
                ->where('tahun_ajaran_id', $item->tahun_ajaran_id)
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
                'kelas' => $this->kelasSantriUntukTahun($santri, $tahunAjaran),
            ],
            'tagihan' => $tagihanFormatted,
            'tahun_ajaran' => $this->tahunAjaranPayload($tahunAjaran),
            'tahun_ajaran_id' => $tahunAjaran->id,
            'total_tanggungan' => $totalTanggungan,
            'jumlah_bulan_belum' => count($bulanBelum),
            'bulan_belum' => $bulanBelum,
        ], 'Data tagihan SPP berhasil diambil.');
    }

    public function bayar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'exists:santri,nis'],
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tahun' => ['nullable', 'integer', 'min:1300', 'max:1700'],
            'nominal_bayar' => ['required', 'numeric', 'min:1'],
            'metode' => ['required', 'in:cash,transfer'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $currentTA = $this->resolveTahunAjaran($validated);

        if (! $currentTA) {
            return ApiResponse::error('Tidak ada tahun ajaran aktif.', 422);
        }

        $sisaNominal = (int) $validated['nominal_bayar'];
        $bulanDibayar = [];

        while ($sisaNominal > 0) {
            $this->generateTagihanTahunan($validated['nis'], $currentTA);

            $tagihanBelumLunas = SppTagihan::where('nis', $validated['nis'])
                ->where('tahun_ajaran_id', $currentTA->id)
                ->where('status', '!=', 'lunas')
                ->orderBy('bulan')
                ->get();

            if ($tagihanBelumLunas->isEmpty()) {
                $next = TahunAjaran::where('tahun_hijriah', $currentTA->tahun_hijriah + 1)->first();
                if (! $next) {
                    break;
                }
                $currentTA = $next;
                continue;
            }

            foreach ($tagihanBelumLunas as $tagihan) {
                if ($sisaNominal <= 0) {
                    break;
                }

                $totalBayar = (int) SppPembayaran::where('nis', $validated['nis'])
                    ->where('bulan', $tagihan->bulan)
                    ->where('tahun_ajaran_id', $tagihan->tahun_ajaran_id)
                    ->sum('nominal_bayar');

                $sisaTagihan = (int) $tagihan->nominal - $totalBayar;

                if ($sisaTagihan <= 0) {
                    continue;
                }

                $bayarSekarang = min($sisaNominal, $sisaTagihan);

                SppPembayaran::create([
                    'nis' => $validated['nis'],
                    'bulan' => $tagihan->bulan,
                    'tahun_ajaran_id' => $tagihan->tahun_ajaran_id,
                    'nominal_bayar' => $bayarSekarang,
                    'metode' => $validated['metode'],
                    'keterangan' => $validated['keterangan'] ?? null,
                ]);

                $this->updateStatusTagihan($validated['nis'], $tagihan->bulan, $tagihan->tahun_ajaran_id);

                $bulanDibayar[] = self::BULAN_HIJRIAH[$tagihan->bulan].' '.$currentTA->tahun_hijriah.'H';
                $sisaNominal -= $bayarSekarang;
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
            'tahun_ajaran_id' => ['nullable', 'integer', 'exists:tahun_ajaran,id'],
            'tahun' => ['nullable', 'integer', 'min:1300', 'max:1700'],
            'period' => ['nullable', 'in:today,week,custom,all'],
            'dari' => ['nullable', 'date'],
            'sampai' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $tahunAjaran = $this->resolveTahunAjaran($validated);
        $period = $validated['period'] ?? 'all';

        $query = SppPembayaran::with(['santri', 'tahunAjaran'])
            ->when($tahunAjaran, fn ($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
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
            'filters' => [
                'tahun_ajaran' => $tahunAjaran ? $this->tahunAjaranPayload($tahunAjaran) : null,
            ],
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

    private function resolveTahunAjaran(array $input): ?TahunAjaran
    {
        if (! empty($input['tahun_ajaran_id'])) {
            return TahunAjaran::find($input['tahun_ajaran_id']);
        }

        if (! empty($input['tahun'])) {
            return TahunAjaran::where('tahun_hijriah', $input['tahun'])->first();
        }

        return TahunAjaran::getAktif() ?? TahunAjaran::orderByDesc('id')->first();
    }

    private function generateTagihanTahunan(string $nis, TahunAjaran $tahunAjaran): void
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            SppTagihan::firstOrCreate(
                ['nis' => $nis, 'bulan' => $bulan, 'tahun_ajaran_id' => $tahunAjaran->id],
                ['nominal' => $tahunAjaran->nominal_spp, 'status' => 'belum']
            );
        }
    }

    private function updateStatusTagihan(string $nis, int $bulan, int $tahunAjaranId): void
    {
        $tagihan = SppTagihan::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        if (! $tagihan) {
            return;
        }

        $totalBayar = (int) SppPembayaran::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->sum('nominal_bayar');

        $tagihan->status = match (true) {
            $totalBayar >= (int) $tagihan->nominal => 'lunas',
            $totalBayar > 0 => 'sebagian',
            default => 'belum',
        };

        $tagihan->save();
    }

    private function kelasSantriUntukTahun(Santri $santri, TahunAjaran $tahunAjaran): ?string
    {
        return SantriKelas::where('nis', $santri->nis)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->value('kelas') ?? $santri->kelas;
    }

    private function tahunAjaranPayload(TahunAjaran $tahunAjaran): array
    {
        return [
            'id' => $tahunAjaran->id,
            'nama' => $tahunAjaran->nama,
            'tahun_hijriah' => $tahunAjaran->tahun_hijriah,
            'tahun_masehi' => $tahunAjaran->tahun_masehi,
            'nominal_spp' => (int) $tahunAjaran->nominal_spp,
            'status' => $tahunAjaran->status,
        ];
    }
}
