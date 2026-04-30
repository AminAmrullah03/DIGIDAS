<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\RiwayatKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($sub) use ($q) {
                $sub->where('nis', 'like', "%{$q}%")
                    ->orWhere('nama', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kelas'))   $query->where('kelas',   $request->kelas);
        if ($request->filled('gender'))  $query->where('gender',  $request->gender);
        if ($request->filled('jenjang')) $query->where('jenjang', $request->jenjang);
        if ($request->filled('status'))  $query->where('status',  $request->status);

        $santri     = $query->orderBy('nama')->paginate(20)->withQueryString();
        $totalAll   = Santri::count();
        $totalAktif = Santri::where('status', 'aktif')->count();
        $daftarKelas = Santri::daftarKelas();

        return view('admin.santri.index', compact('santri', 'totalAll', 'totalAktif', 'daftarKelas'));
    }

    public function create()
    {
        $daftarKelas = Santri::daftarKelas();
        return view('admin.santri.create', compact('daftarKelas'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nis'           => 'required|string|max:50|unique:santri,nis',
            'nama'          => 'required|string|max:100',
            'kelas'         => 'required|string|max:50',
            'gender'        => 'required|in:PA,PI',
            'jenjang'       => 'required|in:Reguler,Tahfidz',
            'status'        => 'required|in:aktif,lulus,mutasi,dikeluarkan,wafat',
            'tanggal_masuk' => 'nullable|date',
            'keterangan'    => 'nullable|string',
        ]);

        Santri::create($data);

        return redirect()->route('admin.santri.index')
            ->with('success', 'Santri ' . $data['nama'] . ' berhasil ditambahkan.');
    }

    public function show(Santri $santri)
    {
        $santri->load(['absensi', 'izin', 'sppTagihan', 'riwayatKelas']);
        return view('admin.santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $daftarKelas = Santri::daftarKelas();
        return view('admin.santri.edit', compact('santri', 'daftarKelas'));
    }

    public function update(Request $request, Santri $santri)
    {
        $data = $request->validate([
            'nis'           => 'required|string|max:50|unique:santri,nis,' . $santri->nis . ',nis',
            'nama'          => 'required|string|max:100',
            'kelas'         => 'required|string|max:50',
            'gender'        => 'required|in:PA,PI',
            'jenjang'       => 'required|in:Reguler,Tahfidz',
            'status'        => 'required|in:aktif,lulus,mutasi,dikeluarkan,wafat',
            'tanggal_masuk' => 'nullable|date',
            'keterangan'    => 'nullable|string',
        ]);

        // Catat riwayat kelas jika berubah
        if ($santri->kelas !== $data['kelas']) {
            RiwayatKelas::create([
                'nis'        => $santri->nis,
                'kelas_lama' => $santri->kelas,
                'kelas_baru' => $data['kelas'],
                'diubah_oleh'=> auth()->user()->name ?? 'Admin',
            ]);
        }

        $santri->update($data);

        return redirect()->route('admin.santri.index')
            ->with('success', 'Data santri ' . $santri->nama . ' berhasil diperbarui.');
    }

    public function destroy(Santri $santri)
    {
        $nama = $santri->nama;
        $santri->delete();

        return redirect()->route('admin.santri.index')
            ->with('success', 'Santri ' . $nama . ' berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file  = $request->file('file');
        $rows  = array_map('str_getcsv', file($file->getRealPath()));
        $count = 0;
        $errors = [];

        foreach ($rows as $i => $row) {
            // Skip header row jika ada
            if ($i === 0 && !is_numeric($row[0] ?? '')) continue;

            $nis  = trim($row[0] ?? '');
            $nama = trim($row[1] ?? '');
            $kelas = trim($row[2] ?? '');

            if (!$nis || !$nama) continue;

            try {
                Santri::updateOrCreate(
                    ['nis' => $nis],
                    ['nama' => $nama, 'kelas' => $kelas ?: null]
                );
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Baris " . ($i + 1) . ": {$e->getMessage()}";
            }
        }

        $msg = "{$count} data santri berhasil diimport.";
        if ($errors) {
            $msg .= " " . count($errors) . " baris gagal.";
        }

        return redirect()->route('admin.santri.index')->with('success', $msg);
    }

    public function kelolaKelas(Request $request)
    {
        $kelasFilter = $request->get('kelas_asal');
        $daftarKelas = Santri::daftarKelas();

        $santri = null;
        if ($kelasFilter) {
            $santri = Santri::where('status', 'aktif')
                ->where('kelas', $kelasFilter)
                ->orderBy('nama')
                ->get();
        }

        return view('admin.santri.kelola-kelas', compact('kelasFilter', 'daftarKelas', 'santri'));
    }

    public function updateKelolaKelas(Request $request)
    {
        $request->validate([
            'kelas_updates'   => 'required|array',
            'kelas_updates.*' => 'required|string|max:50',
        ]);

        $updated = 0;
        foreach ($request->kelas_updates as $nis => $kelasBaruData) {
            $santri = Santri::find($nis);
            if (!$santri) continue;

            $kelasBaru = trim($kelasBaruData);
            if ($santri->kelas === $kelasBaru) continue;

            RiwayatKelas::create([
                'nis'         => $santri->nis,
                'kelas_lama'  => $santri->kelas,
                'kelas_baru'  => $kelasBaru,
                'diubah_oleh' => auth()->user()->name ?? 'Admin',
                'catatan'     => 'Kelola kelas massal',
            ]);

            $santri->update(['kelas' => $kelasBaru]);
            $updated++;
        }

        return redirect()->route('admin.santri.kelola-kelas')
            ->with('success', "{$updated} data kelas santri berhasil diperbarui.");
    }
}