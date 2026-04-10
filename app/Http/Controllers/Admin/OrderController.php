<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items'])->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->status) {
            if ($request->status === 'menunggu-konfirmasi') {
                $query->whereIn('status', ['menunggu-konfirmasi', 'dikonfirmasi']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // Search by order ID, user name, or email
        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Sort
        if ($request->sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($request->sort === 'highest') {
            $query->orderBy('total_amount', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $orders = $query->paginate(15);

        // Count per status (unfiltered)
        $counts = [
            'all'                  => Order::count(),
            'belum-bayar'          => Order::where('status', 'belum-bayar')->count(),
            'menunggu-konfirmasi'  => Order::whereIn('status', ['menunggu-konfirmasi', 'dikonfirmasi'])->count(),
            'dikemas'              => Order::where('status', 'dikemas')->count(),
            'dikirim'              => Order::where('status', 'dikirim')->count(),
            'selesai'              => Order::where('status', 'selesai')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'counts'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'address', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $user  = auth('admin')->user();

        // Admin is monitoring only - they should not be updating statuses
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin hanya memiliki akses monitoring.');
        }

        // Logic check: cannot update if status is 'belum-bayar' and no proof exists
        if ($order->status === 'belum-bayar' && !$order->payment_proof) {
            return back()->with('error', 'Status tidak bisa diubah karena belum ada bukti transfer yang diunggah.');
        }

        $request->validate([
            'status'          => 'required|string',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $order->update([
            'status'          => $request->status,
            'tracking_number' => $request->tracking_number,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
