<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * Contoh pemakaian di routes/web.php:
     *   ->middleware('role:superadmin')
     *   ->middleware('role:superadmin,guru')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Belum login
        if (! $user) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return ApiResponse::error('Unauthenticated.', 401);
            }

            return redirect()->route('login');
        }

        // Cek apakah role user ada di daftar role yang diizinkan
        if (! in_array($user->role, $roles, strict: true)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return ApiResponse::error('Akses ditolak. Anda tidak memiliki izin.', 403);
            }

            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
