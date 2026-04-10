@extends('layouts.admin')
@php $page_title = 'Kelola Pesanan'; @endphp

@section('content')
<style>
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 16px;
    }
    .page-header h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1e293b;
    }
    .page-header p { font-size: 0.875rem; color: #64748b; margin-top: 2px; }

    /* Stats Row */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    .stat-chip {
        background: #ffffff;
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: block;
    }
    .stat-chip:hover, .stat-chip.active {
        border-color: #3b5d50;
        box-shadow: 0 4px 12px rgba(59,93,80,0.15);
        transform: translateY(-2px);
    }
    .stat-chip.active { background: #3b5d50; }
    .stat-chip.active .chip-label, .stat-chip.active .chip-count { color: #ffffff; }
    .chip-label { font-size: 0.75rem; font-weight: 600; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .chip-count { font-size: 1.5rem; font-weight: 800; color: #1e293b; }

    /* Filter & Search Bar */
    .filter-bar {
        background: #ffffff;
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 20px;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }
    .search-input-wrap {
        flex: 1;
        min-width: 200px;
        position: relative;
    }
    .search-input-wrap svg {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px; height: 16px;
        color: #94a3b8;
    }
    .search-input {
        width: 100%;
        padding: 10px 12px 10px 36px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1e293b;
        font-family: 'Inter', sans-serif;
        transition: border-color 0.2s;
    }
    .search-input:focus { outline: none; border-color: #3b5d50; box-shadow: 0 0 0 3px rgba(59,93,80,0.1); }
    .filter-select {
        padding: 10px 14px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1e293b;
        font-family: 'Inter', sans-serif;
        background: #fff;
        cursor: pointer;
    }
    .filter-select:focus { outline: none; border-color: #3b5d50; }

    /* Table */
    .table-card {
        background: #ffffff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }
    .orders-table {
        width: 100%;
        border-collapse: collapse;
    }
    .orders-table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #f1f5f9;
    }
    .orders-table th {
        padding: 14px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: left;
        white-space: nowrap;
    }
    .orders-table td {
        padding: 16px 20px;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    .orders-table tbody tr:last-child td { border-bottom: none; }
    .orders-table tbody tr:hover td { background: #f8fafc; }

    .order-id { font-family: monospace; font-size: 0.8rem; font-weight: 700; color: #3b5d50; }
    .customer-name { font-weight: 600; color: #1e293b; }
    .customer-email { font-size: 0.78rem; color: #94a3b8; }
    .amount { font-weight: 700; color: #1e293b; }
    .date-text { font-size: 0.8rem; color: #64748b; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }
    .s-belum-bayar { background: #fef2f2; color: #dc2626; }
    .s-belum-bayar .badge-dot { background: #dc2626; }
    .s-menunggu-konfirmasi, .s-dikonfirmasi { background: #faf5ff; color: #7c3aed; }
    .s-menunggu-konfirmasi .badge-dot, .s-dikonfirmasi .badge-dot { background: #7c3aed; }
    .s-dikemas { background: #eff6ff; color: #2563eb; }
    .s-dikemas .badge-dot { background: #2563eb; }
    .s-dikirim { background: #fffbeb; color: #d97706; }
    .s-dikirim .badge-dot { background: #d97706; }
    .s-selesai { background: #f0fdf4; color: #16a34a; }
    .s-selesai .badge-dot { background: #16a34a; }
    .s-dibatalkan { background: #f8fafc; color: #64748b; }
    .s-dibatalkan .badge-dot { background: #94a3b8; }

    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 7px 14px;
        background: #f0f7f4;
        color: #3b5d50;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid transparent;
    }
    .btn-detail:hover {
        background: #3b5d50;
        color: #ffffff;
    }
    .btn-detail svg { width: 13px; height: 13px; }

    .empty-state {
        text-align: center;
        padding: 64px 24px;
    }
    .empty-state svg { width: 56px; height: 56px; color: #cbd5e1; margin: 0 auto 16px; }
    .empty-state h3 { font-size: 1.125rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
    .empty-state p { font-size: 0.875rem; color: #94a3b8; }

    .pagination-wrap {
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #64748b;
    }

    /* Action Form Styles */
    .status-select-form { display: flex; align-items: center; gap: 8px; }
    .status-select { 
        padding: 6px 10px; border-radius: 8px; border: 1px solid #e2e8f0; 
        font-size: 0.75rem; font-weight: 600; color: #1e293b; background: #fff;
        font-family: 'Inter', sans-serif; cursor: pointer;
    }
    .status-select:disabled { background: #f8fafc; cursor: not-allowed; opacity: 0.7; }
    .btn-save-status {
        width: 30px; height: 30px; border-radius: 8px; background: #3b5d50; color: #fff;
        border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
        transition: all 0.2s;
    }
    .btn-save-status:hover { background: #2c463c; transform: scale(1.05); }
    .btn-save-status:disabled { background: #94a3b8; cursor: not-allowed; transform: none; }
    
    .btn-download-report {
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px;
        background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8;
        border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-decoration: none;
        transition: all 0.2s;
    }
    .btn-download-report:hover { background: #be185d; color: #fff; }
    .no-action-text { font-size: 0.75rem; color: #94a3b8; font-style: italic; }
</style>

@if(session('success'))
    <div style="background-color: #f0fdf4; color: #16a34a; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; border: 1px solid #bcf0da;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background-color: #fef2f2; color: #dc2626; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-weight: 600; border: 1px solid #fecaca;">
        {{ session('error') }}
    </div>
@endif

<div class="page-header">
    <div>
        <h2>Kelola Pesanan</h2>
        <p>Kelola dan pantau semua pesanan pelanggan</p>
    </div>
</div>

{{-- Stats Chips --}}
<div class="stats-row">
    <a href="{{ route('admin.orders.index') }}" class="stat-chip {{ !request('status') ? 'active' : '' }}">
        <p class="chip-label">Semua</p>
        <p class="chip-count">{{ $counts['all'] }}</p>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'belum-bayar']) }}" class="stat-chip {{ request('status') == 'belum-bayar' ? 'active' : '' }}">
        <p class="chip-label">Belum Bayar</p>
        <p class="chip-count">{{ $counts['belum-bayar'] }}</p>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'menunggu-konfirmasi']) }}" class="stat-chip {{ request('status') == 'menunggu-konfirmasi' ? 'active' : '' }}">
        <p class="chip-label">Konfirmasi</p>
        <p class="chip-count">{{ $counts['menunggu-konfirmasi'] }}</p>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'dikemas']) }}" class="stat-chip {{ request('status') == 'dikemas' ? 'active' : '' }}">
        <p class="chip-label">Dikemas</p>
        <p class="chip-count">{{ $counts['dikemas'] }}</p>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'dikirim']) }}" class="stat-chip {{ request('status') == 'dikirim' ? 'active' : '' }}">
        <p class="chip-label">Dikirim</p>
        <p class="chip-count">{{ $counts['dikirim'] }}</p>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'selesai']) }}" class="stat-chip {{ request('status') == 'selesai' ? 'active' : '' }}">
        <p class="chip-label">Selesai</p>
        <p class="chip-count">{{ $counts['selesai'] }}</p>
    </a>
</div>

{{-- Search & Filter --}}
<form method="GET" action="{{ route('admin.orders.index') }}" class="filter-bar">
    @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <div class="search-input-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" class="search-input" placeholder="Cari nama, email, atau ID pesanan..." value="{{ request('search') }}">
    </div>
    <select name="sort" class="filter-select" onchange="this.form.submit()">
        <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Terbaru</option>
        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
        <option value="highest" {{ request('sort') == 'highest' ? 'selected' : '' }}>Total Tertinggi</option>
    </select>
    <button type="submit" style="padding:10px 18px;background:#3b5d50;color:#fff;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
        Cari
    </button>
</form>

{{-- Table --}}
<div class="table-card">
    @if($orders->count())
        <div style="overflow-x:auto;">
            <!-- Improved Modal Logic -->
            <div id="proofModal" onclick="if(event.target === this) closeModal()" style="display:none; position:fixed; inset:0; background:rgba(15, 23, 42, 0.85); z-index:9999; align-items:center; justify-content:center; padding:24px; backdrop-filter:blur(8px); transition: all 0.3s;">
                <div style="background:#fff; border-radius:24px; max-width:600px; width:100%; max-height: 90vh; position:relative; display:flex; flex-direction:column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); animation: modalBounce 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);">
                    
                    <!-- Header with Close Button -->
                    <div style="padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9;">
                        <h4 style="margin:0; font-weight:800; color:#1e293b; font-size: 1.1rem;">Detail Bukti Bayar</h4>
                        <button onclick="closeModal()" style="width:36px; height:36px; background:#f1f5f9; border:none; border-radius:12px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" hover="background:#fee2e2; color:#ef4444;">
                            <svg style="width:20px; height:20px; color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Image Container -->
                    <div style="padding:12px; overflow-y:auto; flex:1; display:flex; align-items:center; justify-content:center; background: #fafafa;">
                        <img id="proofImage" src="" style="max-width:100%; max-height:60vh; border-radius:12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); object-fit: contain;">
                    </div>

                    <!-- Footer Info -->
                    <div style="padding: 20px 24px; background: #fff; border-radius: 0 0 24px 24px; border-top: 1px solid #f1f5f9;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <p style="margin:0; font-size:0.75rem; color:#64748b; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">ID Pesanan</p>
                                <p id="proofOrderId" style="margin:2px 0 0; font-family:monospace; font-size:1rem; font-weight:800; color:#3b5d50;"></p>
                            </div>
                            <button onclick="closeModal()" style="padding:10px 24px; background:#1e293b; color:#fff; border-radius:12px; border:none; font-weight:700; font-size:0.875rem; cursor:pointer;">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @keyframes modalBounce { from { transform:scale(0.8); opacity:0; } to { transform:scale(1); opacity:1; } }
                .btn-proof { background:#f0f9ff; color:#0369a1; border:none; padding:6px 14px; border-radius:10px; font-weight:700; font-size:0.75rem; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s; border: 1px solid #bae6fd; }
                .btn-proof:hover { background:#0369a1; color:#fff; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(3,105,161,0.2); }
                .btn-no-proof { color:#94a3b8; font-size:0.75rem; font-style:italic; font-weight: 500; }
            </style>

            <table class="orders-table">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        @if(auth('admin')->user()->role !== 'admin')
                            <th>Bukti</th>
                        @endif
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><span class="order-id">{{ $order->id }}</span></td>
                            <td>
                                <p class="customer-name">{{ $order->user->name ?? 'Guest' }}</p>
                                <p class="customer-email">{{ $order->user->email ?? '-' }}</p>
                            </td>
                            <td><span class="amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></td>
                            @if(auth('admin')->user()->role !== 'admin')
                                <td>
                                    @if($order->payment_proof)
                                        <button class="btn-proof" onclick="openModal('{{ asset('storage/' . $order->payment_proof) }}', '{{ $order->id }}')">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat Bukti
                                        </button>
                                    @else
                                        <span class="btn-no-proof">Belum ada</span>
                                    @endif
                                </td>
                            @endif
                            <td><span class="date-text">{{ $order->created_at->format('d M Y') }}</span></td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" style="text-decoration:none;">
                                    <span class="status-badge s-{{ $order->status }}">
                                        <span class="badge-dot"></span>
                                        @if($order->status === 'menunggu-konfirmasi') Menunggu Konfirmasi
                                        @elseif($order->status === 'dikonfirmasi') Konfirmasi
                                        @else {{ str_replace('-', ' ', ucfirst($order->status)) }}
                                        @endif
                                    </span>
                                </a>
                            </td>
                            <td>
                                @if(auth('admin')->user()->role === 'admin')
                                    @if($order->status === 'selesai')
                                        <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn-download-report">
                                            <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            PDF
                                        </a>
                                    @else
                                        <span class="no-action-text">Belum ada</span>
                                    @endif
                                @else
                                    @php
                                        $isDisabled = ($order->status === 'belum-bayar' && !$order->payment_proof);
                                    @endphp
                                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="status-select-form">
                                        @csrf @method('PUT')
                                        <select name="status" class="status-select" {{ $isDisabled ? 'disabled' : '' }} onchange="this.nextElementSibling.disabled = false;">
                                            @if($order->status === 'belum-bayar')
                                                <option value="belum-bayar" selected disabled>Belum Bayar</option>
                                            @endif
                                            <option value="dikonfirmasi" {{ $order->status == 'dikonfirmasi' ? 'selected' : '' }}>Konfirmasi</option>
                                            <option value="dikemas" {{ $order->status == 'dikemas' ? 'selected' : '' }}>Dikemas</option>
                                            <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            @if($order->status === 'dibatalkan')
                                                <option value="dibatalkan" selected disabled>Batal</option>
                                            @endif
                                        </select>
                                        <button type="submit" class="btn-save-status" title="Simpan Perubahan" {{ $isDisabled ? 'disabled' : '' }}>
                                            <svg style="width:16px; height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                function openModal(src, orderId) {
                    const modal = document.getElementById('proofModal');
                    const img = document.getElementById('proofImage');
                    const text = document.getElementById('proofOrderId');
                    img.src = src;
                    text.innerText = orderId;
                    modal.style.display = 'flex';
                }
                function closeModal() {
                    document.getElementById('proofModal').style.display = 'none';
                }
            </script>
        </div>

        <div class="pagination-wrap">
            <span>Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan</span>
            <div>
                {{ $orders->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <h3>Tidak ada pesanan</h3>
            <p>Belum ada pesanan yang cocok dengan filter ini</p>
        </div>
    @endif
</div>

@endsection
