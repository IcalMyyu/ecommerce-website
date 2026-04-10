<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin
     */
    public function create()
    {
        // Jika sudah login sebagai admin, langsung ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    /**
     * Proses login admin menggunakan guard 'admin' (terpisah dari user)
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Gunakan guard 'admin' — session sepenuhnya terpisah dari user
        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::guard('admin')->user();

            // Pastikan yang login memang role admin atau staff
            if (in_array($user->role, ['admin', 'staff'])) {
                $request->session()->regenerate();
                return redirect()->route('admin.dashboard');
            }

            // Bukan admin/staff → logout dari guard admin
            Auth::guard('admin')->logout();
            return back()->withErrors([
                'username' => 'Akun ini tidak memiliki akses ke panel administrator.',
            ])->onlyInput('username');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Logout admin (hanya logout dari guard 'admin', session user tidak terpengaruh)
     */
    public function destroy(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
