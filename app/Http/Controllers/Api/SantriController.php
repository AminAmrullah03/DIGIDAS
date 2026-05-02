<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kelas' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'in:PA,PI'],
            'jenjang' => ['nullable', 'in:Reguler,Tahfidz'],
            'status' => ['nullable', 'in:aktif,lulus,mutasi,dikeluarkan,wafat'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $query = Santri::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($subQuery) use ($search) {
                $subQuery->where('nis', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        foreach (['kelas', 'gender', 'jenjang', 'status'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $request->input($field));
            }
        }

        $santri = $query->orderBy('nama')
            ->paginate((int) $request->input('per_page', 20))
            ->withQueryString();

        return ApiResponse::success($santri->items(), 'Data santri berhasil diambil.', 200, [
            'pagination' => [
                'current_page' => $santri->currentPage(),
                'last_page' => $santri->lastPage(),
                'per_page' => $santri->perPage(),
                'total' => $santri->total(),
            ],
        ]);
    }

    public function show(Santri $santri): JsonResponse
    {
        $santri->load([
            'absensi' => fn ($query) => $query->latest('waktu')->limit(10),
            'izin' => fn ($query) => $query->latest('waktu_keluar')->limit(10),
            'sppTagihan' => fn ($query) => $query->latest('tahun')->latest('bulan')->limit(12),
        ]);

        return ApiResponse::success($santri, 'Detail santri berhasil diambil.');
    }

    public function kelas(): JsonResponse
    {
        return ApiResponse::success([
            'daftar_kelas' => Santri::daftarKelas(),
            'existing' => Santri::select('kelas')
                ->whereNotNull('kelas')
                ->distinct()
                ->orderBy('kelas')
                ->pluck('kelas'),
        ], 'Data kelas berhasil diambil.');
    }
}
