<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\RiwayatKelas;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $query = Santri::query();
        if ($request->filled('search'))  $query->where(fn($q) => $q->where('nama','like','%'.$request->search.'%')->orWhere('nis','like','%'.$request->search.'%'));
        if ($request->filled('kelas'))   $query->where('kelas', $request->kelas);
        if ($request->filled('gender'))  $query->where('gender', $request->gender);
        if ($request->filled('jenjang')) $query->where('jenjang', $request->jenjang);
        if ($request->filled('status'))  $query->where('status', $request->status);
        $santri     = $query->orderBy('nama')->paginate(20)->withQueryString();
        $totalAktif = Santri::where('status','aktif')->count();
        $totalAll   = Santri::count();
        $daftarKelas = Santri::daftarKelas();
        return view('admin.santri.index', compact('santri','totalAktif','totalAll','daftarKelas'));
    }

    public function create()
    {
        $daftarKelas = Santri::daftarKelas();
        return view('admin.santri.create', compact('daftarKelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis'           => ['required','string','max:50','unique:santri,nis'],
            'nama'          => ['required','string','max:100'],
            'kelas'         => ['required','string'],
            'gender'        => ['required','in:PA,PI'],
            'jenjang'       => ['required','in:Reguler,Tahfidz'],
            'status'        => ['required','in:aktif,lulus,mutasi,dikeluarkan,wafat'],
            'tanggal_masuk' => ['nullable','date'],
            'keterangan'    => ['nullable','string'],
        ], ['nis.unique' => 'NIS sudah terdaftar.']);

        $santri = Santri::create($request->only(['nis','nama','kelas','gender','jenjang','status','tanggal_masuk','keterangan']));
        RiwayatKelas::create(['nis'=>$santri->nis,'kelas_lama'=>null,'kelas_baru'=>$santri->kelas,'diubah_oleh'=>auth()->user()->name,'catatan'=>'Pendaftaran awal']);
        return redirect()->route('admin.santri.index')->with('success', "Santri {$santri->nama} berhasil ditambahkan.");
    }

    public function show(Santri $santri)
    {
        $santri->load(['riwayatKelas','absensi'=>fn($q)=>$q->latest()->limit(10),'izin'=>fn($q)=>$q->latest()->limit(5)]);
        return view('admin.santri.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        $daftarKelas = Santri::daftarKelas();
        return view('admin.santri.edit', compact('santri','daftarKelas'));
    }

    public function update(Request $request, Santri $santri)
    {
        $request->validate([
            'nama'          => ['required','string','max:100'],
            'kelas'         => ['required','string'],
            'gender'        => ['required','in:PA,PI'],
            'jenjang'       => ['required','in:Reguler,Tahfidz'],
            'status'        => ['required','in:aktif,lulus,mutasi,dikeluarkan,wafat'],
            'tanggal_masuk' => ['nullable','date'],
            'keterangan'    => ['nullable','string'],
        ]);
        $kelasLama = $santri->kelas;
        $santri->update($request->only(['nama','kelas','gender','jenjang','status','tanggal_masuk','keterangan']));
        if ($kelasLama !== $request->kelas) {
            RiwayatKelas::create(['nis'=>$santri->nis,'kelas_lama'=>$kelasLama,'kelas_baru'=>$request->kelas,'diubah_oleh'=>auth()->user()->name,'catatan'=>$request->catatan_kelas]);
        }
        return redirect()->route('admin.santri.index')->with('success', "Data {$santri->nama} berhasil diperbarui.");
    }

    public function destroy(Santri $santri)
    {
        $adaData = $santri->absensi()->exists() || $santri->sppTagihan()->exists() || $santri->izin()->exists();
        if ($adaData) return redirect()->route('admin.santri.index')->with('error', "Santri {$santri->nama} tidak dapat dihapus karena memiliki data terkait. Ubah statusnya saja.");
        $nama = $santri->nama;
        $santri->delete();
        return redirect()->route('admin.santri.index')->with('success', "{$nama} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate(['file'=>['required','file','mimes:csv,txt','max:2048']]);
        $handle = fopen($request->file('file')->getPathname(), 'r');
        $isHeader = true; $imported = 0; $skipped = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            if ($isHeader) { $isHeader = false; continue; }
            $nis   = trim($row[0] ?? '');
            $nama  = trim($row[1] ?? '');
            $kelas = trim(preg_replace('/\s+/', ' ', $row[2] ?? ''));
            if (!$nis || !$nama || !$kelas) { $skipped++; continue; }
            $gender  = str_starts_with(strtoupper($kelas), 'PI') ? 'PI' : 'PA';
            $jenjang = str_contains(strtoupper($kelas), 'TAHFIDZ') ? 'Tahfidz' : 'Reguler';
            $exists  = Santri::where('nis', $nis)->exists();
            Santri::updateOrCreate(['nis'=>$nis],['nama'=>$nama,'kelas'=>$kelas,'gender'=>$gender,'jenjang'=>$jenjang,'status'=>'aktif']);
            if (!$exists) RiwayatKelas::create(['nis'=>$nis,'kelas_lama'=>null,'kelas_baru'=>$kelas,'diubah_oleh'=>auth()->user()->name,'catatan'=>'Import CSV']);
            $imported++;
        }
        fclose($handle);
        return redirect()->route('admin.santri.index')->with('success', "Import selesai: {$imported} santri berhasil" . ($skipped ? ", {$skipped} dilewati" : ""));
    }
}