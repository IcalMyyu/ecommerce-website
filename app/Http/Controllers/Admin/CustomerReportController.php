<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerReportController extends Controller
{
    /**
     * Display a listing of reports based on role.
     */
    public function index()
    {
        $user = Auth::guard('admin')->user();
        
        if ($user->role === 'admin') {
            // Admin only sees forwarded reports or can see everything if we want
            // User requested: Admin sees "Laporan Customer (Terusan)"
            $reports = CustomerReport::where('status', 'forwarded')
                ->orderBy('updated_at', 'desc')
                ->paginate(15);
        } else {
            // Staff sees all "pending" or "resolved" ones they managed
            $reports = CustomerReport::whereIn('status', ['pending', 'resolved'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('admin.reports.customer', compact('reports'));
    }

    /**
     * Forward a report to admin.
     */
    public function forward($id)
    {
        $report = CustomerReport::findOrFail($id);
        
        if (Auth::guard('admin')->user()->role !== 'staff') {
            return back()->with('error', 'Only staff can forward reports.');
        }

        $report->update(['status' => 'forwarded']);

        return back()->with('success', 'Report has been forwarded to Admin.');
    }

    /**
     * Mark a report as resolved.
     */
    public function resolve($id)
    {
        $report = CustomerReport::findOrFail($id);
        $report->update(['status' => 'resolved']);

        return back()->with('success', 'Report marked as resolved.');
    }

    /**
     * Delete a report.
     */
    public function destroy($id)
    {
        // Only admin can delete reports
        if (Auth::guard('admin')->user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $report = CustomerReport::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted successfully.');
    }
}
