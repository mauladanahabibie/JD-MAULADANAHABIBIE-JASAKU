<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureMitraPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        $isAuthorized = $user->status === 'admin' || ($user->admin_verified !== null && $user->status === 'mitra');

        if (!$isAuthorized) {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            abort(Response::HTTP_FORBIDDEN, 'Unauthorized: hanya mitra yang sudah diverifikasi admin yang bisa masuk dashboard ini.');
        }

        return $next($request);
    }
}
