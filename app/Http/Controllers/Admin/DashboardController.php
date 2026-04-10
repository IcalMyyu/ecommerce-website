<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ── Stats ─────────────────────────────────────────────
        $totalRevenue = Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])->sum('total_amount');
        $stats = [
            'total_revenue' => $totalRevenue,
            'total_orders'  => Order::count(),
        ];

        // ── Data Chart: 7 hari terakhir (harian) ──────────────
        $chartLabels = [];
        $revenueData = [];
        $orderData   = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i);

            $chartLabels[] = $day->format('d M');

            $revenueData[] = (float) Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
                ->whereDate('created_at', $day->toDateString())
                ->sum('total_amount');

            $orderData[] = Order::whereDate('created_at', $day->toDateString())->count();
        }

        // ── Pesanan terbaru ────────────────────────────────────
        $recentOrders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 'recentOrders',
            'chartLabels', 'revenueData', 'orderData'
        ));
    }
}
