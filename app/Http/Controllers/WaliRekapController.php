<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WaliRekapController extends Controller
{
    protected function normalizeTanggal(?string $tanggal): string
    {
        $today = now('Asia/Jakarta')->toDateString();
        $min = now('Asia/Jakarta')->subDays(7)->toDateString();

        if (!$tanggal) {
            return $today;
        }

        try {
            $parsed = Carbon::parse($tanggal)->toDateString();
        } catch (\Throwable $e) {
            return $today;
        }

        if ($parsed > $today) {
            return $today;
        }

        if ($parsed < $min) {
            return $min;
        }

        return $parsed;
    }

    protected function buildRows(string $tanggal, ?string $search)
    {
        $search = is_string($search) ? trim($search) : null;
        $search = $search !== '' ? mb_substr($search, 0, 80) : null;

        return Absensi::query()
            ->with(['santri', 'jadwal'])
            ->whereDate('waktu', $tanggal)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('nis', 'like', "%{$search}%")
                        ->orWhereHas('santri', function ($qs) use ($search) {
                            $qs->where('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('waktu')
            ->get();
    }

    public function index(Request $request)
    {
        $tanggal = $this->normalizeTanggal($request->input('tanggal'));
        $search = $request->input('search');

        $rows = $this->buildRows($tanggal, $search);

        return view('wali.rekap', [
            'tanggal' => $tanggal,
            'minTanggal' => now('Asia/Jakarta')->subDays(7)->toDateString(),
            'maxTanggal' => now('Asia/Jakarta')->toDateString(),
            'search' => $search,
            'rows' => $rows,
        ]);
    }

    public function data(Request $request)
    {
        $tanggal = $this->normalizeTanggal($request->input('tanggal'));
        $search = $request->input('search');

        $rows = $this->buildRows($tanggal, $search);

        return view('wali.partials.rekap-table', [
            'tanggal' => $tanggal,
            'rows' => $rows,
        ]);
    }
}
