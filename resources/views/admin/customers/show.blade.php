@extends('layouts.admin')
@php $page_title = 'Profil Customer'; @endphp

@section('content')
<style>
    .back-btn { display:inline-flex; align-items:center; gap:8px; padding:9px 18px; background:#fff; color:#3b5d50; border:1px solid #e2e8f0; border-radius:9px; font-size:0.875rem; font-weight:700; text-decoration:none; margin-bottom:24px; transition:all 0.2s; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .back-btn:hover { background:#3b5d50; color:#fff; border-color:#3b5d50; }
    .back-btn svg { width:16px; height:16px; }

    .profile-grid { display:grid; grid-template-columns:320px 1fr; gap:24px; align-items:flex-start; }
    @media(max-width:1024px) { .profile-grid { grid-template-columns:1fr; } }

    /* Profile Card */
    .profile-card { background:#fff; border-radius:20px; padding:32px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.05); }
    .profile-header { text-align:center; margin-bottom:28px; }
    .profile-avatar { width:80px; height:80px; border-radius:24px; background:linear-gradient(135deg, #3b5d50, #2d4a3e); color:#fff; display:flex; align-items:center; justify-content:center; font-size:2rem; font-weight:800; margin:0 auto 16px; box-shadow:0 8px 20px rgba(59,93,80,0.3); }
    .profile-name  { font-size:1.25rem; font-weight:800; color:#1e293b; margin-bottom:4px; }
    .profile-email { font-size:0.85rem; color:#94a3b8; }
    .profile-since { display:inline-block; margin-top:12px; padding:4px 12px; background:#f0fdf4; color:#16a34a; border-radius:20px; font-size:0.75rem; font-weight:700; }

    .divider { height:1px; background:#f1f5f9; margin:20px 0; }

    .info-row { display:flex; flex-direction:column; gap:4px; margin-bottom:18px; }
    .info-row:last-child { margin-bottom:0; }
    .info-lbl { font-size:0.72rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:0.05em; }
    .info-val { font-size:0.9rem; font-weight:600; color:#1e293b; }

    /* Stats row inside profile */
    .mini-stats { display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; margin-top:20px; }
    .mini-stat { background:#f8fafc; border-radius:12px; padding:14px; text-align:center; }
    .mini-stat-val { font-size:1.2rem; font-weight:800; color:#3b5d50; }
    .mini-stat-lbl { font-size:0.7rem; color:#94a3b8; font-weight:600; margin-top:2px; }

    /* Orders history */
    .hist-card { background:#fff; border-radius:20px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.05); overflow:hidden; }
    .hist-header { padding:22px 28px; border-bottom:2px solid #f8fafc; }
    .hist-title { font-size:1rem; font-weight:800; color:#1e293b; }
    .order-item { padding:18px 28px; border-bottom:1px solid #f8fafc; transition:background 0.15s; }
    .order-item:last-child { border-bottom:none; }
    .order-item:hover { background:#f8fafc; }
    .order-item-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:10px; }
    .order-id { font-family:monospace; font-size:0.8rem; font-weight:700; color:#3b5d50; }
    .order-date { font-size:0.78rem; color:#94a3b8; }
    .order-item-bottom { display:flex; align-items:center; justify-content:space-between; }
    .order-products { font-size:0.8rem; color:#64748b; }
    .order-amount { font-size:0.95rem; font-weight:800; color:#1e293b; }

    .status-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 9px; border-radius:20px; font-size:0.72rem; font-weight:700; }
    .badge-dot { width:5px; height:5px; border-radius:50%; }
    .s-belum-bayar { background:#fef2f2; color:#dc2626; } .s-belum-bayar .badge-dot { background:#dc2626; }
    .s-menunggu-konfirmasi { background:#faf5ff; color:#7c3aed; } .s-menunggu-konfirmasi .badge-dot { background:#7c3aed; }
    .s-dikemas { background:#eff6ff; color:#2563eb; } .s-dikemas .badge-dot { background:#2563eb; }
    .s-dikirim { background:#fffbeb; color:#d97706; } .s-dikirim .badge-dot { background:#d97706; }
    .s-selesai { background:#f0fdf4; color:#16a34a; } .s-selesai .badge-dot { background:#16a34a; }
    .s-dibatalkan { background:#f8fafc; color:#64748b; } .s-dibatalkan .badge-dot { background:#94a3b8; }

    .no-orders { text-align:center; padding:48px; color:#94a3b8; font-style:italic; }

    /* Address section */
    .address-card { background:#fff; border-radius:20px; border:1px solid #f1f5f9; box-shadow:0 1px 4px rgba(0,0,0,0.05); overflow:hidden; margin-top:20px; }
    .addr-header { padding:18px 28px; border-bottom:2px solid #f8fafc; }
    .addr-title { font-size:1rem; font-weight:800; color:#1e293b; }
    .addr-item { padding:16px 28px; border-bottom:1px solid #f8fafc; }
    .addr-item:last-child { border-bottom:none; }
    .addr-name { font-weight:700; color:#1e293b; font-size:0.875rem; margin-bottom:4px; }
    .addr-detail { font-size:0.8rem; color:#64748b; line-height:1.6; }
</style>

<a href="{{ route('admin.customers.index') }}" class="back-btn">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Kembali ke Daftar Customer
</a>

<div class="profile-grid">
    {{-- Left: Profile Card --}}
    <div>
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
                <p class="profile-name">{{ $customer->name }}</p>
                <p class="profile-email">{{ $customer->email }}</p>
                <span class="profile-since">Bergabung {{ $customer->created_at->format('d M Y') }}</span>
            </div>

            <div class="mini-stats">
                <div class="mini-stat">
                    <p class="mini-stat-val">{{ $orderStats['total'] }}</p>
                    <p class="mini-stat-lbl">Pesanan</p>
                </div>
                <div class="mini-stat">
                    <p class="mini-stat-val">{{ $orderStats['selesai'] }}</p>
                    <p class="mini-stat-lbl">Selesai</p>
                </div>
                <div class="mini-stat">
                    <p class="mini-stat-val" style="font-size:0.85rem;">Rp {{ number_format($orderStats['spend']/1000, 0) }}K</p>
                    <p class="mini-stat-lbl">Total Belanja</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="info-row">
                <span class="info-lbl">Username</span>
                <span class="info-val">{{ $customer->username ?? '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-lbl">Role</span>
                <span class="info-val" style="color:#16a34a;">Customer</span>
            </div>
            <div class="info-row">
                <span class="info-lbl">Jumlah Alamat</span>
                <span class="info-val">{{ $customer->addresses->count() }} alamat tersimpan</span>
            </div>
        </div>

        {{-- Danger Zone --}}
        <div style="background:#fff;border-radius:16px;padding:22px 24px;margin-top:20px;border:1.5px solid #fee2e2;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <p style="font-size:0.85rem;font-weight:800;color:#dc2626;margin-bottom:8px;">⚠ Zona Berbahaya</p>
            <p style="font-size:0.78rem;color:#64748b;margin-bottom:16px;">Menghapus akun akan menghapus semua data customer secara permanen.</p>
            <form method="POST" action="{{ route('admin.customers.destroy', $customer->id) }}" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                @csrf @method('DELETE')
                <button type="submit" style="width:100%;padding:10px;background:#dc2626;color:#fff;border:none;border-radius:9px;font-size:0.875rem;font-weight:700;cursor:pointer;font-family:'Inter',sans-serif;">
                    Hapus Akun Customer
                </button>
            </form>
        </div>
    </div>

    {{-- Right: Orders + Address --}}
    <div>
        {{-- Order History --}}
        <div class="hist-card">
            <div class="hist-header">
                <p class="hist-title">Riwayat Pesanan ({{ $customer->orders->count() }})</p>
            </div>
            @forelse($customer->orders->sortByDesc('created_at')->take(20) as $order)
                <div class="order-item">
                    <div class="order-item-top">
                        <span class="order-id">{{ $order->id }}</span>
                        <span class="status-badge s-{{ $order->status }}">
                            <span class="badge-dot"></span>
                            {{ str_replace('-', ' ', ucfirst($order->status)) }}
                        </span>
                    </div>
                    <div class="order-item-bottom">
                        <span class="order-products">
                            {{ $order->items->count() }} produk
                            · {{ $order->created_at->format('d M Y') }}
                        </span>
                        <span class="order-amount">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            @empty
                <p class="no-orders">Customer ini belum memiliki pesanan</p>
            @endforelse
        </div>

        {{-- Addresses --}}
        @if($customer->addresses->count())
            <div class="address-card">
                <div class="addr-header">
                    <p class="addr-title">Alamat Tersimpan ({{ $customer->addresses->count() }})</p>
                </div>
                @foreach($customer->addresses as $addr)
                    <div class="addr-item">
                        <p class="addr-name">{{ $addr->recipient_name }} · {{ $addr->phone_number }}</p>
                        <p class="addr-detail">{{ $addr->full_address }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
