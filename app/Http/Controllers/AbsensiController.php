<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JadwalAbsen;
use App\Models\TahunAjaran;

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

        $tahunAjaran = TahunAjaran::getAktif();

        // ✅ Simpan absensi baru (kegiatan sesuai jadwal)
        $absen = Absensi::create([
            'nis' => $santri->nis,
            'jadwal_id' => $jadwal->id,
            'tahun_ajaran_id' => $tahunAjaran?->id,
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
        $kelasFilter = $request->input('kelas');
        $kegiatanFilter = $request->input('kegiatan');

        // Ambil daftar kelas unik dari santri
        $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');
        
        // Ambil daftar kegiatan dari jadwal aktif
        $kegiatanList = JadwalAbsen::where('aktif', true)->orderBy('nama_kegiatan')->get();

        $rekap = $this->buildRekapAbsensi($tanggal, $kelasFilter, $kegiatanFilter);

        return view('rekap', compact('rekap', 'kelasList', 'kegiatanList', 'kelasFilter', 'kegiatanFilter', 'tanggal'));
    }

    // ✅ Untuk fetch data realtime (AJAX di halaman rekap)
    public function rekapData(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $kelasFilter = $request->input('kelas');
        $kegiatanFilter = $request->input('kegiatan');

        $rekap = $this->buildRekapAbsensi($tanggal, $kelasFilter, $kegiatanFilter);

        return view('partials.rekap-table', compact('rekap'));
    }

    private function buildRekapAbsensi($tanggal, $kelasFilter, $kegiatanFilter)
    {
        $rekap = collect();

        if (!$kegiatanFilter) {
            return $rekap;
        }

        $jadwal = JadwalAbsen::find($kegiatanFilter);

        if (!$jadwal) {
            return $rekap;
        }

        $santriList = Santri::query()
            ->when($kelasFilter, fn ($query) => $query->where('kelas', $kelasFilter))
            ->orderBy('kelas')
            ->orderBy('nama')
            ->get();

        $absensiByNis = Absensi::where('jadwal_id', $kegiatanFilter)
            ->whereDate('waktu', $tanggal)
            ->whereIn('nis', $santriList->pluck('nis'))
            ->get()
            ->keyBy('nis');

        foreach ($santriList as $santri) {
            $absensi = $absensiByNis->get($santri->nis);

            $rekap->push([
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'kegiatan' => $jadwal->nama_kegiatan,
                'waktu' => $absensi ? $absensi->waktu : null,
                'status' => $absensi ? $absensi->status : 'Alpha',
            ]);
        }

        return $rekap;
    }

    // ✅ Update status absensi (untuk edit dari halaman rekap)
    public function updateStatus(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'jadwal_id' => 'required|integer',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        $nis = $request->input('nis');
        $jadwalId = $request->input('jadwal_id');
        $tanggal = $request->input('tanggal');
        $status = $request->input('status');

        // Cek apakah santri ada
        $santri = Santri::where('nis', $nis)->first();
        if (!$santri) {
            return response()->json(['success' => false, 'message' => 'Santri tidak ditemukan'], 404);
        }

        // Cek apakah jadwal ada
        $jadwal = JadwalAbsen::find($jadwalId);
        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        // Cari absensi yang sudah ada
        $absensi = Absensi::where('nis', $nis)
            ->where('jadwal_id', $jadwalId)
            ->whereDate('waktu', $tanggal)
            ->first();

        if ($absensi) {
            // Update status yang sudah ada
            $absensi->update(['status' => $status]);
        } else {
            $tahunAjaran = TahunAjaran::getAktif();
            // Buat record baru (untuk santri yang sebelumnya Alpha/tidak ada record)
            Absensi::create([
                'nis' => $nis,
                'jadwal_id' => $jadwalId,
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'status' => $status,
                'kegiatan' => $jadwal->nama_kegiatan,
                'waktu' => $tanggal . ' 00:00:00', // Set waktu default untuk record manual
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah menjadi ' . $status,
            'status' => $status,
        ]);
    }

}
