<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\SantriKelas;
use App\Models\TahunAjaran;
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

        $santri = Santri::create($data);
        $this->syncKelasTahunAktif($santri->nis, $santri->kelas);

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
        $this->syncKelasTahunAktif($santri->nis, $santri->kelas);

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
                $santri = Santri::updateOrCreate(
                    ['nis' => $nis],
                    ['nama' => $nama, 'kelas' => $kelas ?: null]
                );
                if ($kelas) {
                    $this->syncKelasTahunAktif($santri->nis, $kelas);
                }
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
        $daftarKelas   = Santri::daftarKelas();
        $semuaTahun    = TahunAjaran::orderByDesc('id')->get();
        $tahunAjaranId = $request->get('tahun_ajaran_id');
        $kelasFilter   = $request->get('kelas_asal');

        // Default ke tahun ajaran aktif
        $tahunAjaran = $tahunAjaranId
            ? $semuaTahun->firstWhere('id', $tahunAjaranId)
            : $semuaTahun->firstWhere('status', 'aktif') ?? $semuaTahun->first();

        $santri = null;
        if ($tahunAjaran && $kelasFilter) {
            // Ambil santri dari santri_kelas di tahun ajaran tersebut
            $santri = SantriKelas::with('santri')
                ->where('tahun_ajaran_id', $tahunAjaran->id)
                ->where('kelas', $kelasFilter)
                ->get()
                ->map->santri
                ->filter()
                ->sortBy('nama')
                ->values();
        }

        return view('admin.santri.kelola-kelas', compact(
            'kelasFilter', 'daftarKelas', 'santri', 'semuaTahun', 'tahunAjaran'
        ));
    }

    public function updateKelolaKelas(Request $request)
    {
        $request->validate([
            'tahun_ajaran_id'  => 'required|integer|exists:tahun_ajaran,id',
            'kelas_updates'    => 'required|array',
            'kelas_updates.*'  => 'required|string|max:50',
        ]);

        $tahunAjaran = TahunAjaran::findOrFail($request->tahun_ajaran_id);
        $isAktif     = $tahunAjaran->isAktif();
        $updated     = 0;

        foreach ($request->kelas_updates as $nis => $kelasBaru) {
            $kelasBaru = trim($kelasBaru);
            $santri    = Santri::find($nis);
            if (! $santri) continue;

            // Update atau buat record santri_kelas
            $santriKelas = SantriKelas::firstOrNew([
                'nis'             => $santri->nis,
                'tahun_ajaran_id' => $tahunAjaran->id,
            ]);

            if ($santriKelas->kelas === $kelasBaru) continue;

            $santriKelas->kelas       = $kelasBaru;
            $santriKelas->diubah_oleh = auth()->user()->name ?? 'Admin';
            $santriKelas->save();

            // Jika ini tahun ajaran aktif, sync shortcut santri.kelas juga
            if ($isAktif) {
                $santri->update(['kelas' => $kelasBaru]);
            }

            $updated++;
        }

        return redirect()->route('admin.santri.kelola-kelas', [
                'tahun_ajaran_id' => $tahunAjaran->id,
            ])
            ->with('success', "{$updated} data kelas santri berhasil diperbarui.");
    }

    /**
     * Kenaikan kelas massal ke tahun ajaran baru.
     */
    public function kenaikanKelas(Request $request)
    {
        $request->validate([
            'tahun_ajaran_baru_id'  => 'required|integer|exists:tahun_ajaran,id',
            'kenaikan'              => 'required|array',
            'kenaikan.*.nis'        => 'required|string|exists:santri,nis',
            'kenaikan.*.kelas_baru' => 'required|string|max:50',
        ]);

        $tahunBaru = TahunAjaran::findOrFail($request->tahun_ajaran_baru_id);
        $inserted  = 0;

        foreach ($request->kenaikan as $row) {
            SantriKelas::updateOrCreate(
                ['nis' => $row['nis'], 'tahun_ajaran_id' => $tahunBaru->id],
                ['kelas' => $row['kelas_baru'], 'diubah_oleh' => auth()->user()->name ?? 'Admin']
            );

            // Jika tahun baru adalah tahun aktif, sync shortcut
            if ($tahunBaru->isAktif()) {
                Santri::where('nis', $row['nis'])->update(['kelas' => $row['kelas_baru']]);
            }

            $inserted++;
        }

        return redirect()->route('admin.santri.kelola-kelas', ['tahun_ajaran_id' => $tahunBaru->id])
            ->with('success', "{$inserted} santri berhasil dinaikkan kelasnya ke {$tahunBaru->nama}.");
    }

    /**
     * Bulk update: ubah status, jenjang, gender, atau tanggal_masuk
     * untuk banyak santri sekaligus.
     *
     * Tambahkan method ini di dalam class SantriController,
     * setelah method destroy().
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'nis'           => 'required|array|min:1',
            'nis.*'         => 'required|string|exists:santri,nis',
            'status'        => 'nullable|in:aktif,lulus,mutasi,dikeluarkan,wafat',
            'jenjang'       => 'nullable|in:Reguler,Tahfidz',
            'gender'        => 'nullable|in:PA,PI',
            'tanggal_masuk' => 'nullable|date',
        ]);

        // Kumpulkan field yang benar-benar diisi (tidak kosong)
        $updates = array_filter([
            'status'        => $request->status,
            'jenjang'       => $request->jenjang,
            'gender'        => $request->gender,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        if (empty($updates)) {
            return redirect()->route('admin.santri.index')
                ->with('error', 'Tidak ada field yang diubah.');
        }

        $count = Santri::whereIn('nis', $request->nis)->update($updates);

        $fieldLabels = [
            'status'        => 'Status',
            'jenjang'       => 'Jenjang',
            'gender'        => 'Gender',
            'tanggal_masuk' => 'Tanggal Masuk',
        ];
        $changedFields = implode(', ', array_map(fn($k) => $fieldLabels[$k], array_keys($updates)));

        return redirect()->route('admin.santri.index')
            ->with('success', "{$count} santri berhasil diperbarui ({$changedFields}).");
    }

    private function syncKelasTahunAktif(string $nis, ?string $kelas): void
    {
        if (! $kelas) {
            return;
        }

        $tahunAjaran = TahunAjaran::getAktif();

        if (! $tahunAjaran) {
            return;
        }

        SantriKelas::updateOrCreate(
            ['nis' => $nis, 'tahun_ajaran_id' => $tahunAjaran->id],
            ['kelas' => $kelas, 'diubah_oleh' => auth()->user()->name ?? 'Admin']
        );
    }
}
