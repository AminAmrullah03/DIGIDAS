<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $list   = TahunAjaran::withCount(['santriKelas', 'sppTagihan', 'sppPembayaran', 'absensi'])
            ->orderByDesc('id')
            ->get();
        $aktif  = TahunAjaran::getAktif();

        return view('admin.tahun-ajaran.index', compact('list', 'aktif'));
    }

    public function create()
    {
        return view('admin.tahun-ajaran.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'           => 'required|string|max:20|unique:tahun_ajaran,nama',
            'tahun_hijriah'  => 'required|integer|min:1400|max:1600|unique:tahun_ajaran,tahun_hijriah',
            'tahun_masehi'   => 'required|integer|min:2000|max:2100',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after:tanggal_mulai',
            'nominal_spp'    => 'required|numeric|min:1000',
        ]);

        $data['status'] = 'selesai'; // baru dibuat = belum aktif

        TahunAjaran::create($data);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$data['nama']} berhasil ditambahkan.");
    }

    public function edit(TahunAjaran $tahunAjaran)
    {
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, TahunAjaran $tahunAjaran)
    {
        $data = $request->validate([
            'nama'           => 'required|string|max:20|unique:tahun_ajaran,nama,' . $tahunAjaran->id,
            'tahun_hijriah'  => 'required|integer|min:1400|max:1600|unique:tahun_ajaran,tahun_hijriah,' . $tahunAjaran->id,
            'tahun_masehi'   => 'required|integer|min:2000|max:2100',
            'tanggal_mulai'  => 'required|date',
            'tanggal_selesai'=> 'required|date|after:tanggal_mulai',
            'nominal_spp'    => 'required|numeric|min:1000',
        ]);

        // Tidak boleh edit nominal_spp kalau sudah ada tagihan
        if ($tahunAjaran->sppTagihan()->exists() &&
            (float)$data['nominal_spp'] !== (float)$tahunAjaran->nominal_spp) {
            return back()->withErrors([
                'nominal_spp' => 'Nominal SPP tidak bisa diubah karena sudah ada tagihan yang dibuat.',
            ])->withInput();
        }

        $tahunAjaran->update($data);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$tahunAjaran->nama} berhasil diperbarui.");
    }

    /**
     * Aktifkan tahun ajaran ini, dan tutup yang lama.
     * Dijalankan dalam transaksi supaya atomik.
     */
    public function activate(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('info', 'Tahun ajaran ini sudah aktif.');
        }

        DB::transaction(function () use ($tahunAjaran) {
            // Tutup semua yang sedang aktif
            TahunAjaran::where('status', 'aktif')->update(['status' => 'selesai']);

            // Aktifkan yang baru
            $tahunAjaran->update(['status' => 'aktif']);

            SantriKelas::where('tahun_ajaran_id', $tahunAjaran->id)
                ->select('id', 'nis', 'kelas')
                ->chunkById(200, function ($records) {
                    foreach ($records as $record) {
                        Santri::where('nis', $record->nis)->update(['kelas' => $record->kelas]);
                    }
                });
        });

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$tahunAjaran->nama} sekarang aktif.");
    }

    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->isAktif()) {
            return back()->with('error', 'Tahun ajaran aktif tidak bisa dihapus.');
        }

        $hasRelatedData = $tahunAjaran->santriKelas()->exists()
            || $tahunAjaran->sppTagihan()->exists()
            || $tahunAjaran->sppPembayaran()->exists()
            || $tahunAjaran->absensi()->exists();

        if ($hasRelatedData) {
            return back()->with('error', 'Tahun ajaran tidak bisa dihapus karena sudah memiliki data kelas, SPP, atau absensi.');
        }

        $nama = $tahunAjaran->nama;
        $tahunAjaran->delete();

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran {$nama} berhasil dihapus.");
    }
}
