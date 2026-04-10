@extends('layouts.admin')
@php $page_title = 'Laporan Penjualan'; @endphp

@section('content')
<style>
    :root {
        --primary-green: #3b5d50;
        --accent-yellow: #f9bf29;
        --slate-text: #1e293b;
        --slate-sub: #64748b;
        --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }

    .report-container { max-width: 1200px; margin: 0 auto; animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

    .action-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 32px; flex-wrap: wrap; gap: 20px; }
    .header-text h2 { font-size: 1.85rem; font-weight: 800; color: var(--slate-text); letter-spacing: -0.025em; }
    .header-text p { color: var(--slate-sub); font-size: 0.95rem; }

    .export-btn {
        background: var(--primary-green);
        color: #fff;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(59, 93, 80, 0.2);
    }
    .export-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(59, 93, 80, 0.3); background: #2f4a40; }

    /* ── Stats ────────────────────────────────── */
    .stat-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
    .report-card { 
        background: #fff; border-radius: 20px; padding: 28px; border: 1px solid #f1f5f9; 
        box-shadow: var(--card-shadow); position: relative; overflow: hidden;
    }
    .report-card::before {
        content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--primary-green); opacity: 0.5;
    }
    .stat-label { font-size: 0.8rem; font-weight: 700; color: var(--slate-sub); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 12px; }
    .stat-value { font-size: 2rem; font-weight: 800; color: var(--slate-text); letter-spacing: -0.02em; margin-bottom: 8px; }
    .stat-badge { font-size: 0.8rem; font-weight: 600; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px; }
    .badge-green { background: #f0fdf4; color: #16a34a; }

    /* ── Filters ──────────────────────────────── */
    .filter-panel { 
        background: #fff; border-radius: 20px; padding: 24px; margin-bottom: 32px; border: 1px solid #f1f5f9;
        display: flex; align-items: flex-end; gap: 20px; flex-wrap: wrap; box-shadow: var(--card-shadow);
    }
    .filter-group { display: flex; flex-direction: column; gap: 8px; flex: 1; min-width: 200px; }
    .filter-label { font-size: 0.75rem; font-weight: 700; color: var(--slate-sub); text-transform: uppercase; letter-spacing: 0.05em; }
    .filter-input { 
        padding: 12px 16px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 0.95rem; font-family: inherit;
        outline: none; transition: all 0.2s; background: #f8fafc; color: var(--slate-text); font-weight: 500;
    }
    .filter-input:focus { border-color: var(--primary-green); background: #fff; box-shadow: 0 0 0 4px rgba(59, 93, 80, 0.1); }
    .btn-apply { 
        padding: 13px 28px; background: var(--primary-green); color: #fff; border-radius: 12px; 
        font-weight: 700; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.2s;
        box-shadow: 0 4px 6px -1px rgba(59, 93, 80, 0.2);
    }
    .btn-apply:hover { background: #2f4a40; transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(59, 93, 80, 0.3); }

    /* ── Charts & Grid ─────────────────────────── */
    .visual-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 24px; }
    .chart-box { background: #fff; border-radius: 20px; padding: 32px; border: 1px solid #f1f5f9; box-shadow: var(--card-shadow); }
    .box-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .box-title { font-size: 1.1rem; font-weight: 800; color: var(--slate-text); }
    
    .top-products-card { background: #fff; border-radius: 20px; padding: 32px; border: 1px solid #f1f5f9; box-shadow: var(--card-shadow); }
    .product-list { display: flex; flex-direction: column; gap: 16px; }
    .product-item { display: flex; align-items: center; gap: 16px; }
    .product-rank { 
        width: 32px; height: 32px; border-radius: 10px; background: #f1f5f9; 
        display: flex; align-items: center; justify-content: center; font-weight: 800; color: var(--slate-text); font-size: 0.85rem;
    }
    .p-info { flex: 1; }
    .p-name { font-weight: 700; color: var(--slate-text); font-size: 0.9rem; margin-bottom: 2px; }
    .p-sold { font-size: 0.8rem; font-weight: 600; color: var(--primary-green); }
    .p-sold span { color: var(--slate-sub); font-weight: 400; }

    @media (max-width: 992px) {
        .stat-row { grid-template-columns: repeat(2, 1fr); }
        .visual-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .stat-row { grid-template-columns: 1fr; }
        .action-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="report-container">
    {{-- Header Section --}}
    <div class="action-header">
        <div class="header-text">
            <h2>Laporan Penjualan</h2>
            <p>Tinjauan performa keuangan toko kamu secara komprehensif.</p>
        </div>
        <a href="{{ route('admin.reports.sales.pdf', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}" class="export-btn">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Export ke PDF
        </a>
    </div>

    {{-- Filter Panel --}}
    <form action="{{ route('admin.reports.sales') }}" method="GET" class="filter-panel">
        <div class="filter-group">
            <span class="filter-label">
                <svg style="width: 14px; height: 14px; display: inline; margin-bottom: -2px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Periode Mulai
            </span>
            <input type="date" name="start_date" class="filter-input" value="{{ $startDate->format('Y-m-d') }}">
        </div>
        <div class="filter-group">
            <span class="filter-label">
                <svg style="width: 14px; height: 14px; display: inline; margin-bottom: -2px; margin-right: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Periode Akhir
            </span>
            <input type="date" name="end_date" class="filter-input" value="{{ $endDate->format('Y-m-d') }}">
        </div>
        <button type="submit" class="btn-apply">Terapkan Filter</button>
    </form>

    {{-- Key Metrics --}}
    <div class="stat-row">
        <div class="report-card">
            <p class="stat-label">Total Pendapatan</p>
            <p class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <div class="stat-badge badge-green">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 10-2-2h-2V7z" clip-rule="evenodd"/></svg>
                Pesanan Terbayar
            </div>
        </div>
        <div class="report-card">
            <p class="stat-label">Total Pesanan</p>
            <p class="stat-value">{{ number_format($completedOrders) }}</p>
            <div class="stat-badge" style="background:#eff6ff; color:#2563eb;">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                {{ number_format($totalOrders) }} Transaksi dibuat
            </div>
        </div>
        <div class="report-card">
            <p class="stat-label">Rata-rata Penjualan</p>
            <p class="stat-value">Rp {{ $completedOrders > 0 ? number_format($totalRevenue / $completedOrders, 0, ',', '.') : 0 }}</p>
            <div class="stat-badge" style="background:#f8fafc; color:#64748b;">
                Per Transaksi
            </div>
        </div>
    </div>

    {{-- Visual Section --}}
    <div class="visual-grid">
        <div class="chart-box">
            <div class="box-header">
                <p class="box-title">Tren Pendapatan Harian</p>
            </div>
            <div style="height: 350px;">
                <canvas id="revenueTrendChartExpanded"></canvas>
            </div>
        </div>

        <div class="top-products-card">
            <div class="box-header">
                <p class="box-title">Produk Terlaris</p>
            </div>
            <div class="product-list">
                @forelse($topProducts as $index => $item)
                    <div class="product-item">
                        <div class="product-rank">{{ $index + 1 }}</div>
                        <div class="p-info">
                            <p class="p-name">{{ $item->product->name }}</p>
                            <p class="p-sold">{{ $item->total_sold }} <span>Unit terjual</span></p>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-12 text-slate-400 font-medium">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueTrendChartExpanded').getContext('2d');
    
    // Create gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 93, 80, 0.25)');
    gradient.addColorStop(1, 'rgba(59, 93, 80, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueTrend->map(fn($d) => \Carbon\Carbon::parse($d->date)->format('d M'))) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueTrend->map(fn($d) => $d->total)) !!},
                borderColor: '#3b5d50',
                backgroundColor: gradient,
                borderWidth: 4,
                fill: true,
                tension: 0.45,
                pointRadius: 6,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b5d50',
                pointBorderWidth: 3,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#3b5d50',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleFont: { size: 13, weight: '700' },
                    bodyFont: { size: 14, weight: '600' },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11, weight: '600' },
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + ' Jt';
                            if (value >= 1000) return 'Rp ' + (value/1000).toLocaleString('id-ID') + ' Rb';
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { 
                        color: '#94a3b8',
                        font: { size: 11, weight: '600' }
                    }
                }
            }
        }
    });
</script>
@endsection
