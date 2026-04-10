<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminPdfController extends Controller
{
    /**
     * Export Sales Report as PDF
     */
    public function salesReportPdf(Request $request)
    {
        // Must be admin
        if (Auth::guard('admin')->user()->role !== 'admin') {
            abort(403);
        }

        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->subDays(30)->startOfDay();
        $endDate   = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $totalRevenue = Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_amount');

        $completedOrdersCount = Order::whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $topProducts = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) use ($startDate, $endDate) {
                $q->whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
                  ->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->with('product')
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        $recentOrders = Order::with('user')
            ->whereIn('status', ['dikonfirmasi', 'dikemas', 'dikirim', 'selesai'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.sales_report', compact(
            'totalRevenue', 'completedOrdersCount', 'topProducts', 
            'recentOrders', 'startDate', 'endDate'
        ));

        return $pdf->download('Laporan_Penjualan_' . $startDate->format('Ymd') . '_' . $endDate->format('Ymd') . '.pdf');
    }

    /**
     * Export Order Receipt as PDF
     */
    public function orderReceiptPdf($id)
    {
        $order = Order::with(['user', 'address', 'items.product'])->findOrFail($id);

        // Security check: only admin/staff or the owner can download
        $isAdmin = Auth::guard('admin')->check();
        $isOwner = Auth::check() && Auth::id() === $order->user_id;

        if (!$isAdmin && !$isOwner) {
            abort(403);
        }

        $pdf = Pdf::loadView('admin.reports.pdf.order_receipt', compact('order'));

        return $pdf->download('Struk_Transaksi_' . str_replace('/', '_', $order->id) . '.pdf');
    }
}
