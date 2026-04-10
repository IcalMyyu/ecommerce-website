@extends('layouts.admin')
@php $page_title = 'Dashboard'; @endphp

@section('content')
<style>
    /* ── Stat Cards ──────────────────────────── */
    .stat-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
    }
    .stat-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 80px; height: 80px;
        border-radius: 0 18px 0 100%;
        opacity: 0.07;
    }
    .stat-card.revenue::after { background: #3b5d50; }
    .stat-card.orders::after  { background: #f9bf29; }
    .stat-icon {
        width: 44px; height: 44px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .stat-icon svg { width: 22px; height: 22px; }
    .icon-green  { background: #f0fdf4; color: #16a34a; }
    .icon-yellow { background: #fffbeb; color: #d97706; }
    .stat-label { font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 6px; }
    .stat-value { font-size: 1.6rem; font-weight: 800; color: #1e293b; letter-spacing: -0.02em; }
    .stat-sub   { font-size: 0.75rem; color: #94a3b8; margin-top: 4px; }

    /* ── Chart Card ──────────────────────────── */
    .chart-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }
    .chart-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .chart-title  { font-size: 0.95rem; font-weight: 800; color: #1e293b; }
    .chart-period { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }
    .chart-wrap   { position: relative; height: 180px; }

    /* ── Recent Orders Table ─────────────────── */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .section-title { font-size: 1.1rem; font-weight: 800; color: #1e293b; }
    .link-all { font-size: 0.8rem; font-weight: 700; color: #3b5d50; text-decoration: none; display:flex;align-items:center;gap:4px; }
    .link-all:hover { text-decoration: underline; }

    .table-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .orders-table { width: 100%; border-collapse: collapse; }
    .orders-table thead tr { background: #f8fafc; border-bottom: 2px solid #f1f5f9; }
    .orders-table th {
        padding: 13px 20px;
        font-size: 0.72rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: left;
    }
    .orders-table td {
        padding: 15px 20px;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr:hover td { background: #f8fafc; }

    .order-id { font-family: monospace; font-size: 0.78rem; font-weight: 700; color: #3b5d50; }
    .customer-info .name  { font-weight: 700; color: #1e293b; font-size: 0.85rem; }
    .customer-info .email { font-size: 0.75rem; color: #94a3b8; }
    .amount { font-weight: 700; color: #1e293b; }
    .date-text { font-size: 0.78rem; color: #94a3b8; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .s-belum-bayar          { background: #fef2f2; color: #dc2626; }
    .s-belum-bayar .badge-dot { background: #dc2626; }
    .s-menunggu-konfirmasi, .s-dikonfirmasi { background: #faf5ff; color: #7c3aed; }
    .s-menunggu-konfirmasi .badge-dot, .s-dikonfirmasi .badge-dot { background: #7c3aed; }
    .s-dikemas              { background: #eff6ff; color: #2563eb; }
    .s-dikemas .badge-dot   { background: #2563eb; }
    .s-dikirim              { background: #fffbeb; color: #d97706; }
    .s-dikirim .badge-dot   { background: #d97706; }
    .s-selesai              { background: #f0fdf4; color: #16a34a; }
    .s-selesai .badge-dot   { background: #16a34a; }
    .s-dibatalkan           { background: #f8fafc; color: #64748b; }
    .s-dibatalkan .badge-dot { background: #94a3b8; }
</style>

{{-- ── Stat Cards ─────────────────────────────────── --}}
<div class="stat-row">
    <div class="stat-card revenue">
        <div class="stat-icon icon-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <p class="stat-label">Total Pendapatan</p>
        <p class="stat-value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
        <p class="stat-sub">Dari pesanan yang sudah diproses</p>
    </div>
    <div class="stat-card orders">
        <div class="stat-icon icon-yellow">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <p class="stat-label">Total Order</p>
        <p class="stat-value">{{ number_format($stats['total_orders']) }}</p>
        <p class="stat-sub">Semua status pesanan</p>
    </div>
</div>

{{-- ── Charts ──────────────────────────────────────── --}}
<div class="chart-grid">
    {{-- Grafik Pendapatan --}}
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <p class="chart-title">Grafik Pendapatan</p>
                <p class="chart-period">7 Hari Terakhir</p>
            </div>
        </div>
        <div class="chart-wrap">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Grafik Order --}}
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <p class="chart-title">Grafik Pesanan</p>
                <p class="chart-period">7 Hari Terakhir</p>
            </div>
        </div>
        <div class="chart-wrap">
            <canvas id="orderChart"></canvas>
        </div>
    </div>
</div>

{{-- ── Recent Orders ───────────────────────────────── --}}
<div class="section-header">
    <p class="section-title">Pesanan Terbaru</p>
    <a href="{{ route('admin.orders.index') }}" class="link-all">
        Lihat Semua
        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
        </svg>
    </a>
</div>

<div class="table-card">
    <div style="overflow-x:auto;">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Jumlah Item</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td><span class="order-id">{{ $order->id }}</span></td>
                        <td>
                            <div class="customer-info">
                                <p class="name">{{ $order->user->name ?? 'Guest' }}</p>
                                <p class="email">{{ $order->user->email ?? '-' }}</p>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:700;">{{ $order->items->count() }}</span>
                            <span style="color:#94a3b8;font-size:0.8rem;"> produk</span>
                        </td>
                        <td><span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></td>
                        <td><span class="date-text">{{ $order->created_at->format('d M Y') }}</span></td>
                        <td>
                            <span class="status-badge s-{{ $order->status }}">
                                <span class="badge-dot"></span>
                                {{ str_replace('-', ' ', ucfirst($order->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:48px;color:#94a3b8;font-style:italic;">
                            Belum ada pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js via CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const labels   = @json($chartLabels);
    const revenue  = @json($revenueData);
    const orders   = @json($orderData);

    const gradientRevenue = (ctx) => {
        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 180);
        g.addColorStop(0, 'rgba(59,93,80,0.25)');
        g.addColorStop(1, 'rgba(59,93,80,0)');
        return g;
    };
    const gradientOrders = (ctx) => {
        const g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 180);
        g.addColorStop(0, 'rgba(249,191,41,0.3)');
        g.addColorStop(1, 'rgba(249,191,41,0)');
        return g;
    };

    const chartDefaults = {
        tension: 0.4,
        fill: true,
        pointRadius: 4,
        pointHoverRadius: 6,
        borderWidth: 2.5,
    };

    // Revenue Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Pendapatan',
                data: revenue,
                borderColor: '#3b5d50',
                backgroundColor: gradientRevenue,
                pointBackgroundColor: '#3b5d50',
                ...chartDefaults,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        font: { size: 11 }, color: '#94a3b8',
                        callback: function(v) {
                            if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + ' Jt';
                            if (v >= 1000) return 'Rp ' + (v/1000).toLocaleString('id-ID') + ' Rb';
                            return 'Rp ' + v.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Order Chart
    new Chart(document.getElementById('orderChart'), {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: 'Pesanan',
                data: orders,
                backgroundColor: 'rgba(249,191,41,0.7)',
                borderColor: '#f9bf29',
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#94a3b8' } },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: { font: { size: 11 }, color: '#94a3b8', stepSize: 1 },
                    beginAtZero: true,
                }
            }
        }
    });
</script>
@endsection