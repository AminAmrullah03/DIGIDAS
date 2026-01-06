<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalAbsen;

class JadwalAbsenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // atau middleware admin khusus
    }

    public function index()
    {
        $jadwals = JadwalAbsen::orderBy('jam_mulai')->get();
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:120',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after_or_equal:jam_mulai',
            'hari' => 'nullable|array',
            'hari.*' => 'integer|min:1|max:7',
            'kode' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'aktif' => 'sometimes|boolean',
        ]);

        $data['hari'] = ($request->filled('hari') && is_array($request->hari) && count($request->hari) > 0)
            ? array_map('intval', $request->hari)
            : null;
        $data['aktif'] = $request->boolean('aktif');

        // Validasi overlap: cari jadwal aktif yang overlap
        $overlap = false;
        if ($data['aktif']) {
            $overlap = JadwalAbsen::where('aktif', true)
                ->where(function($q) use($data) {
                    $q->whereBetween('jam_mulai', [$data['jam_mulai'], $data['jam_selesai']])
                      ->orWhereBetween('jam_selesai', [$data['jam_mulai'], $data['jam_selesai']])
                      ->orWhere(function($q2) use($data) {
                          $q2->where('jam_mulai', '<=', $data['jam_mulai'])
                             ->where('jam_selesai', '>=', $data['jam_selesai']);
                      });
                })
                ->where(function($q) use ($data) {
                    if (empty($data['hari'])) {
                        return;
                    }
                    $q->whereNull('hari');
                    foreach ($data['hari'] as $d) {
                        $q->orWhereJsonContains('hari', $d);
                    }
                })
                ->exists();
        }

        if ($overlap) {
            return back()->withInput()->withErrors(['overlap' => 'Jadwal tumpang tindih dengan jadwal aktif lain.']);
        }

        JadwalAbsen::create($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function edit(JadwalAbsen $jadwalAbsen)
    {
        return view('admin.jadwal.edit', ['jadwal' => $jadwalAbsen]);
    }

    public function update(Request $request, JadwalAbsen $jadwalAbsen)
    {
        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:120',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after_or_equal:jam_mulai',
            'hari' => 'nullable|array',
            'hari.*' => 'integer|min:1|max:7',
            'kode' => 'nullable|string|max:50',
            'keterangan' => 'nullable|string',
            'aktif' => 'sometimes|boolean',
        ]);

        $data['hari'] = ($request->filled('hari') && is_array($request->hari) && count($request->hari) > 0)
            ? array_map('intval', $request->hari)
            : null;
        $data['aktif'] = $request->boolean('aktif');

        // Validasi overlap eksklusi sendiri
        $overlap = false;
        if ($data['aktif']) {
            $overlap = JadwalAbsen::where('id','<>',$jadwalAbsen->id)
                ->where('aktif', true)
                ->where(function($q) use($data) {
                    $q->whereBetween('jam_mulai', [$data['jam_mulai'], $data['jam_selesai']])
                      ->orWhereBetween('jam_selesai', [$data['jam_mulai'], $data['jam_selesai']])
                      ->orWhere(function($q2) use($data) {
                          $q2->where('jam_mulai', '<=', $data['jam_mulai'])
                             ->where('jam_selesai', '>=', $data['jam_selesai']);
                      });
                })
                ->where(function($q) use ($data) {
                    if (empty($data['hari'])) {
                        return;
                    }
                    $q->whereNull('hari');
                    foreach ($data['hari'] as $d) {
                        $q->orWhereJsonContains('hari', $d);
                    }
                })
                ->exists();
        }

        if ($overlap) {
            return back()->withInput()->withErrors(['overlap' => 'Jadwal tumpang tindih dengan jadwal aktif lain.']);
        }

        $jadwalAbsen->update($data);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(JadwalAbsen $jadwalAbsen)
    {
        $jadwalAbsen->delete();
        return redirect()->route('jadwal.index')->with('success','Jadwal dihapus.');
    }

    // toggle aktif via AJAX
    public function toggleAktif(Request $request, JadwalAbsen $jadwalAbsen)
    {
        $jadwalAbsen->aktif = !$jadwalAbsen->aktif;
        $jadwalAbsen->save();
        return response()->json(['ok' => true, 'aktif' => $jadwalAbsen->aktif]);
    }
}
