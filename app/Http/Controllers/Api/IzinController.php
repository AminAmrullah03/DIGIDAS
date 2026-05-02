<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\Santri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function santri(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan di database.',
            ], 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', 'Belum Kembali')
            ->first();

        return response()->json([
            'success' => true,
            'santri' => $this->santriPayload($santri),
            'izin_aktif' => $izinAktif ? $this->izinPayload($izinAktif) : null,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
            'keperluan' => ['required', 'string', 'max:500'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan.',
            ], 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', 'Belum Kembali')
            ->first();

        if ($izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri masih dalam izin sebelumnya dan belum kembali.',
                'izin' => $this->izinPayload($izinAktif),
            ], 400);
        }

        $now = now('Asia/Jakarta');

        $izin = Izin::create([
            'nis' => $santri->nis,
            'keperluan' => $validated['keperluan'],
            'waktu_keluar' => $now,
            'status' => 'Belum Kembali',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin berhasil dicatat.',
            'data' => [
                'santri' => $this->santriPayload($santri),
                'izin' => $this->izinPayload($izin),
            ],
        ], 201);
    }

    public function kembali(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nis' => ['required', 'string', 'max:50'],
        ]);

        $santri = Santri::where('nis', $validated['nis'])->first();

        if (! $santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan.',
            ], 404);
        }

        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', 'Belum Kembali')
            ->first();

        if (! $izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri tidak memiliki izin aktif.',
            ], 400);
        }

        $izinAktif->update([
            'waktu_kembali' => now('Asia/Jakarta'),
            'status' => 'Sudah Kembali',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri telah kembali.',
            'data' => [
                'santri' => $this->santriPayload($santri),
                'izin' => $this->izinPayload($izinAktif->fresh()),
            ],
        ]);
    }

    public function rekap(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'tanggal' => ['nullable', 'date'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'in:Belum Kembali,Sudah Kembali'],
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

        return response()->json([
            'success' => true,
            'data' => $izin->items(),
            'filters' => [
                'tanggal' => $tanggal,
                'kelas' => $validated['kelas'] ?? null,
                'status' => $validated['status'] ?? null,
            ],
            'meta' => [
                'current_page' => $izin->currentPage(),
                'last_page' => $izin->lastPage(),
                'per_page' => $izin->perPage(),
                'total' => $izin->total(),
            ],
        ]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'integer', 'exists:izin,id'],
            'status' => ['required', 'in:Belum Kembali,Sudah Kembali'],
            'keterangan' => ['nullable', 'string', 'max:500'],
        ]);

        $izin = Izin::findOrFail($validated['id']);
        $data = [
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'] ?? null,
        ];

        if ($validated['status'] === 'Sudah Kembali' && ! $izin->waktu_kembali) {
            $data['waktu_kembali'] = now('Asia/Jakarta');
        }

        $izin->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Status izin berhasil diperbarui.',
            'data' => $this->izinPayload($izin->fresh()),
        ]);
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
            'waktu_keluar' => $izin->waktu_keluar?->toDateTimeString(),
            'waktu_kembali' => $izin->waktu_kembali?->toDateTimeString(),
            'status' => $izin->status,
            'keterangan' => $izin->keterangan,
        ];
    }
}
