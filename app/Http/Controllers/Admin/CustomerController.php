<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $customers = $query->paginate(15);

        $stats = [
            'total'       => User::where('role', 'user')->count(),
            'total_spend' => Order::whereHas('user', fn($q) => $q->where('role', 'user'))
                                  ->whereNotIn('status', ['belum-bayar', 'dibatalkan'])
                                  ->sum('total_amount'),
            'new_this_month' => User::where('role', 'user')
                                    ->whereMonth('created_at', now()->month)
                                    ->whereYear('created_at', now()->year)
                                    ->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show($id)
    {
        $customer = User::where('role', 'user')
            ->with(['addresses', 'orders.items.product'])
            ->findOrFail($id);

        $orderStats = [
            'total'    => $customer->orders->count(),
            'selesai'  => $customer->orders->where('status', 'selesai')->count(),
            'spend'    => $customer->orders->whereNotIn('status', ['belum-bayar', 'dibatalkan'])->sum('total_amount'),
        ];

        return view('admin.customers.show', compact('customer', 'orderStats'));
    }

    public function destroy($id)
    {
        $customer = User::where('role', 'user')->findOrFail($id);
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Akun customer berhasil dihapus!');
    }
}
