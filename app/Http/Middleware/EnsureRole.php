<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Periksa apakah role user sesuai dengan yang diizinkan.
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {

        // pastikan user login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        // cek role
        if (!in_array($request->user()->role, $roles)) {

            abort(
                403,
                'Akses ditolak. Role Anda tidak memiliki izin.'
            );
        }

        return $next($request);
    }
}