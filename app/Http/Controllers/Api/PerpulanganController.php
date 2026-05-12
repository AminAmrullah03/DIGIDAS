<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Perpulangan;
use App\Models\PerpulanganApproval;
use App\Models\PerpulanganSantri;
use App\Models\Santri;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerpulanganController extends Controller
{
    // ─── Helper: format data santri perpulangan ───────────────────────────────

    private function formatPerpulanganSantri(PerpulanganSantri $ps): array
    {
        $ps->load(['santri', 'approvals.approvedBy', 'perpulangan']);

        $approvals = $ps->approvals->mapWithKeys(fn ($a) => [
            $a->approval_type => [
                'approved_by'   => $a->approvedBy->name ?? '-',
                'approved_at'   => $a->approved_at->format('d/m/Y H:i'),
                'catatan'       => $a->catatan,
            ],
        ]);

        return [
            'id'            => $ps->id,
            'nis'           => $ps->nis,
            'nama'          => $ps->santri->nama,
            'kelas'         => $ps->santri->kelas,
            'status'        => $ps->status,
            'status_label'  => $ps->status_label,
            'keluar_at'     => optional($ps->keluar_at)->format('d/m/Y H:i'),
            'kembali_at'    => optional($ps->kembali_at)->format('d/m/Y H:i'),
            'approvals'     => $approvals,
            'boleh_keluar'  => $ps->bolehKeluar(),
            'event'         => [
                'id'            => $ps->perpulangan->id,
                'nama_event'    => $ps->perpulangan->nama_event,
                'batas_kembali' => $ps->perpulangan->batas_kembali->format('d/m/Y'),
            ],
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SCAN QR — ambil data santri dalam event aktif
    // GET /api/perpulangan/scan/{nis}
    // Role: superadmin, guru
    // ─────────────────────────────────────────────────────────────────────────

    public function scan(string $nis)
    {
        $santri = Santri::where('nis', $nis)->where('status', 'aktif')->first();

        if (! $santri) {
            return ApiResponse::error('Santri tidak ditemukan atau tidak aktif.', 404);
        }

        // Cari event aktif terbaru
        $event = Perpulangan::aktif()->orderByDesc('tanggal_mulai')->first();

        if (! $event) {
            return ApiResponse::error('Tidak ada event perpulangan aktif saat ini.', 404);
        }

        $ps = PerpulanganSantri::where('perpulangan_id', $event->id)
            ->where('nis', $nis)
            ->first();

        if (! $ps) {
            return ApiResponse::error('Santri tidak terdaftar dalam event perpulangan ini.', 404);
        }

        return ApiResponse::success($this->formatPerpulanganSantri($ps), 'Data santri ditemukan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // APPROVE MUSRIF
    // POST /api/perpulangan/approve/musrif
    // Role: superadmin, guru
    // Body: { nis }
    // ─────────────────────────────────────────────────────────────────────────

    public function approveMusrif(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        $ps = $this->getActivePerpulanganSantri($request->nis);
        if ($ps instanceof \Illuminate\Http\JsonResponse) return $ps;

        if ($ps->hasMusrif()) {
            return ApiResponse::error('Santri ini sudah mendapat TTD musrif.', 422);
        }

        DB::transaction(function () use ($ps, $request) {
            PerpulanganApproval::create([
                'perpulangan_santri_id' => $ps->id,
                'approval_type'         => 'musrif',
                'approved_by'           => $request->user()->id,
                'approved_at'           => now(),
                'catatan'               => $request->input('catatan'),
            ]);

            $ps->recalculateStatus();
        });

        $ps->refresh();
        return ApiResponse::success($this->formatPerpulanganSantri($ps), 'TTD musrif berhasil diberikan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // APPROVE SPP
    // POST /api/perpulangan/approve/spp
    // Role: superadmin ONLY
    // Body: { nis }
    // ─────────────────────────────────────────────────────────────────────────

    public function approveSpp(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        // Double-check role (walaupun sudah di-guard di route)
        if (! $request->user()->isSuperAdmin()) {
            return ApiResponse::error('Hanya superadmin yang dapat melakukan approval SPP.', 403);
        }

        $ps = $this->getActivePerpulanganSantri($request->nis);
        if ($ps instanceof \Illuminate\Http\JsonResponse) return $ps;

        if ($ps->hasSpp()) {
            return ApiResponse::error('Santri ini sudah mendapat TTD SPP/kantor.', 422);
        }

        DB::transaction(function () use ($ps, $request) {
            PerpulanganApproval::create([
                'perpulangan_santri_id' => $ps->id,
                'approval_type'         => 'spp',
                'approved_by'           => $request->user()->id,
                'approved_at'           => now(),
                'catatan'               => $request->input('catatan'),
            ]);

            $ps->recalculateStatus();
        });

        $ps->refresh();
        return ApiResponse::success($this->formatPerpulanganSantri($ps), 'TTD SPP berhasil diberikan.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // APPROVE KEAMANAN (GERBANG KELUAR)
    // POST /api/perpulangan/approve/keamanan
    // Role: superadmin, guru
    // Body: { nis }
    //
    // Sistem otomatis validasi: musrif + spp harus sudah ada
    // ─────────────────────────────────────────────────────────────────────────

    public function approveKeamanan(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        $ps = $this->getActivePerpulanganSantri($request->nis);
        if ($ps instanceof \Illuminate\Http\JsonResponse) return $ps;

        // Cek santri belum keluar
        if ($ps->status === PerpulanganSantri::STATUS_KELUAR) {
            return ApiResponse::error('Santri ini sudah tercatat keluar.', 422);
        }

        if ($ps->status === PerpulanganSantri::STATUS_KEMBALI) {
            return ApiResponse::error('Santri ini sudah kembali ke pondok.', 422);
        }

        // VALIDASI UTAMA: harus punya TTD musrif dan spp
        if (! $ps->hasMusrif()) {
            return ApiResponse::error('❌ Belum ada TTD musrif. Santri belum boleh keluar.', 422);
        }

        if (! $ps->hasSpp()) {
            return ApiResponse::error('❌ Belum ada TTD SPP/kantor. Santri belum boleh keluar.', 422);
        }

        DB::transaction(function () use ($ps, $request) {
            PerpulanganApproval::create([
                'perpulangan_santri_id' => $ps->id,
                'approval_type'         => 'keamanan',
                'approved_by'           => $request->user()->id,
                'approved_at'           => now(),
                'catatan'               => $request->input('catatan'),
            ]);

            $ps->update([
                'status'    => PerpulanganSantri::STATUS_KELUAR,
                'keluar_at' => now(),
            ]);
        });

        $ps->refresh();
        return ApiResponse::success($this->formatPerpulanganSantri($ps), '✅ Santri diizinkan keluar.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // KEMBALI (CHECK-IN PULANG)
    // POST /api/perpulangan/kembali
    // Role: superadmin, guru
    // Body: { nis }
    // ─────────────────────────────────────────────────────────────────────────

    public function kembali(Request $request)
    {
        $request->validate(['nis' => 'required|string']);

        $ps = $this->getActivePerpulanganSantri($request->nis);
        if ($ps instanceof \Illuminate\Http\JsonResponse) return $ps;

        if ($ps->status === PerpulanganSantri::STATUS_KEMBALI) {
            return ApiResponse::error('Santri ini sudah tercatat kembali.', 422);
        }

        // Santri harus sudah keluar dulu (sudah dapat TTD keamanan)
        if ($ps->status !== PerpulanganSantri::STATUS_KELUAR) {
            return ApiResponse::error('Santri belum tercatat keluar. Tidak bisa diproses kembali.', 422);
        }

        $ps->update([
            'status'     => PerpulanganSantri::STATUS_KEMBALI,
            'kembali_at' => now(),
        ]);

        $ps->refresh();
        return ApiResponse::success($this->formatPerpulanganSantri($ps), '✅ Santri berhasil dicatat kembali ke pondok.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REKAP API (untuk keperluan dashboard/mobile)
    // GET /api/perpulangan/rekap?perpulangan_id=&status=&kelas=
    // Role: superadmin, guru
    // ─────────────────────────────────────────────────────────────────────────

    public function rekap(Request $request)
    {
        $perpulanganId = $request->input('perpulangan_id');
        $statusFilter  = $request->input('status');
        $kelasFilter   = $request->input('kelas');

        if ($perpulanganId) {
            $event = Perpulangan::find($perpulanganId);
        } else {
            $event = Perpulangan::aktif()->orderByDesc('tanggal_mulai')->first();
        }

        if (! $event) {
            return ApiResponse::error('Event perpulangan tidak ditemukan.', 404);
        }

        $query = PerpulanganSantri::with(['santri', 'approvals'])
            ->where('perpulangan_id', $event->id);

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($kelasFilter) {
            $query->whereHas('santri', fn ($q) => $q->where('kelas', $kelasFilter));
        }

        $rows = $query->get();

        $stats = [
            'total'     => $rows->count(),
            'menunggu'  => $rows->where('status', 'menunggu')->count(),
            'sebagian'  => $rows->where('status', 'sebagian')->count(),
            'diizinkan' => $rows->where('status', 'diizinkan')->count(),
            'keluar'    => $rows->where('status', 'keluar')->count(),
            'kembali'   => $rows->where('status', 'kembali')->count(),
        ];

        return ApiResponse::success([
            'event' => [
                'id'            => $event->id,
                'nama_event'    => $event->nama_event,
                'tanggal_mulai' => $event->tanggal_mulai->format('d/m/Y'),
                'batas_kembali' => $event->batas_kembali->format('d/m/Y'),
                'status'        => $event->status,
            ],
            'stats'  => $stats,
            'santri' => $rows->map(fn ($ps) => $this->formatPerpulanganSantri($ps)),
        ]);
    }

    // ─── Private Helper ───────────────────────────────────────────────────────

    /**
     * Ambil PerpulanganSantri berdasarkan NIS dari event aktif.
     * Return JsonResponse jika error, PerpulanganSantri jika sukses.
     */
    private function getActivePerpulanganSantri(string $nis): PerpulanganSantri|\Illuminate\Http\JsonResponse
    {
        $event = Perpulangan::aktif()->orderByDesc('tanggal_mulai')->first();

        if (! $event) {
            return ApiResponse::error('Tidak ada event perpulangan aktif saat ini.', 404);
        }

        $ps = PerpulanganSantri::where('perpulangan_id', $event->id)
            ->where('nis', $nis)
            ->first();

        if (! $ps) {
            return ApiResponse::error('Santri tidak terdaftar dalam event perpulangan aktif.', 404);
        }

        return $ps;
    }
}