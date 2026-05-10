<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Santri;
use App\Support\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function santri(Request $request): JsonResponse
    {
        $this->tandaiKaburOtomatis();

        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return ApiResponse::error('NIS tidak ditemukan di database.', 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();
        $izinTerakhir = Izin::where('nis', $santri->nis)
            ->latest('waktu_keluar')
            ->first();

        return ApiResponse::success([
            'santri' => $this->santriPayload($santri),
            'izin_aktif' => $izinAktif ? $this->izinPayload($izinAktif) : null,
            'izin_terakhir' => $izinTerakhir ? $this->izinPayload($izinTerakhir) : null,
        ], 'Data izin keluar santri berhasil diambil.');
    }

    public function store(Request $request): JsonResponse
    {
        $this->tandaiKaburOtomatis();

        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
            'keperluan' => ['required', 'string', 'max:500'],
            'batas_waktu_kembali' => ['required', 'date'],
        ]);

        $now = now('Asia/Jakarta');
        $batasWaktu = Carbon::parse($validated['batas_waktu_kembali'], 'Asia/Jakarta');

        if ($batasWaktu->lessThanOrEqualTo($now)) {
            return ApiResponse::error('Tenggat kembali harus lebih besar dari waktu sekarang.', 422);
        }

        if ($batasWaktu->greaterThan($now->copy()->addDay())) {
            return ApiResponse::error('Durasi izin keluar maksimal 1 hari.', 422);
        }

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return ApiResponse::error('NIS tidak ditemukan.', 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();

        if ($izinAktif) {
            return ApiResponse::error(
                'Santri masih dalam izin keluar sebelumnya dan belum kembali.',
                409,
                null,
                ['izin' => $this->izinPayload($izinAktif)]
            );
        }

        $durasiMenit = max(1, (int) ceil($now->diffInSeconds($batasWaktu) / 60));

        $izin = Izin::create([
            'nis' => $santri->nis,
            'keperluan' => $validated['keperluan'],
            'durasi_menit' => $durasiMenit,
            'waktu_keluar' => $now,
            'batas_waktu_kembali' => $batasWaktu,
            'status' => Izin::STATUS_BELUM_KEMBALI,
        ]);

        return ApiResponse::success(
            [
                'santri' => $this->santriPayload($santri),
                'izin' => $this->izinPayload($izin),
            ],
            'Izin keluar berhasil dicatat.',
            201
        );
    }

    public function kembali(Request $request): JsonResponse
    {
        $this->tandaiKaburOtomatis();

        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return ApiResponse::error('NIS tidak ditemukan.', 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', Izin::STATUS_BELUM_KEMBALI)
            ->first();

        if (! $izinAktif) {
            $izinTerakhir = Izin::where('nis', $santri->nis)->latest('waktu_keluar')->first();

            if ($izinTerakhir?->status === Izin::STATUS_KABUR) {
                return ApiResponse::error(
                    'Santri sudah tercatat Kabur karena tidak kembali lebih dari 1 hari.',
                    409,
                    null,
                    ['izin' => $this->izinPayload($izinTerakhir)]
                );
            }

            return ApiResponse::error('Santri tidak memiliki izin keluar aktif.', 409);
        }

        $now = now('Asia/Jakarta');
        $terlambatMenit = $this->hitungTerlambatMenit($izinAktif, $now);
        $status = $terlambatMenit > 0
            ? Izin::STATUS_TERLAMBAT
            : Izin::STATUS_SUDAH_KEMBALI;

        $izinAktif->update([
            'waktu_kembali' => $now,
            'terlambat_menit' => $terlambatMenit,
            'status' => $status,
        ]);

        return ApiResponse::success(
            [
                'santri' => $this->santriPayload($santri),
                'izin' => $this->izinPayload($izinAktif->fresh()),
            ],
            $status === Izin::STATUS_TERLAMBAT
                ? 'Santri telah kembali, tetapi terlambat '.Izin::formatMinutes($terlambatMenit).'.'
                : 'Santri telah kembali tepat waktu.'
        );
    }

    public function rekap(Request $request): JsonResponse
    {
        $this->tandaiKaburOtomatis();

        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'in:Belum Kembali,Sudah Kembali,Terlambat,Kabur'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $tanggal = $validated['tanggal'] ?? now('Asia/Jakarta')->toDateString();

        $query = Izin::with('santri')
            ->whereDate('waktu_keluar', $tanggal)
            ->orderByDesc('waktu_keluar');

        if (! empty($validated['kelas'])) {
            $query->whereHas('santri', function ($subQuery) use ($validated) {
                $subQuery->where('kelas', $validated['kelas']);
            });
        }

        if (! empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        $izin = $query->paginate((int) ($validated['per_page'] ?? 20))->withQueryString();

        return ApiResponse::success($izin->items(), 'Data rekap izin berhasil diambil.', 200, [
            'filters' => [
                'tanggal' => $tanggal,
                'kelas' => $validated['kelas'] ?? null,
                'status' => $validated['status'] ?? null,
            ],
            'pagination' => [
                'current_page' => $izin->currentPage(),
                'last_page' => $izin->lastPage(),
                'per_page' => $izin->perPage(),
                'total' => $izin->total(),
            ],
        ]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $this->tandaiKaburOtomatis();

        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:izin,id'],
            'status' => ['required', 'in:Belum Kembali,Sudah Kembali,Terlambat,Kabur'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $izin = Izin::findOrFail($validated['id']);
        $data = [
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'] ?? null,
        ];

        if (in_array($validated['status'], [Izin::STATUS_SUDAH_KEMBALI, Izin::STATUS_TERLAMBAT], true) && ! $izin->waktu_kembali) {
            $now = now('Asia/Jakarta');
            $data['waktu_kembali'] = $now;
            $data['terlambat_menit'] = $this->hitungTerlambatMenit($izin, $now);
            $data['status'] = $data['terlambat_menit'] > 0
                ? Izin::STATUS_TERLAMBAT
                : Izin::STATUS_SUDAH_KEMBALI;
        }

        $izin->update($data);

        return ApiResponse::success($this->izinPayload($izin->fresh()), 'Status izin berhasil diperbarui.');
    }

    private function santriPayload(Santri $santri): array
    {
        return [
            'nis' => $santri->nis,
            'nama' => $santri->nama,
            'kelas' => $santri->kelas,
        ];
    }

    private function izinPayload(Izin $izin): array
    {
        return [
            'id' => $izin->id,
            'nis' => $izin->nis,
            'keperluan' => $izin->keperluan,
            'durasi_menit' => $izin->durasi_menit,
            'durasi_label' => $izin->durasi_label,
            'waktu_keluar' => $izin->waktu_keluar?->toDateTimeString(),
            'batas_waktu_kembali' => $izin->batas_waktu_kembali?->toDateTimeString(),
            'waktu_kembali' => $izin->waktu_kembali?->toDateTimeString(),
            'terlambat_menit' => $izin->keterlambatan_menit,
            'ketepatan_label' => $izin->ketepatan_label,
            'status' => $izin->status,
            'keterangan' => $izin->keterangan,
        ];
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
}
