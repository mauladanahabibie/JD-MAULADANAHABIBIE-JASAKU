<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCustomerPanelAccess
{
 public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // kalau belum login, biarkan lewat (biar bisa akses login page)
        if (!$user) {
            return $next($request);
        }
        if ($user->status === 'admin' || $user->status === 'customer') {
            return $next($request);
        }
        if ($user->status !== 'customer') {
            abort(403, 'Unauthorized: hanya customer yang bisa masuk panel ini.');
        }

        return $next($request);
    }
}
