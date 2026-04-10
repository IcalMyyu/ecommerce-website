<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // Build base query with search filter
        $baseQuery = fn() => User::withCount('orders')
            ->withSum('orders', 'total_amount')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                });
            });

        // Separate queries per role
        $admins = $baseQuery()->where('role', 'admin')->orderBy('name')->get();
        $staffs = $baseQuery()->where('role', 'staff')->orderBy('name')->get();
        $users  = $baseQuery()->where('role', 'user')->orderBy('created_at', 'desc')->paginate(20);

        // Stats (always full count)
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'user'  => User::where('role', 'user')->count(),
        ];

        return view('admin.users.index', compact('admins', 'staffs', 'users', 'stats'));
    }
}
