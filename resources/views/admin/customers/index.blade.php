@extends('layouts.admin')
@php $page_title = 'Customer'; @endphp

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .page-header h2 { font-size:1.5rem; font-weight:800; color:#1e293b; }
    .page-header p  { font-size:0.875rem; color:#64748b; margin-top:2px; }

    .stats-row { display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px; margin-bottom:24px; }
    .stat-card { background:#fff; border-radius:14px; padding:20px 22px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .stat-icon { width:36px; height:36px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:12px; }
    .stat-icon svg { width:18px; height:18px; }
    .icon-g { background:#f0fdf4; color:#16a34a; }
    .icon-b { background:#eff6ff; color:#2563eb; }
    .icon-y { background:#fffbeb; color:#d97706; }
    .stat-label { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:5px; }
    .stat-value { font-size:1.5rem; font-weight:800; color:#1e293b; }

    .filter-bar { background:#fff; border-radius:14px; padding:14px 20px; margin-bottom:20px; display:flex; gap:12px; align-items:center; flex-wrap:wrap; box-shadow:0 1px 4px rgba(0,0,0,0.05); border:1px solid #f1f5f9; }
    .search-wrap { flex:1; min-width:200px; position:relative; }
    .search-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#94a3b8; }
    .search-input { width:100%; padding:10px 12px 10px 36px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.875rem; font-family:'Inter',sans-serif; }
    .search-input:focus { outline:none; border-color:#3b5d50; box-shadow:0 0 0 3px rgba(59,93,80,0.1); }

    .table-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.05); border:1px solid #f1f5f9; }
    .cust-table { width:100%; border-collapse:collapse; }
    .cust-table thead tr { background:#f8fafc; border-bottom:2px solid #f1f5f9; }
    .cust-table th { padding:13px 20px; font-size:0.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; text-align:left; }
    .cust-table td { padding:16px 20px; font-size:0.875rem; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .cust-table tbody tr:last-child td { border-bottom:none; }
    .cust-table tbody tr:hover td { background:#f8fafc; }

    .user-cell { display:flex; align-items:center; gap:12px; }
    .user-avatar { width:40px; height:40px; border-radius:12px; flex-shrink:0; background:linear-gradient(135deg, #3b5d50, #2d4a3e); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.875rem; }
    .user-name  { font-weight:700; color:#1e293b; font-size:0.875rem; }
    .user-email { font-size:0.75rem; color:#94a3b8; }
    .join-date  { font-size:0.8rem; color:#64748b; }
    .spend      { font-weight:700; color:#1e293b; }

    .actions-cell { display:flex; gap:8px; }
    .btn-view { display:inline-flex; align-items:center; gap:5px; padding:7px 13px; background:#f0f7f4; color:#3b5d50; border-radius:8px; font-size:0.78rem; font-weight:700; text-decoration:none; transition:all 0.2s; }
    .btn-view:hover { background:#3b5d50; color:#fff; }
    .btn-view svg { width:13px; height:13px; }
    .btn-del { display:inline-flex; align-items:center; gap:5px; padding:7px 13px; background:#fef2f2; color:#dc2626; border-radius:8px; font-size:0.78rem; font-weight:700; border:none; cursor:pointer; transition:all 0.2s; font-family:'Inter',sans-serif; }
    .btn-del:hover { background:#dc2626; color:#fff; }
    .btn-del svg { width:13px; height:13px; }

    .empty-state { text-align:center; padding:64px 24px; }
    .empty-state svg { width:56px; height:56px; color:#cbd5e1; margin:0 auto 16px; }
    .empty-state h3 { font-size:1.125rem; font-weight:700; color:#334155; margin-bottom:6px; }
    .empty-state p  { font-size:0.875rem; color:#94a3b8; }

    .pagination-wrap { padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; font-size:0.8rem; color:#64748b; }

    /* Delete Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:200; align-items:center; justify-content:center; padding:24px; }
    .modal-overlay.open { display:flex; }
    .delete-box { background:#fff; border-radius:20px; padding:36px; width:100%; max-width:380px; text-align:center; animation:modalIn 0.25s ease; }
    @keyframes modalIn { from{opacity:0;transform:scale(0.95) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
    .delete-icon { width:60px; height:60px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .delete-icon svg { width:28px; height:28px; color:#dc2626; }
    .delete-title { font-size:1.1rem; font-weight:800; color:#1e293b; margin-bottom:8px; }
    .delete-desc  { font-size:0.875rem; color:#64748b; margin-bottom:20px; }
    .form-actions { display:flex; gap:10px; }
    .btn-cancel { flex:1; padding:11px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-del-confirm { flex:2; padding:11px; background:#dc2626; color:#fff; border:none; border-radius:9px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-del-confirm:hover { background:#b91c1c; }
</style>

<div class="page-header">
    <div>
        <h2>Customer</h2>
        <p>Pantau dan kelola akun pelanggan yang terdaftar</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon icon-g">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <p class="stat-label">Total Customer</p>
        <p class="stat-value">{{ $stats['total'] }}</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-b">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        </div>
        <p class="stat-label">Bulan Ini</p>
        <p class="stat-value">{{ $stats['new_this_month'] }}</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-y">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="stat-label">Total Pendapatan dari Customer</p>
        <p class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($stats['total_spend'], 0, ',', '.') }}</p>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.customers.index') }}" class="filter-bar">
    <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" class="search-input" placeholder="Cari nama atau email customer..." value="{{ request('search') }}">
    </div>
    <button type="submit" style="padding:10px 18px;background:#3b5d50;color:#fff;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.customers.index') }}" style="padding:10px 14px;background:#f1f5f9;color:#64748b;border-radius:8px;font-size:0.875rem;font-weight:600;text-decoration:none;">Reset</a>
    @endif
</form>

{{-- Table --}}
<div class="table-card">
    @if($customers->count())
        <div style="overflow-x:auto;">
            <table class="cust-table">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Total Pesanan</th>
                        <th>Total Belanja</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                                    <div>
                                        <p class="user-name">{{ $customer->name }}</p>
                                        <p class="user-email">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:700;color:#3b5d50;">{{ $customer->orders_count }}</span>
                                <span style="color:#94a3b8;font-size:0.8rem;"> pesanan</span>
                            </td>
                            <td><span class="spend">Rp {{ number_format($customer->orders_sum_total_amount ?? 0, 0, ',', '.') }}</span></td>
                            <td><span class="join-date">{{ $customer->created_at->format('d M Y') }}</span></td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn-view">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Profil
                                    </a>
                                    <button class="btn-del" onclick="openDeleteModal({{ $customer->id }}, '{{ addslashes($customer->name) }}')">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="pagination-wrap">
                <span>Menampilkan {{ $customers->firstItem() }}–{{ $customers->lastItem() }} dari {{ $customers->total() }} customer</span>
                {{ $customers->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <h3>Tidak ada customer</h3>
            <p>Belum ada customer yang cocok dengan pencarian ini</p>
        </div>
    @endif
</div>

{{-- Delete Modal --}}
<div class="modal-overlay" id="deleteModal">
    <div class="delete-box">
        <div class="delete-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <p class="delete-title">Hapus Akun Customer?</p>
        <p class="delete-desc" id="deleteDesc">Semua data pesanan juga akan terpengaruh.</p>
        <div class="form-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="flex:2;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del-confirm" style="width:100%;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openDeleteModal(id, name) {
    document.getElementById('deleteDesc').textContent = 'Akun "' + name + '" dan seluruh datanya akan dihapus permanen.';
    document.getElementById('deleteForm').action = '/admin-petugas/customers/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); }
document.getElementById('deleteModal').addEventListener('click', e => { if(e.target===e.currentTarget) closeDeleteModal(); });
</script>
@endsection
