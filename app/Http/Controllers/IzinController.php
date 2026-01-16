<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Santri;

class IzinController extends Controller
{
    public function index()
    {
        return view('izin.scan');
    }

    public function getSantri(Request $request)
    {
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
            ->where('status', 'Belum Kembali')
            ->first();

        return response()->json([
            'success' => true,
            'santri' => [
                'nis' => $santri->nis,
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
            ],
            'izin_aktif' => $izinAktif ? [
                'id' => $izinAktif->id,
                'keperluan' => $izinAktif->keperluan,
                'waktu_keluar' => $izinAktif->waktu_keluar->format('d/m/Y H:i'),
            ] : null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'keperluan' => 'required|string|max:500',
        ]);

        $santri = Santri::where('nis', $request->nis)->first();

        if (!$santri) {
            return response()->json([
                'success' => false,
                'message' => 'NIS tidak ditemukan!'
            ], 404);
        }

        // Cek apakah santri sedang dalam izin
        $izinAktif = Izin::where('nis', $santri->nis)
            ->where('status', 'Belum Kembali')
            ->first();

        if ($izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri masih dalam izin sebelumnya dan belum kembali!',
                'izin' => [
                    'keperluan' => $izinAktif->keperluan,
                    'waktu_keluar' => $izinAktif->waktu_keluar->format('d/m/Y H:i'),
                ]
            ], 400);
        }

        $now = now()->setTimezone('Asia/Jakarta');

        $izin = Izin::create([
            'nis' => $santri->nis,
            'keperluan' => $request->keperluan,
            'waktu_keluar' => $now,
            'status' => 'Belum Kembali',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Izin berhasil dicatat!',
            'data' => [
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'keperluan' => $izin->keperluan,
                'waktu_keluar' => $now->format('H:i'),
            ]
        ]);
    }

    public function kembali(Request $request)
    {
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
            ->where('status', 'Belum Kembali')
            ->first();

        if (!$izinAktif) {
            return response()->json([
                'success' => false,
                'message' => 'Santri tidak memiliki izin aktif!'
            ], 400);
        }

        $now = now()->setTimezone('Asia/Jakarta');

        $izinAktif->update([
            'waktu_kembali' => $now,
            'status' => 'Sudah Kembali',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Santri telah kembali!',
            'data' => [
                'nama' => $santri->nama,
                'kelas' => $santri->kelas,
                'waktu_kembali' => $now->format('H:i'),
            ]
        ]);
    }

    public function rekap(Request $request)
    {
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
        $request->validate([
            'id' => 'required|integer|exists:izin,id',
            'status' => 'required|in:Belum Kembali,Sudah Kembali',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $izin = Izin::findOrFail($request->id);
        $now = now()->setTimezone('Asia/Jakarta');

        $updateData = [
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        if ($request->status === 'Sudah Kembali' && !$izin->waktu_kembali) {
            $updateData['waktu_kembali'] = $now;
        }

        $izin->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah!',
            'data' => [
                'status' => $izin->status,
                'waktu_kembali' => $izin->waktu_kembali ? $izin->waktu_kembali->format('H:i') : null,
            ]
        ]);
    }
}
