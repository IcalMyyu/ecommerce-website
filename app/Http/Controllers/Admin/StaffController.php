<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'staff')
            ->withCount('orders')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $staffList = $query->paginate(15);
        $totalStaff = User::where('role', 'staff')->count();

        return view('admin.staff.index', compact('staffList', 'totalStaff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => str_replace(' ', '_', strtolower($request->name)) . '_' . rand(100, 999),
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'staff',
        ]);

        return back()->with('success', 'Akun petugas berhasil dibuat!');
    }

    public function update(Request $request, $id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        return back()->with('success', 'Akun petugas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        $staff->delete();

        return back()->with('success', 'Akun petugas berhasil dihapus!');
    }
}
