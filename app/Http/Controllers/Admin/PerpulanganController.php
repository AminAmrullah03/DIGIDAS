<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perpulangan;
use App\Models\PerpulanganSantri;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PerpulanganController extends Controller
{
    /**
     * Daftar semua event perpulangan.
     */
    public function index()
    {
        $perpulanganList = Perpulangan::orderByDesc('tanggal_mulai')->paginate(10);

        return view('admin.perpulangan.index', compact('perpulanganList'));
    }

    /**
     * Form tambah perpulangan.
     */
    public function create()
    {
        return view('admin.perpulangan.create');
    }

    /**
     * Simpan perpulangan baru + otomatis daftarkan semua santri aktif.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_event'    => 'required|string|max:150',
            'tanggal_mulai' => 'required|date',
            'batas_kembali' => 'required|date|after_or_equal:tanggal_mulai',
            'keterangan'    => 'nullable|string|max:1000',
        ], [
            'nama_event.required'          => 'Nama event perpulangan wajib diisi.',
            'tanggal_mulai.required'       => 'Tanggal mulai wajib diisi.',
            'batas_kembali.required'       => 'Batas kembali wajib diisi.',
            'batas_kembali.after_or_equal' => 'Batas kembali tidak boleh sebelum tanggal mulai.',
        ]);

        $perpulangan = Perpulangan::create($validated);

        // Otomatis daftarkan semua santri aktif ke event ini
        $jumlah = $perpulangan->daftarkanSemuaSantri();

        return redirect()
            ->route('admin.perpulangan.index')
            ->with('success', "Event \"{$perpulangan->nama_event}\" berhasil dibuat. {$jumlah} santri terdaftar otomatis.");
    }

    /**
     * Rekap santri per event perpulangan dengan status checkpoint.
     */
    public function rekap(Request $request)
    {
        $perpulanganId = $request->input('perpulangan_id');
        $kelasFilter   = $request->input('kelas');
        $statusFilter  = $request->input('status'); // menunggu|sebagian|diizinkan|keluar|kembali|kabur|terlambat_kembali
        $search        = $request->input('search');

        $eventList = Perpulangan::orderByDesc('tanggal_mulai')->get();

        // Tentukan event aktif yang ditampilkan
        if ($perpulanganId) {
            $activeEvent = Perpulangan::find($perpulanganId);
        } else {
            $activeEvent = Perpulangan::aktif()->orderByDesc('tanggal_mulai')->first()
                ?? $eventList->first();
        }

        if ($activeEvent && $activeEvent->status === Perpulangan::STATUS_AKTIF) {
            $activeEvent->daftarkanSemuaSantri();
            $activeEvent->sinkronkanStatusOtomatis();
        }

        $query = PerpulanganSantri::with(['santri', 'approvals.approvedBy'])
            ->where('perpulangan_id', optional($activeEvent)->id);

        if ($kelasFilter) {
            $query->whereHas('santri', fn ($q) => $q->where('kelas', $kelasFilter));
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        if ($search) {
            $query->whereHas('santri', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $baseRows = PerpulanganSantri::where('perpulangan_id', optional($activeEvent)->id)->get();
        $rows = $query->get();

        // Statistik
        $stats = [
            'total'     => $baseRows->count(),
            'menunggu'  => $baseRows->where('status', PerpulanganSantri::STATUS_MENUNGGU)->count(),
            'sebagian'  => $baseRows->where('status', PerpulanganSantri::STATUS_SEBAGIAN)->count(),
            'diizinkan' => $baseRows->where('status', PerpulanganSantri::STATUS_DIIZINKAN)->count(),
            'keluar'    => $baseRows->where('status', PerpulanganSantri::STATUS_KELUAR)->count(),
            'kembali'   => $baseRows->where('status', PerpulanganSantri::STATUS_KEMBALI)->count(),
            'kabur'     => $baseRows->where('status', PerpulanganSantri::STATUS_KABUR)->count(),
            'terlambat_kembali' => $baseRows->where('status', PerpulanganSantri::STATUS_TERLAMBAT_KEMBALI)->count(),
        ];

        // Pagination manual
        $perPage     = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paged       = $rows->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $santriList = new LengthAwarePaginator(
            $paged,
            $rows->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $kelasList = Santri::daftarKelas();

        return view('admin.perpulangan.rekap', compact(
            'santriList',
            'eventList',
            'activeEvent',
            'stats',
            'kelasList',
        ));
    }

    /**
     * Tandai perpulangan sebagai selesai.
     */
    public function selesai(Perpulangan $perpulangan)
    {
        $perpulangan->update(['status' => Perpulangan::STATUS_SELESAI]);

        return redirect()
            ->route('admin.perpulangan.index')
            ->with('success', "Event \"{$perpulangan->nama_event}\" ditandai selesai.");
    }

    /**
     * Hapus event perpulangan.
     */
    public function destroy(Perpulangan $perpulangan)
    {
        $nama = $perpulangan->nama_event;
        $perpulangan->delete();

        return redirect()
            ->route('admin.perpulangan.index')
            ->with('success', "Event \"{$nama}\" berhasil dihapus.");
    }
}
