<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalAbsen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalAbsenController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'aktif' => ['nullable', 'boolean'],
            'hari' => ['nullable', 'integer', 'min:1', 'max:7'],
        ]);

        $query = JadwalAbsen::query();

        if ($request->has('aktif')) {
            $query->where('aktif', $request->boolean('aktif'));
        }

        if ($request->filled('hari')) {
            $hari = (int) $request->input('hari');
            $query->where(function ($subQuery) use ($hari) {
                $subQuery->whereNull('hari')
                    ->orWhereJsonContains('hari', $hari);
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('jam_mulai')->get(),
        ]);
    }

    public function current(): JsonResponse
    {
        $now = now('Asia/Jakarta');
        $time = $now->format('H:i:s');
        $dayOfWeek = $now->dayOfWeekIso;

        $jadwal = JadwalAbsen::where('aktif', true)
            ->where('jam_mulai', '<=', $time)
            ->where('jam_selesai', '>=', $time)
            ->where(function ($query) use ($dayOfWeek) {
                $query->whereNull('hari')
                    ->orWhereJsonContains('hari', $dayOfWeek);
            })
            ->orderBy('jam_mulai')
            ->first();

        return response()->json([
            'success' => true,
            'data' => $jadwal,
            'server_time' => $now->toDateTimeString(),
        ]);
    }
}
