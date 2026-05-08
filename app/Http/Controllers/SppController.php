<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\SantriKelas;
use App\Models\SppTagihan;
use App\Models\SppPembayaran;
use App\Models\TahunAjaran;

class SppController extends Controller
{
    const BULAN_HIJRIAH = [
        1  => 'Muharram',   2  => 'Safar',        3  => 'Rabiul Awal',
        4  => 'Rabiul Akhir',5 => 'Jumadil Awal',  6  => 'Jumadil Akhir',
        7  => 'Rajab',      8  => 'Syaban',        9  => 'Ramadhan',
        10 => 'Syawal',     11 => 'Dzulqaidah',   12 => 'Dzulhijjah',
    ];

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function getTahunAjaran(?int $id = null): ?TahunAjaran
    {
        if ($id) {
            return TahunAjaran::find($id);
        }
        return TahunAjaran::getAktif();
    }

    // ─── Halaman utama (scan QR) ──────────────────────────────────────────────

    public function index()
    {
        $tahunAjaran = TahunAjaran::getAktif() ?? TahunAjaran::orderByDesc('id')->first();

        return view('spp.index', compact('tahunAjaran'));
    }

    // ─── Rekap SPP ───────────────────────────────────────────────────────────

    public function rekap(Request $request)
    {
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $kelasFilter   = $request->input('kelas');

        $semua = TahunAjaran::orderByDesc('id')->get();
        $tahunAjaran = $tahunAjaranId
            ? $semua->firstWhere('id', $tahunAjaranId)
            : $semua->firstWhere('status', 'aktif') ?? $semua->first();

        if (! $tahunAjaran) {
            return view('spp.rekap', [
                'tahunAjaran' => null,
                'rekapData' => [],
                'kelasList' => collect(),
                'kelasFilter' => $kelasFilter,
                'semua' => $semua,
            ]);
        }

        $kelasList = $this->kelasListUntukTahun($tahunAjaran);
        $santriList = $this->santriListUntukTahun($tahunAjaran, $kelasFilter);

        // Generate tagihan untuk semua santri jika belum ada
        foreach ($santriList as $santri) {
            $this->generateTagihanTahunan($santri->nis, $tahunAjaran);
        }

        $rekapData = [];
        foreach ($santriList as $santri) {
            $tagihan = SppTagihan::where('nis', $santri->nis)
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->orderBy('bulan')
                ->get()
                ->keyBy('bulan');

            $rekapData[] = [
                'santri'  => $santri,
                'kelas'   => $santri->kelas_tahun_ajaran ?? $santri->kelas,
                'tagihan' => $tagihan,
            ];
        }

        return view('spp.rekap', compact('rekapData', 'kelasList', 'kelasFilter', 'tahunAjaran', 'semua'));
    }

    // ─── Ambil tagihan santri (AJAX / scan QR) ───────────────────────────────

    public function getSantriSpp(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        $santri = Santri::where('nis', $request->nis)->first();
        if (! $santri) {
            return response()->json(['success' => false, 'message' => 'NIS tidak ditemukan!'], 404);
        }

        $tahunAjaran = $this->getTahunAjaran($request->input('tahun_ajaran_id'));
        if (! $tahunAjaran) {
            return response()->json(['success' => false, 'message' => 'Tidak ada tahun ajaran aktif.'], 422);
        }

        $this->generateTagihanTahunan($santri->nis, $tahunAjaran);

        $tagihan = SppTagihan::where('nis', $santri->nis)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->orderBy('bulan')
            ->get();

        $totalTanggungan = 0;
        $bulanBelum      = [];

        $tagihanFormatted = $tagihan->map(function ($item) use (&$totalTanggungan, &$bulanBelum) {
            $totalBayar = SppPembayaran::where('nis', $item->nis)
                ->where('bulan', $item->bulan)
                ->where('tahun_ajaran_id', $item->tahun_ajaran_id)
                ->sum('nominal_bayar');

            $sisa = $item->nominal - $totalBayar;
            if ($sisa > 0) {
                $totalTanggungan += $sisa;
                $bulanBelum[] = self::BULAN_HIJRIAH[$item->bulan];
            }

            return [
                'id'         => $item->id,
                'bulan'      => $item->bulan,
                'nama_bulan' => self::BULAN_HIJRIAH[$item->bulan],
                'nominal'    => $item->nominal,
                'total_bayar'=> $totalBayar,
                'sisa'       => $sisa,
                'status'     => $item->status,
            ];
        });

        return response()->json([
            'success'            => true,
            'santri'             => [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $this->kelasSantriUntukTahun($santri, $tahunAjaran),
            ],
            'tagihan'            => $tagihanFormatted,
            'tahun_ajaran'       => [
                'id' => $tahunAjaran->id,
                'nama' => $tahunAjaran->nama,
                'tahun_hijriah' => $tahunAjaran->tahun_hijriah,
                'tahun_masehi' => $tahunAjaran->tahun_masehi,
            ],
            'total_tanggungan'   => $totalTanggungan,
            'jumlah_bulan_belum' => count($bulanBelum),
            'bulan_belum'        => $bulanBelum,
            'tahun_ajaran_id'    => $tahunAjaran->id,
        ]);
    }

