<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\SppTagihan;
use App\Models\SppPembayaran;

class SppController extends Controller
{
    const NOMINAL_SPP = 50000; // Rp 50.000 per bulan

    const BULAN_HIJRIAH = [
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

    // Halaman pembayaran SPP (scan QR)
    public function index()
    {
        return view('spp.index');
    }

    // Halaman rekap SPP (seperti Excel)
    public function rekap(Request $request)
    {
        $tahun = $request->input('tahun', 1446); // Default tahun Hijriah
        $kelasFilter = $request->input('kelas');

        $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $santriQuery = Santri::orderBy('kelas')->orderBy('nama');
        if ($kelasFilter) {
            $santriQuery->where('kelas', $kelasFilter);
        }
        $santriList = $santriQuery->get();

        // Generate tagihan untuk semua santri jika belum ada
        foreach ($santriList as $santri) {
            $this->generateTagihanTahunan($santri->nis, $tahun);
        }

        // Ambil data rekap
        $rekapData = [];
        foreach ($santriList as $santri) {
            $tagihan = SppTagihan::where('nis', $santri->nis)
                ->where('tahun', $tahun)
                ->orderBy('bulan')
                ->get()
                ->keyBy('bulan');

            $rekapData[] = [
                'santri' => $santri,
                'tagihan' => $tagihan,
            ];
        }

        return view('spp.rekap', compact('rekapData', 'kelasList', 'kelasFilter', 'tahun'));
    }

    public function getSantriSpp(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan!'
            ], 404);
        }

        $tahun = $request->input('tahun', 1446);
        
        // Generate tagihan jika belum ada
        $this->generateTagihanTahunan($santri->nis, $tahun);

        // Ambil tagihan SPP untuk tahun ini
        $tagihan = SppTagihan::where('nis', $santri->nis)
            ->where('tahun', $tahun)
            ->orderBy('bulan')
            ->get();

        // Hitung total tanggungan
        $totalTanggungan = 0;
        $bulanBelum = [];

        $tagihanFormatted = $tagihan->map(function ($item) use (&$totalTanggungan, &$bulanBelum) {
            $totalBayar = SppPembayaran::where('nis', $item->nis)
                ->where('bulan', $item->bulan)
                ->where('tahun', $item->tahun)
                ->sum('nominal_bayar');

            $sisa = $item->nominal - $totalBayar;
            
            if ($sisa > 0) {
                $totalTanggungan += $sisa;
                $bulanBelum[] = self::BULAN_HIJRIAH[$item->bulan];
            }

            return [
                'id' => $item->id,
                'bulan' => $item->bulan,
                'nama_bulan' => self::BULAN_HIJRIAH[$item->bulan],
                'tahun' => $item->tahun,
                'nominal' => $item->nominal,
                'total_bayar' => $totalBayar,
                'sisa' => $sisa,
                'status' => $item->status,
            ];
        });

        return response()->json([
            'success' => true,
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
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|exists:santri,nis',
            'tahun' => 'required|integer',
            'nominal_bayar' => 'required|numeric|min:1',
            'metode' => 'required|in:cash,transfer',
        ]);

        $sisaNominal = $request->nominal_bayar;
        $tahun = $request->tahun;
        $bulanDibayar = [];

        // Loop sampai sisa nominal habis, bisa lanjut ke tahun berikutnya
        while ($sisaNominal > 0) {
            // Generate tagihan untuk tahun ini jika belum ada
            $this->generateTagihanTahunan($request->nis, $tahun);

            // Ambil tagihan yang belum lunas, urut dari bulan terkecil
            $tagihanBelumLunas = SppTagihan::where('nis', $request->nis)
                ->where('tahun', $tahun)
                ->where('status', '!=', 'lunas')
                ->orderBy('bulan')
                ->get();

            if ($tagihanBelumLunas->isEmpty()) {
                // Tahun ini sudah lunas semua, lanjut ke tahun berikutnya
                $tahun++;
                continue;
            }

            foreach ($tagihanBelumLunas as $tagihan) {
                if ($sisaNominal <= 0) break;

                $totalBayar = SppPembayaran::where('nis', $request->nis)
                    ->where('bulan', $tagihan->bulan)
                    ->where('tahun', $tagihan->tahun)
                    ->sum('nominal_bayar');

                $sisaTagihan = $tagihan->nominal - $totalBayar;

                if ($sisaTagihan <= 0) continue;

                $bayarSekarang = min($sisaNominal, $sisaTagihan);

                SppPembayaran::create([
                    'nis' => $request->nis,
                    'bulan' => $tagihan->bulan,
                    'tahun' => $tagihan->tahun,
                    'nominal_bayar' => $bayarSekarang,
                    'metode' => $request->metode,
                ]);

                $this->updateStatusTagihan($request->nis, $tagihan->bulan, $tagihan->tahun);

                $bulanDibayar[] = self::BULAN_HIJRIAH[$tagihan->bulan] . ' ' . $tagihan->tahun . 'H';
                $sisaNominal -= $bayarSekarang;
            }

            // Jika masih ada sisa dan tahun ini sudah diproses semua, lanjut tahun berikutnya
            if ($sisaNominal > 0) {
                $tahun++;
            }

            // Safety limit: jangan lebih dari 3 tahun ke depan
            if ($tahun > $request->tahun + 3) break;
        }

        $jumlahBulan = count($bulanDibayar);
        $message = "Pembayaran berhasil untuk {$jumlahBulan} bulan";
        if ($jumlahBulan > 0 && $jumlahBulan <= 4) {
            $message .= ": " . implode(', ', $bulanDibayar);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'bulan_dibayar' => $bulanDibayar,
        ]);
    }

    public function riwayat(Request $request)
    {
        $nis = $request->input('nis');
        $tahun = $request->input('tahun', 1446);

        $query = SppPembayaran::with('santri')
            ->where('tahun', $tahun)
            ->orderBy('created_at', 'desc');

        if ($nis) {
            $query->where('nis', $nis);
        }

        $pembayaran = $query->paginate(20);

        return view('spp.riwayat', compact('pembayaran', 'tahun', 'nis'));
    }

    private function generateTagihanTahunan($nis, $tahun)
    {
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            SppTagihan::firstOrCreate(
                ['nis' => $nis, 'bulan' => $bulan, 'tahun' => $tahun],
                ['nominal' => self::NOMINAL_SPP, 'status' => 'belum']
            );
        }
    }

    private function updateStatusTagihan($nis, $bulan, $tahun)
    {
        $tagihan = SppTagihan::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if (!$tagihan) return;

        $totalBayar = SppPembayaran::where('nis', $nis)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->sum('nominal_bayar');

        if ($totalBayar >= $tagihan->nominal) {
            $tagihan->status = 'lunas';
        } elseif ($totalBayar > 0) {
            $tagihan->status = 'sebagian';
        } else {
            $tagihan->status = 'belum';
        }

        $tagihan->save();
    }
}
