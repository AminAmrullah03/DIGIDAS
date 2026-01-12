<?php

namespace App\Http\Controllers\Wali;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalAbsen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WaliDashboardController extends Controller
{
    public function index()
    {
        $wali = Auth::guard('wali')->user();
        $santri = $wali->santri;

        // Ambil rekap 7 hari terakhir
        $rekapMingguan = Absensi::where('nis', $wali->nis)
            ->whereDate('waktu', '>=', now()->subDays(7))
            ->orderBy('waktu', 'desc')
            ->get();

        // Hitung statistik
        $totalHadir = Absensi::where('nis', $wali->nis)
            ->where('status', 'Hadir')
            ->whereMonth('waktu', now()->month)
            ->count();

        $totalIzin = Absensi::where('nis', $wali->nis)
            ->whereIn('status', ['Izin', 'Sakit'])
            ->whereMonth('waktu', now()->month)
            ->count();

        $totalAlpha = Absensi::where('nis', $wali->nis)
            ->where('status', 'Alpha')
            ->whereMonth('waktu', now()->month)
            ->count();

        return view('wali.dashboard', compact('wali', 'santri', 'rekapMingguan', 'totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function rekap(Request $request)
    {
        $wali = Auth::guard('wali')->user();
        $santri = $wali->santri;

        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        // Ambil semua kegiatan
        $kegiatanList = JadwalAbsen::where('aktif', true)->orderBy('nama_kegiatan')->get();

        // Ambil rekap berdasarkan bulan
        $rekap = Absensi::with('jadwal')
            ->where('nis', $wali->nis)
            ->whereMonth('waktu', $bulan)
            ->whereYear('waktu', $tahun)
            ->orderBy('waktu', 'desc')
            ->get();

        return view('wali.rekap', compact('wali', 'santri', 'rekap', 'kegiatanList', 'bulan', 'tahun'));
    }
}
