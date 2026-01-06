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
        $dow = $now->dayOfWeekIso;

        // ✅ Cek jadwal kegiatan sesuai waktu saat ini
        $jadwal = JadwalAbsen::where('aktif', true)
            ->where('jam_mulai', '<=', $time)
            ->where('jam_selesai', '>=', $time)
            ->where(function ($q) use ($dow) {
                $q->whereNull('hari')
                  ->orWhereJsonContains('hari', $dow);
            })
            ->orderBy('jam_mulai')
            ->first();

        if (!$jadwal) {
            return response()->json([
                'message' => 'Bukan waktu absensi!',
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'kegiatan' => null,
                'waktu' => $now->format('H:i:s'),
            ], 200);
        }

        // ✅ Cek apakah sudah absen untuk kegiatan ini di hari yang sama
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

        // ✅ Simpan absensi baru (kegiatan sesuai jadwal)
        $absen = Absensi::create([
            'nis' => $santri->nis,
            'jadwal_id' => $jadwal->id,
            'status' => 'Hadir',
            'kegiatan' => $jadwal->nama_kegiatan,
            'waktu' => $now,
        ]);

        return response()->json([
            'message' => "Absensi berhasil dicatat untuk {$jadwal->nama_kegiatan}!",
            'nama' => $santri->nama,
            'kelas' => $santri->kelas,
            'kegiatan' => $jadwal->nama_kegiatan,
            'waktu' => $now->format('H:i:s'),
        ]);
    }

    // ✅ Halaman utama rekap (untuk tampilan Blade)
    public function rekap(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $search = $request->input('search');

        $rekap = Absensi::with(['santri', 'jadwal'])
            ->whereDate('waktu', $tanggal)
            ->when($search, function ($query, $search) {
                $query->where('nis', 'like', "%{$search}%")
                      ->orWhereHas('santri', fn($q) => $q->where('nama', 'like', "%{$search}%"));
            })
            ->orderBy('waktu', 'desc')
            ->get();

        return view('rekap', compact('rekap'));
    }

    // ✅ Untuk fetch data realtime (AJAX di halaman rekap)
    public function rekapData(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $search = $request->input('search');

        $rekap = Absensi::with('santri')
            ->whereDate('waktu', $tanggal)
            ->when($search, function ($query, $search) {
                $query->where('nis', 'like', "%{$search}%")
                    ->orWhereHas('santri', fn($q) => $q->where('nama', 'like', "%{$search}%"));
            })
            ->orderBy('waktu', 'desc')
            ->get();

        return view('partials.rekap-table', compact('rekap'));
    }

}
