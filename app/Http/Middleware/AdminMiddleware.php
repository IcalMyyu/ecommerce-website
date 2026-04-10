<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Guard 'admin' sepenuhnya terpisah dari guard 'web' (user biasa).
     * Jika belum login sebagai admin/staff → redirect ke admin login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek guard admin, bukan web
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Pastikan role benar (double check)
        if (!in_array(auth('admin')->user()->role, ['admin', 'staff'])) {
            auth('admin')->logout();
            return redirect()->route('admin.login')->with('error', 'Akun tidak memiliki akses admin.');
        }

        return $next($request);
    }
}
