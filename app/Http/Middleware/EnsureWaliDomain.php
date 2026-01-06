<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureWaliDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $allowed = (string) env('WALI_DOMAIN', '');

        if ($allowed !== '') {
            $allowedHosts = array_values(array_filter(array_map('trim', explode(',', $allowed))));
            $host = $request->getHost();

            if (!in_array($host, $allowedHosts, true)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
