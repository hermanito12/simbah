<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        if (in_array($user->role, ['pengurus', 'nasabah'])) {
            if (!$user->unit || $user->unit->status !== 'aktif') {
                abort(403, 'Unit Anda sedang tidak aktif.');
            }

            if ($user->role === 'nasabah' && (!$user->nasabah || $user->nasabah->status !== 'aktif')) {
                abort(403, 'Akun nasabah Anda sedang tidak aktif.');
            }
        }

        return $next($request);
    }
}
