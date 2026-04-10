@extends('layouts.admin')
@php $page_title = 'Manajemen Pengguna'; @endphp

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
    .page-header h2 { font-size: 1.5rem; font-weight: 800; color: #1e293b; }
    .page-header p { font-size: 0.875rem; color: #64748b; margin-top: 2px; }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }
    .stat-card {
        background: #fff;
        border-radius: 14px;
        padding: 20px 22px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }
    .stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
    .stat-icon svg { width: 18px; height: 18px; }
    .icon-purple { background: #faf5ff; color: #7c3aed; }
    .icon-blue   { background: #eff6ff; color: #2563eb; }
    .icon-green  { background: #f0fdf4; color: #16a34a; }
    .stat-label { font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
    .stat-value { font-size: 1.75rem; font-weight: 800; color: #1e293b; }

    /* Search bar */
    .filter-bar {
        background: #fff;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }
    .search-wrap { flex: 1; min-width: 200px; position: relative; }
    .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; }
    .search-input { width: 100%; padding: 10px 12px 10px 36px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; font-family: 'Inter', sans-serif; }
    .search-input:focus { outline: none; border-color: #3b5d50; box-shadow: 0 0 0 3px rgba(59,93,80,0.1); }
    .filter-btn { padding: 10px 18px; background: #3b5d50; color: #fff; border: none; border-radius: 8px; font-size: 0.875rem; font-weight: 600; cursor: pointer; font-family: 'Inter', sans-serif; }

    /* Section separator */
    .section-label {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        margin-top: 8px;
    }
    .section-label-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .badge-admin   { background: #faf5ff; color: #6d28d9; border: 1.5px solid #ddd6fe; }
    .badge-staff   { background: #eff6ff; color: #1d4ed8; border: 1.5px solid #bfdbfe; }
    .badge-user    { background: #f0fdf4; color: #15803d; border: 1.5px solid #bbf7d0; }
    .section-count { font-size: 0.78rem; color: #94a3b8; font-weight: 600; }

    /* Table */
    .table-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 28px;
    }
    .users-table { width: 100%; border-collapse: collapse; }
    .users-table thead tr { background: #f8fafc; border-bottom: 2px solid #f1f5f9; }
    .users-table th {
        padding: 13px 20px;
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: left;
    }
    .users-table td {
        padding: 15px 20px;
        font-size: 0.875rem;
        color: #334155;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    .users-table tbody tr:last-child td { border-bottom: none; }
    .users-table tbody tr:hover td { background: #f8fafc; }

    .user-cell { display: flex; align-items: center; gap: 12px; }
    .user-avatar {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800;
        font-size: 0.8rem;
        flex-shrink: 0;
        color: #fff;
    }
    .avatar-admin  { background: linear-gradient(135deg, #7c3aed, #5b21b6); }
    .avatar-staff  { background: linear-gradient(135deg, #2563eb, #1d4ed8); }
    .avatar-user   { background: linear-gradient(135deg, #3b5d50, #2d4a3e); }

    .user-name  { font-weight: 700; color: #1e293b; font-size: 0.875rem; }
    .user-email { font-size: 0.78rem; color: #94a3b8; }
    .order-count { font-weight: 700; color: #3b5d50; }
    .join-date  { font-size: 0.8rem; color: #64748b; }
    .total-spend { font-weight: 700; color: #1e293b; }

    /* Empty state per table */
    .empty-row td {
        text-align: center;
        padding: 32px;
        color: #94a3b8;
        font-size: 0.875rem;
        font-style: italic;
    }

    /* Pagination */
    .pagination-wrap {
        padding: 14px 20px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.8rem;
        color: #64748b;
    }
</style>

<div class="page-header">
    <div>
        <h2>Manajemen Pengguna</h2>
        <p>Pantau semua akun yang terdaftar dalam sistem</p>
    </div>
</div>

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon icon-purple">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <p class="stat-label">Admin</p>
        <p class="stat-value">{{ $stats['admin'] }}</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
        <p class="stat-label">Petugas</p>
        <p class="stat-value">{{ $stats['staff'] }}</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
        </div>
        <p class="stat-label">Pelanggan</p>
        <p class="stat-value">{{ $stats['user'] }}</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#f8fafc;color:#64748b;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <p class="stat-label">Total</p>
        <p class="stat-value">{{ $stats['total'] }}</p>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.users.index') }}" class="filter-bar">
    <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" class="search-input" placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}">
    </div>
    <button type="submit" class="filter-btn">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.users.index') }}" style="padding:10px 14px;background:#f1f5f9;color:#64748b;border-radius:8px;font-size:0.875rem;font-weight:600;text-decoration:none;">Reset</a>
    @endif
</form>

{{-- ══════════════════════════════════════ --}}
{{-- TABEL ADMIN --}}
{{-- ══════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-badge badge-admin">
        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        Admin
    </span>
    <span class="section-count">{{ $admins->count() }} akun</span>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Pesanan</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar avatar-admin">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td><span class="user-email" style="font-size:0.875rem;color:#334155;">{{ $user->email }}</span></td>
                        <td><span class="order-count">{{ $user->orders_count }}</span></td>
                        <td><span class="join-date">{{ $user->created_at->format('d M Y') }}</span></td>
                    </tr>
                @empty
                    <tr class="empty-row"><td colspan="4">Belum ada akun admin</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- TABEL PETUGAS (STAFF) --}}
{{-- ══════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-badge badge-staff">
        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        Petugas
    </span>
    <span class="section-count">{{ $staffs->count() }} akun</span>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Pesanan Diproses</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffs as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar avatar-staff">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td><span style="font-size:0.875rem;color:#334155;">{{ $user->email }}</span></td>
                        <td><span class="order-count">{{ $user->orders_count }}</span></td>
                        <td><span class="join-date">{{ $user->created_at->format('d M Y') }}</span></td>
                    </tr>
                @empty
                    <tr class="empty-row"><td colspan="4">Belum ada akun petugas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- TABEL USER / PELANGGAN --}}
{{-- ══════════════════════════════════════ --}}
<div class="section-label">
    <span class="section-label-badge badge-user">
        <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Pelanggan
    </span>
    <span class="section-count">{{ $users->total() }} akun</span>
</div>
<div class="table-card">
    <div style="overflow-x:auto;">
        <table class="users-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Pesanan</th>
                    <th>Total Belanja</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar avatar-user">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                <div>
                                    <p class="user-name">{{ $user->name }}</p>
                                    <p class="user-email">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td><span class="order-count">{{ $user->orders_count }}</span> <span style="color:#94a3b8;font-size:0.8rem;">pesanan</span></td>
                        <td><span class="total-spend">Rp {{ number_format($user->orders_sum_total_amount ?? 0, 0, ',', '.') }}</span></td>
                        <td><span class="join-date">{{ $user->created_at->format('d M Y') }}</span></td>
                    </tr>
                @empty
                    <tr class="empty-row"><td colspan="5">Belum ada pelanggan terdaftar</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="pagination-wrap">
            <span>Menampilkan {{ $users->firstItem() }}–{{ $users->lastItem() }} dari {{ $users->total() }} pelanggan</span>
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif
</div>

@endsection