    // ─── Simpan pembayaran ────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'nis'            => 'required|string|exists:santri,nis',
            'tahun_ajaran_id'=> 'required|integer|exists:tahun_ajaran,id',
            'nominal_bayar'  => 'required|numeric|min:1',
            'metode'         => 'required|in:cash,transfer',
        ]);

        $tahunAjaran  = TahunAjaran::findOrFail($request->tahun_ajaran_id);
        $sisaNominal  = $request->nominal_bayar;
        $currentTA    = $tahunAjaran;
        $bulanDibayar = [];

        while ($sisaNominal > 0) {
            $this->generateTagihanTahunan($request->nis, $currentTA);

            $tagihanBelumLunas = SppTagihan::where('nis', $request->nis)
                ->where('tahun_ajaran_id', $currentTA->id)
                ->where('status', '!=', 'lunas')
                ->orderBy('bulan')
                ->get();

            if ($tagihanBelumLunas->isEmpty()) {
                // Semua lunas di tahun ini — cari tahun ajaran berikutnya
                $next = TahunAjaran::where('tahun_hijriah', $currentTA->tahun_hijriah + 1)->first();
                if (! $next) break; // tidak ada lagi
                $currentTA = $next;
                continue;
            }

            foreach ($tagihanBelumLunas as $tagihan) {
                if ($sisaNominal <= 0) break;

                $totalBayar = SppPembayaran::where('nis', $request->nis)
                    ->where('bulan', $tagihan->bulan)
                    ->where('tahun_ajaran_id', $tagihan->tahun_ajaran_id)
                    ->sum('nominal_bayar');

                $sisaTagihan = $tagihan->nominal - $totalBayar;
                if ($sisaTagihan <= 0) continue;

                $bayarSekarang = min($sisaNominal, $sisaTagihan);

                SppPembayaran::create([
                    'nis'             => $request->nis,
                    'bulan'           => $tagihan->bulan,
                    'tahun_ajaran_id' => $tagihan->tahun_ajaran_id,
                    'nominal_bayar'   => $bayarSekarang,
                    'metode'          => $request->metode,
                ]);

                $this->updateStatusTagihan($request->nis, $tagihan->bulan, $tagihan->tahun_ajaran_id);

                $bulanDibayar[] = self::BULAN_HIJRIAH[$tagihan->bulan] . ' ' . $currentTA->tahun_hijriah . 'H';
                $sisaNominal   -= $bayarSekarang;
            }
        }

        $jumlahBulan = count($bulanDibayar);
        $message     = "Pembayaran berhasil untuk {$jumlahBulan} bulan";
        if ($jumlahBulan > 0 && $jumlahBulan <= 4) {
            $message .= ': ' . implode(', ', $bulanDibayar);
        }

        return response()->json(['success' => true, 'message' => $message, 'bulan_dibayar' => $bulanDibayar]);
    }

    // ─── Riwayat pembayaran ───────────────────────────────────────────────────

    public function riwayat(Request $request)
    {
        $nis           = $request->input('nis');
        $tahunAjaranId = $request->input('tahun_ajaran_id');
        $period        = $request->input('period', 'all');
        $dari          = $request->input('dari');
        $sampai        = $request->input('sampai');

        $semua       = TahunAjaran::orderByDesc('id')->get();
        $tahunAjaran = $tahunAjaranId
            ? $semua->firstWhere('id', $tahunAjaranId)
            : $semua->firstWhere('status', 'aktif') ?? $semua->first();

        $query = SppPembayaran::with(['santri', 'tahunAjaran'])
            ->orderBy('created_at', 'desc');

        if ($tahunAjaran) {
            $query->where('tahun_ajaran_id', $tahunAjaran->id);
        }
        if ($nis)    $query->where('nis', $nis);
        if ($period === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($period === 'custom' && $dari && $sampai) {
            $query->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59']);
        }

        $pembayaran   = $query->paginate(20)->withQueryString();
        $totalNominal = SppPembayaran::query()
            ->when($tahunAjaran, fn($q) => $q->where('tahun_ajaran_id', $tahunAjaran->id))
            ->when($nis, fn($q) => $q->where('nis', $nis))
            ->when($period === 'today', fn($q) => $q->whereDate('created_at', today()))
            ->when($period === 'week', fn($q) => $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($period === 'custom' && $dari && $sampai, fn($q) => $q->whereBetween('created_at', [$dari . ' 00:00:00', $sampai . ' 23:59:59']))
            ->sum('nominal_bayar');
        $totalCount   = $pembayaran->total();

        return view('spp.riwayat', compact(
            'pembayaran', 'tahunAjaran', 'semua', 'nis', 'period', 'dari', 'sampai', 'totalNominal', 'totalCount'
        ));
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private function generateTagihanTahunan(string $nis, TahunAjaran $tahunAjaran): void
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            SppTagihan::firstOrCreate(
                ['nis' => $nis, 'bulan' => $bulan, 'tahun_ajaran_id' => $tahunAjaran->id],
                ['nominal' => $tahunAjaran->nominal_spp, 'status' => 'belum']
            );
        }
    }

    private function kelasListUntukTahun(TahunAjaran $tahunAjaran)
    {
        $kelasList = SantriKelas::where('tahun_ajaran_id', $tahunAjaran->id)
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        if ($kelasList->isNotEmpty()) {
            return $kelasList;
        }

        return Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
    }

    private function santriListUntukTahun(TahunAjaran $tahunAjaran, ?string $kelasFilter)
    {
        $hasKelasData = SantriKelas::where('tahun_ajaran_id', $tahunAjaran->id)->exists();

        if (! $hasKelasData) {
            return Santri::query()
                ->when($kelasFilter, fn ($query) => $query->where('kelas', $kelasFilter))
                ->orderBy('kelas')
                ->orderBy('nama')
                ->get();
        }

        $kelasByNis = SantriKelas::where('tahun_ajaran_id', $tahunAjaran->id)
            ->when($kelasFilter, fn ($query) => $query->where('kelas', $kelasFilter))
            ->pluck('kelas', 'nis');

        if ($kelasByNis->isEmpty()) {
            return collect();
        }

        return Santri::whereIn('nis', $kelasByNis->keys())
            ->get()
            ->map(function ($santri) use ($kelasByNis) {
                $santri->kelas_tahun_ajaran = $kelasByNis->get($santri->nis, $santri->kelas);

                return $santri;
            })
            ->sortBy(fn ($santri) => ($santri->kelas_tahun_ajaran ?? '') . '|' . $santri->nama)
            ->values();
    }

    private function kelasSantriUntukTahun(Santri $santri, TahunAjaran $tahunAjaran): ?string
    {
        return SantriKelas::where('nis', $santri->nis)
            ->where('tahun_ajaran_id', $tahunAjaran->id)
            ->value('kelas') ?? $santri->kelas;
    }

    private function updateStatusTagihan(string $nis, int $bulan, int $tahunAjaranId): void
    {
        $tagihan = SppTagihan::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->first();

        if (! $tagihan) return;

        $totalBayar = SppPembayaran::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->sum('nominal_bayar');

        $tagihan->status = match (true) {
            $totalBayar >= $tagihan->nominal => 'lunas',
            $totalBayar > 0                 => 'sebagian',
            default                          => 'belum',
        };
        $tagihan->save();
    }
}
