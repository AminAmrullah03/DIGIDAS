<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Santri;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        return view('izin.scan');
    }

    public function getSantri(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $request->validate([
            'nis' => 'required|string',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan di database!'
            ], 404);
        }

        // Cek apakah santri sedang dalam izin (belum kembali)
        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();
        $izinTerakhir = Izin::where('nis', $santri->nis)
            ->latest('waktu_keluar')
            ->first();

        return response()->json([
            'success' => true,
            'santri' => [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
            ],
            'izin_aktif' => $izinAktif ? $this->izinPayload($izinAktif) : null,
            'izin_terakhir' => $izinTerakhir ? $this->izinPayload($izinTerakhir) : null,
        ]);
    }

    public function store(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $request->validate([
            'nis' => 'required|string',
            'keperluan' => 'required|string|max:500',
            'batas_waktu_kembali' => 'required|date',
        ]);

        $now = now('Asia/Jakarta');
        $batasWaktu = Carbon::parse($request->batas_waktu_kembali, 'Asia/Jakarta');

        if ($batasWaktu->lessThanOrEqualTo($now)) {
            return response()->json([
                'success' => false,
                'message' => 'Tenggat kembali harus lebih besar dari waktu sekarang!'
            ], 422);
        }

        if ($batasWaktu->greaterThan($now->copy()->addDay())) {
            return response()->json([
                'success' => false,
                'message' => 'Durasi izin keluar maksimal 1 hari!'
            ], 422);
        }

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan!'
            ], 404);
        }

        // Cek apakah santri sedang dalam izin
        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();

        if ($izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri masih dalam izin keluar sebelumnya dan belum kembali!',
                'izin' => [
                    'keperluan' => $izinAktif->keperluan,
                    'waktu_keluar' => $izinAktif->waktu_keluar->format('d/m/Y H:i'),
                    'batas_waktu_kembali' => $izinAktif->batas_waktu_kembali?->format('d/m/Y H:i'),
                ]
            ], 400);
        }

        $durasiMenit = max(1, (int) ceil($now->diffInSeconds($batasWaktu) / 60));

        $izin = Izin::create([
            'nis' => $santri->nis,
            'keperluan' => $request->keperluan,
            'durasi_menit' => $durasiMenit,
            'waktu_keluar' => $now,
            'batas_waktu_kembali' => $batasWaktu,
            'status' => Izin::STATUS_BELUM_KEMBALI,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin keluar berhasil dicatat!',
            'data' => [
                'id' => $izin->id,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'keperluan' => $izin->keperluan,
                'durasi_menit' => $izin->durasi_menit,
                'durasi_label' => $izin->durasi_label,
                'waktu_keluar' => $now->format('H:i'),
                'batas_waktu_kembali' => $batasWaktu->format('d/m/Y H:i'),
            ]
        ]);
    }

    public function kembali(Request $request)
    {
        $this->tandaiKaburOtomatis();

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

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();

        if (!$izinAktif) {
            $izinTerakhir = Izin::where('nis', $santri->nis)->latest('waktu_keluar')->first();
            if ($izinTerakhir?->status === Izin::STATUS_KABUR) {
                return response()->json([
                    'success' => false,
                    'message' => 'Santri sudah tercatat Kabur karena tidak kembali lebih dari 1 hari.',
                    'data' => $this->izinPayload($izinTerakhir),
                ], 409);
            }

            return response()->json([
                'success' => false,
                'message' => 'Santri tidak memiliki izin keluar aktif!'
            ], 400);
        }

        return $this->catatKembali($izinAktif, $santri);
    }

    public function kembaliById(Izin $izin)
    {
        $this->tandaiKaburOtomatis();
        $izin->refresh();

        if ($izin->status === Izin::STATUS_SUDAH_KEMBALI || $izin->status === Izin::STATUS_TERLAMBAT) {
            return response()->json([
                'success' => false,
                'message' => 'Izin keluar ini sudah tercatat kembali!'
            ], 409);
        }

        if ($izin->status === Izin::STATUS_KABUR) {
            return response()->json([
                'success' => false,
                'message' => 'Izin keluar ini sudah tercatat Kabur karena melewati 1 hari.'
            ], 409);
        }

        return $this->catatKembali($izin, $izin->santri);
    }

    public function rekap(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $tanggal = $request->input('tanggal', now()->toDateString());
        $kelasFilter = $request->input('kelas');
        $statusFilter = $request->input('status');

        $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $query = Izin::with('santri')
            ->whereDate('waktu_keluar', $tanggal)
            ->orderBy('waktu_keluar', 'desc');

        if ($kelasFilter) {
            $query->whereHas('santri', function ($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $izinList = $query->get();

        return view('izin.rekap', compact('izinList', 'kelasList', 'kelasFilter', 'statusFilter', 'tanggal'));
    }

    public function updateStatus(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $request->validate([
            'id' => 'required|integer|exists:izin,id',
            'status' => 'required|in:Belum Kembali,Sudah Kembali,Terlambat,Kabur',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $izin = Izin::findOrFail($request->id);
        $now = now('Asia/Jakarta');

        $updateData = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        if (in_array($request->status, [Izin::STATUS_SUDAH_KEMBALI, Izin::STATUS_TERLAMBAT], true) && !$izin->waktu_kembali) {
            $updateData['waktu_kembali'] = $now;
            $updateData['terlambat_menit'] = $this->hitungTerlambatMenit($izin, $now);
            $updateData['status'] = $updateData['terlambat_menit'] > 0
                ? Izin::STATUS_TERLAMBAT
                : Izin::STATUS_SUDAH_KEMBALI;
        }

        $izin->update($updateData);
        $izin->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah!',
            'data' => [
                'status' => $izin->status,
                'waktu_kembali' => $izin->waktu_kembali ? $izin->waktu_kembali->format('H:i') : null,
                'terlambat_menit' => $izin->keterlambatan_menit,
                'ketepatan_label' => $izin->ketepatan_label,
            ]
        ]);
    }

    private function catatKembali(Izin $izin, ?Santri $santri)
    {
        $now = now('Asia/Jakarta');
        $terlambatMenit = $this->hitungTerlambatMenit($izin, $now);
        $status = $terlambatMenit > 0
            ? Izin::STATUS_TERLAMBAT
            : Izin::STATUS_SUDAH_KEMBALI;

        $izin->update([
            'waktu_kembali' => $now,
            'terlambat_menit' => $terlambatMenit,
            'status' => $status,
        ]);
        $izin->refresh();

        return response()->json([
            'success' => true,
            'message' => $status === Izin::STATUS_TERLAMBAT
                ? 'Santri telah kembali, tetapi terlambat '.Izin::formatMinutes($terlambatMenit).'.'
                : 'Santri telah kembali tepat waktu!',
            'data' => [
                'id' => $izin->id,
                'nama' => $santri?->nama,
                'kelas' => $santri?->kelas,
                'status' => $izin->status,
                'waktu_kembali' => $now->format('H:i'),
                'terlambat_menit' => $izin->keterlambatan_menit,
                'terlambat_label' => $izin->keterlambatan_menit > 0
                    ? Izin::formatMinutes($izin->keterlambatan_menit)
                    : null,
                'ketepatan_label' => $izin->ketepatan_label,
            ]
        ]);
    }

    private function tandaiKaburOtomatis(): void
    {
        Izin::where('status', Izin::STATUS_BELUM_KEMBALI)
            ->where('waktu_keluar', '<=', now('Asia/Jakarta')->subDay())
            ->update([
                'status' => Izin::STATUS_KABUR,
                'keterangan' => 'Otomatis tercatat Kabur karena tidak kembali lebih dari 1 hari.',
            ]);
    }

    private function hitungTerlambatMenit(Izin $izin, Carbon $waktuKembali): int
    {
        if (! $izin->batas_waktu_kembali || $waktuKembali->lessThanOrEqualTo($izin->batas_waktu_kembali)) {
            return 0;
        }

        return (int) ceil($izin->batas_waktu_kembali->diffInSeconds($waktuKembali) / 60);
    }

    private function izinPayload(Izin $izin): array
    {
        return [
            'id' => $izin->id,
            'nis' => $izin->nis,
            'keperluan' => $izin->keperluan,
            'durasi_menit' => $izin->durasi_menit,
            'durasi_label' => $izin->durasi_label,
            'waktu_keluar' => $izin->waktu_keluar?->format('d/m/Y H:i'),
            'batas_waktu_kembali' => $izin->batas_waktu_kembali?->format('d/m/Y H:i'),
            'waktu_kembali' => $izin->waktu_kembali?->format('d/m/Y H:i'),
            'status' => $izin->status,
            'terlambat_menit' => $izin->keterlambatan_menit,
            'ketepatan_label' => $izin->ketepatan_label,
        ];
    }
}
