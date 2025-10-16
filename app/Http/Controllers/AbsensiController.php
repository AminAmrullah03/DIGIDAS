<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JadwalAbsen;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absen');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri) {
            return response()->json([
                'message' => 'NIS tidak ditemukan di database!'
            ], 404);
        }

        $now = now()->setTimezone('Asia/Jakarta');
        $today = $now->toDateString();
        $time = $now->format('H:i:s');

        // ✅ Ambil jadwal kegiatan dari database berdasarkan waktu WIB sekarang
        $jadwal = JadwalAbsen::where('jam_mulai', '<=', $time)
            ->where('jam_selesai', '>=', $time)
            ->orderBy('jam_mulai')
            ->first();

        // ✅ Kalau di luar jam kegiatan
        if (!$jadwal) {
            return response()->json([
                'message' => 'Bukan waktu absensi!',
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'kegiatan' => null,
                'waktu' => $now->format('H:i:s'),
            ], 200);
        }

        // ✅ Cek apakah sudah absen untuk kegiatan ini
        $sudahAbsen = Absensi::where('nis', $santri->nis)
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('waktu', $today)
            ->exists();

        if ($sudahAbsen) {
            return response()->json([
                'message' => "Santri ini sudah absen untuk kegiatan {$jadwal->nama_kegiatan} hari ini!",
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'kegiatan' => $jadwal->nama_kegiatan,
                'waktu' => $now->format('H:i:s'),
            ]);
        }

        // ✅ Simpan absensi baru (dengan referensi ke jadwal)
        $absen = Absensi::create([
            'nis' => $santri->nis,
            'jadwal_id' => $jadwal->id,
            'status' => 'Hadir',
            'kegiatan' => $jadwal->nama_kegiatan,
            'waktu' => now(),
        ]);

        return response()->json([
            'message' => "Absensi berhasil dicatat untuk {$jadwal->nama_kegiatan}!",
            'nama' => $santri->nama,
            'kelas' => $santri->kelas,
            'kegiatan' => $jadwal->nama_kegiatan,
            'waktu' => $now->format('H:i:s'),
        ]);
    }

    public function rekap()
    {
        $rekap = Absensi::with('santri')
            ->whereDate('waktu', now())
            ->orderBy('waktu', 'desc')
            ->get();

        return view('rekap', compact('rekap'));
    }
}
