<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter by date range (default last 30 days)
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        // 1. Total Revenue from 'Paid' orders
        $totalRevenue = Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        // 2. Total Orders (all vs Paid)
        $totalOrders = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $completedOrders = Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // 3. Revenue Trend (Daily)
        $revenueTrend = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 4. Top Selling Products
        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return view('admin.reports.sales', compact(
            'totalRevenue', 'totalOrders', 'completedOrders', 
            'revenueTrend', 'topProducts', 'startDate', 'endDate'
        ));
    }
}
