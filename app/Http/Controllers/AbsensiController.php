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
        // Ambil daftar kelas unik dari tabel santri
        $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        
        // Ambil daftar kegiatan dari jadwal_absen
        $kegiatanList = JadwalAbsen::select('id', 'nama_kegiatan')->orderBy('nama_kegiatan')->get();
        
        // Data rekap kosong di awal (user harus pilih filter dulu)
        $rekap = collect();
        $showTable = false;

        return view('rekap', compact('rekap', 'kelasList', 'kegiatanList', 'showTable'));
    }

    // ✅ Untuk fetch data realtime (AJAX di halaman rekap)
    public function rekapData(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $kelas = $request->input('kelas');
        $jadwalId = $request->input('kegiatan');
        $search = $request->input('search');

        // Jika kelas dan kegiatan belum dipilih, kembalikan pesan
        if (empty($kelas) || empty($jadwalId)) {
            return view('partials.rekap-table', [
                'rekap' => collect(),
                'showTable' => false,
                'message' => 'Silakan pilih kelas dan kegiatan terlebih dahulu.'
            ]);
        }

        // Ambil jadwal untuk mendapatkan nama kegiatan
        $jadwal = JadwalAbsen::find($jadwalId);
        $namaKegiatan = $jadwal ? $jadwal->nama_kegiatan : '-';

        // Ambil semua santri dari kelas yang dipilih
        $santriList = Santri::where('kelas', $kelas)
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('nis', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->get();

        // Ambil data absensi untuk tanggal dan kegiatan yang dipilih
        $absensiData = Absensi::where('jadwal_id', $jadwalId)
            ->whereDate('waktu', $tanggal)
            ->get()
            ->keyBy('nis');

        // Gabungkan data santri dengan status absensi
        $rekap = $santriList->map(function ($santri) use ($absensiData, $namaKegiatan) {
            $absensi = $absensiData->get($santri->nis);
            
            return (object) [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'kegiatan' => $namaKegiatan,
                'waktu' => $absensi ? $absensi->waktu : null,
                'status' => $absensi ? $absensi->status : 'Alpha',
            ];
        });

        return view('partials.rekap-table', [
            'rekap' => $rekap,
            'showTable' => true
        ]);
    }

}
