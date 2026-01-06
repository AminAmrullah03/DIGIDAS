<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Santri;
use App\Models\JadwalAbsen;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    protected function buildRekapPerKelas(string $tanggal, ?int $jadwalId, ?string $kelas, ?string $search): array
    {
        $jadwal = null;
        $kegiatanBerlaku = false;
        $rows = collect();
        $summary = [
            'total' => 0,
            'hadir' => 0,
            'bolos' => 0,
        ];

        if (!$jadwalId || !$kelas) {
            return compact('jadwal', 'kegiatanBerlaku', 'rows', 'summary');
        }

        $jadwal = JadwalAbsen::find($jadwalId);
        if (!$jadwal) {
            return compact('jadwal', 'kegiatanBerlaku', 'rows', 'summary');
        }

        $dow = Carbon::parse($tanggal)->dayOfWeekIso;
        $kegiatanBerlaku = $jadwal->aktif && (empty($jadwal->hari) || in_array($dow, (array) $jadwal->hari));

        $santris = Santri::query()
            ->where('kelas', $kelas)
            ->when($search, function ($q, $search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->get();

        $absensiByNis = Absensi::query()
            ->whereDate('waktu', $tanggal)
            ->where('jadwal_id', $jadwalId)
            ->whereIn('nis', $santris->pluck('nis'))
            ->get()
            ->keyBy('nis');

        $rows = $santris->map(function ($s) use ($absensiByNis, $jadwal) {
            return [
                'santri' => $s,
                'absensi' => $absensiByNis->get($s->nis),
                'kegiatan' => $jadwal->nama_kegiatan,
            ];
        });

        $summary['total'] = $rows->count();
        $summary['hadir'] = $rows->filter(fn ($r) => !empty($r['absensi']))->count();
        $summary['bolos'] = $kegiatanBerlaku ? ($summary['total'] - $summary['hadir']) : 0;

        return compact('jadwal', 'kegiatanBerlaku', 'rows', 'summary');
    }

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
        $jadwalId = $request->input('jadwal_id');
        $kelas = $request->input('kelas');

        $jadwals = JadwalAbsen::orderBy('jam_mulai')->get();
        $kelasList = Santri::query()->select('kelas')->whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $data = $this->buildRekapPerKelas($tanggal, $jadwalId ? (int) $jadwalId : null, $kelas, $search);

        return view('rekap', [
            'tanggal' => $tanggal,
            'search' => $search,
            'jadwals' => $jadwals,
            'kelasList' => $kelasList,
            'selectedJadwalId' => $jadwalId,
            'selectedKelas' => $kelas,
            'jadwal' => $data['jadwal'],
            'kegiatanBerlaku' => $data['kegiatanBerlaku'],
            'rows' => $data['rows'],
            'summary' => $data['summary'],
        ]);
    }

    // ✅ Untuk fetch data realtime (AJAX di halaman rekap)
    public function rekapData(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());
        $search = $request->input('search');
        $jadwalId = $request->input('jadwal_id');
        $kelas = $request->input('kelas');

        $data = $this->buildRekapPerKelas($tanggal, $jadwalId ? (int) $jadwalId : null, $kelas, $search);

        return view('partials.rekap-table', [
            'tanggal' => $tanggal,
            'jadwal' => $data['jadwal'],
            'kegiatanBerlaku' => $data['kegiatanBerlaku'],
            'rows' => $data['rows'],
            'summary' => $data['summary'],
        ]);
    }

}
