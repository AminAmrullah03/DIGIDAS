<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\JadwalAbsen;
use App\Models\Santri;
use App\Models\TahunAjaran;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return ApiResponse::error('NIS tidak ditemukan di database.', 404);
        }

        $now = now('Asia/Jakarta');
        $today = $now->toDateString();
        $jadwal = $this->activeSchedule($now);

        if (! $jadwal) {
            return ApiResponse::error(
                'Bukan waktu absensi.',
                409,
                null,
                [
                    'santri' => $this->santriPayload($santri),
                    'jadwal' => null,
                    'waktu' => $now->format('H:i:s'),
                ]
            );
        }

        $sudahAbsen = Absensi::where('nis', $santri->nis)
            ->where('jadwal_id', $jadwal->id)
            ->whereDate('waktu', $today)
            ->exists();

        if ($sudahAbsen) {
            return ApiResponse::error(
                "Santri ini sudah absen untuk kegiatan {$jadwal->nama_kegiatan} hari ini.",
                409,
                null,
                [
                    'santri' => $this->santriPayload($santri),
                    'jadwal' => $this->jadwalPayload($jadwal),
                    'waktu' => $now->format('H:i:s'),
                ]
            );
        }

        $tahunAjaran = TahunAjaran::getAktif();

        $absensi = Absensi::create([
            'nis' => $santri->nis,
            'jadwal_id' => $jadwal->id,
            'tahun_ajaran_id' => $tahunAjaran?->id,
            'status' => 'Hadir',
            'kegiatan' => $jadwal->nama_kegiatan,
            'waktu' => $now,
        ]);

        return ApiResponse::success(
            [
                'id' => $absensi->id,
                'santri' => $this->santriPayload($santri),
                'jadwal' => $this->jadwalPayload($jadwal),
                'status' => $absensi->status,
                'waktu' => $now->toDateTimeString(),
            ],
            "Absensi berhasil dicatat untuk {$jadwal->nama_kegiatan}.",
            201
        );
    }

    public function rekap(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'jadwal_id' => ['nullable', 'integer', 'exists:jadwal_absen,id'],
        ]);

        $tanggal = $validated['tanggal'] ?? now('Asia/Jakarta')->toDateString();
        $kelas = $validated['kelas'] ?? null;
        $jadwalId = $validated['jadwal_id'] ?? null;
        $rekap = collect();

        if ($jadwalId) {
            $jadwal = JadwalAbsen::find($jadwalId);

            $rekap = Santri::query()
                ->when($kelas, fn ($query) => $query->where('kelas', $kelas))
                ->orderBy('nama')
                ->get()
                ->map(function (Santri $santri) use ($tanggal, $jadwalId, $jadwal) {
                    $absensi = Absensi::where('nis', $santri->nis)
                        ->where('jadwal_id', $jadwalId)
                        ->whereDate('waktu', $tanggal)
                        ->first();

                    return [
                        'nis' => $santri->nis,
                        'nama' => $santri->nama,
                        'kelas' => $santri->kelas,
                        'kegiatan' => $jadwal?->nama_kegiatan,
                        'waktu' => $absensi?->waktu,
                        'status' => $absensi?->status ?? 'Alpha',
                    ];
                });
        }

        return ApiResponse::success($rekap->values(), 'Data rekap absensi berhasil diambil.', 200, [
            'filters' => [
                'tanggal' => $tanggal,
                'kelas' => $kelas,
                'jadwal_id' => $jadwalId,
            ],
        ]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'exists:santri,nis'],
            'jadwal_id' => ['required', 'integer', 'exists:jadwal_absen,id'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Izin,Sakit,Alpha'],
        ]);

        $jadwal = JadwalAbsen::findOrFail($validated['jadwal_id']);

        $absensi = Absensi::where('nis', $validated['nis'])
            ->where('jadwal_id', $validated['jadwal_id'])
            ->whereDate('waktu', $validated['tanggal'])
            ->first();

        if ($absensi) {
            $absensi->update(['status' => $validated['status']]);
        } else {
            $tahunAjaran = TahunAjaran::getAktif();

            $absensi = Absensi::create([
                'nis' => $validated['nis'],
                'jadwal_id' => $validated['jadwal_id'],
                'tahun_ajaran_id' => $tahunAjaran?->id,
                'status' => $validated['status'],
                'kegiatan' => $jadwal->nama_kegiatan,
                'waktu' => $validated['tanggal'].' 00:00:00',
            ]);
        }

        return ApiResponse::success(
            [
                'id' => $absensi->id,
                'nis' => $absensi->nis,
                'jadwal_id' => $absensi->jadwal_id,
                'status' => $absensi->status,
                'waktu' => $absensi->waktu,
            ],
            'Status absensi berhasil diperbarui.'
        );
    }

    private function activeSchedule(\DateTimeInterface $now): ?JadwalAbsen
    {
        $time = $now->format('H:i:s');
        $dayOfWeek = (int) $now->format('N');

        return JadwalAbsen::where('aktif', true)
            ->where('jam_mulai', '<=', $time)
            ->where('jam_selesai', '>=', $time)
            ->where(function ($query) use ($dayOfWeek) {
                $query->whereNull('hari')
                    ->orWhereJsonContains('hari', $dayOfWeek);
            })
            ->orderBy('jam_mulai')
            ->first();
    }

    private function santriPayload(Santri $santri): array
    {
        return [
            'nis' => $santri->nis,
            'nama' => $santri->nama,
            'kelas' => $santri->kelas,
            'gender' => $santri->gender,
            'jenjang' => $santri->jenjang,
            'status' => $santri->status,
        ];
    }

    private function jadwalPayload(JadwalAbsen $jadwal): array
    {
        return [
            'id' => $jadwal->id,
            'nama_kegiatan' => $jadwal->nama_kegiatan,
            'jam_mulai' => $jadwal->jam_mulai,
            'jam_selesai' => $jadwal->jam_selesai,
            'hari' => $jadwal->hari,
            'aktif' => $jadwal->aktif,
        ];
    }
}
