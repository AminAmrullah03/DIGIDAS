<?php

namespace App\Http\Controllers;

use App\Models\IzinPulang;
use App\Models\Santri;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IzinPulangController extends Controller
{
    public function index()
    {
        return view('izin-pulang.scan');
    }

    public function getSantri(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $request->validate([
            'nis' => 'required|string',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (! $santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan di database!'
            ], 404);
        }

        $izinAktif = IzinPulang::where('nis', $santri->nis)
            ->where('status', IzinPulang::STATUS_BELUM_KEMBALI)
            ->first();

        return response()->json([
            'success' => true,
            'santri' => [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
            ],
            'izin_aktif' => $izinAktif ? $this->izinPayload($izinAktif) : null,
        ]);
    }

    public function store(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $request->validate([
            'nis' => 'required|string',
            'keperluan' => 'required|string|max:500',
            'durasi_hari' => 'required|integer|min:1|max:365',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (! $santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan!'
            ], 404);
        }

        $izinAktif = IzinPulang::where('nis', $santri->nis)
            ->where('status', IzinPulang::STATUS_BELUM_KEMBALI)
            ->first();

        if ($izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri masih dalam izin pulang sebelumnya dan belum kembali!',
                'izin' => $this->izinPayload($izinAktif),
            ], 400);
        }

        $now = now('Asia/Jakarta');
        $batasWaktu = $now->copy()->addDays((int) $request->durasi_hari);

        $izin = IzinPulang::create([
            'nis' => $santri->nis,
            'keperluan' => $request->keperluan,
            'durasi_hari' => (int) $request->durasi_hari,
            'waktu_pulang' => $now,
            'batas_waktu_kembali' => $batasWaktu,
            'status' => IzinPulang::STATUS_BELUM_KEMBALI,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin pulang berhasil dicatat!',
            'data' => $this->izinPayload($izin->fresh()),
        ]);
    }

    public function rekap(Request $request)
    {
        $this->tandaiKaburOtomatis();

        $tanggal = $request->input('tanggal', now('Asia/Jakarta')->toDateString());
        $kelasFilter = $request->input('kelas');
        $statusFilter = $request->input('status');

        $kelasList = Santri::select('kelas')->distinct()->orderBy('kelas')->pluck('kelas');

        $query = IzinPulang::with('santri')
            ->whereDate('waktu_pulang', $tanggal)
            ->orderByDesc('waktu_pulang');

        if ($kelasFilter) {
            $query->whereHas('santri', function ($q) use ($kelasFilter) {
                $q->where('kelas', $kelasFilter);
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $izinList = $query->get();

        return view('izin-pulang.rekap', compact('izinList', 'kelasList', 'kelasFilter', 'statusFilter', 'tanggal'));
    }

    public function kembali(IzinPulang $izinPulang)
    {
        $this->tandaiKaburOtomatis();
        $izinPulang->refresh();

        if ($izinPulang->status === IzinPulang::STATUS_KABUR) {
            return response()->json([
                'success' => false,
                'message' => 'Izin pulang ini sudah tercatat Kabur.'
            ], 409);
        }

        if (in_array($izinPulang->status, [IzinPulang::STATUS_SUDAH_KEMBALI, IzinPulang::STATUS_TERLAMBAT], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Izin pulang ini sudah tercatat kembali.'
            ], 409);
        }

        $now = now('Asia/Jakarta');
        $terlambatMenit = $this->hitungTerlambatMenit($izinPulang, $now);
        $status = $terlambatMenit > 0
            ? IzinPulang::STATUS_TERLAMBAT
            : IzinPulang::STATUS_SUDAH_KEMBALI;

        $izinPulang->update([
            'waktu_kembali' => $now,
            'terlambat_menit' => $terlambatMenit,
            'status' => $status,
        ]);

        $izinPulang->refresh();

        return response()->json([
            'success' => true,
            'message' => $status === IzinPulang::STATUS_TERLAMBAT
                ? 'Santri telah kembali, tetapi terlambat '.IzinPulang::formatMinutes($terlambatMenit).'.'
                : 'Santri telah kembali tepat waktu!',
            'data' => $this->izinPayload($izinPulang),
        ]);
    }

    private function tandaiKaburOtomatis(): void
    {
        IzinPulang::where('status', IzinPulang::STATUS_BELUM_KEMBALI)
            ->where('batas_waktu_kembali', '<=', now('Asia/Jakarta')->subDay())
            ->update([
                'status' => IzinPulang::STATUS_KABUR,
                'keterangan' => 'Otomatis tercatat Kabur karena tidak kembali lebih dari 1 hari setelah tenggat izin pulang.',
            ]);
    }

    private function hitungTerlambatMenit(IzinPulang $izinPulang, Carbon $waktuKembali): int
    {
        if (! $izinPulang->batas_waktu_kembali || $waktuKembali->lessThanOrEqualTo($izinPulang->batas_waktu_kembali)) {
            return 0;
        }

        return (int) ceil($izinPulang->batas_waktu_kembali->diffInSeconds($waktuKembali) / 60);
    }

    private function izinPayload(IzinPulang $izinPulang): array
    {
        return [
            'id' => $izinPulang->id,
            'nis' => $izinPulang->nis,
            'keperluan' => $izinPulang->keperluan,
            'durasi_hari' => $izinPulang->durasi_hari,
            'durasi_label' => $izinPulang->durasi_label,
            'waktu_pulang' => $izinPulang->waktu_pulang?->format('d/m/Y H:i'),
            'batas_waktu_kembali' => $izinPulang->batas_waktu_kembali?->format('d/m/Y H:i'),
            'waktu_kembali' => $izinPulang->waktu_kembali?->format('d/m/Y H:i'),
            'status' => $izinPulang->status,
            'terlambat_menit' => $izinPulang->keterlambatan_menit,
            'ketepatan_label' => $izinPulang->ketepatan_label,
        ];
    }
}
