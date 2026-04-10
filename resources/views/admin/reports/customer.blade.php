@extends('layouts.admin')
@php 
    $user = auth('admin')->user();
    $page_title = 'Laporan Customer'; 
@endphp

@section('content')
<style>
    :root {
        --primary-green: #3b5d50;
        --secondary-pink: #db2777;
        --slate-800: #1e293b;
        --slate-500: #64748b;
        --card-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .report-wrap { max-width: 1000px; margin: 0 auto; animation: fadeInUp 0.6s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .header-box { margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center; }
    .header-text h2 { font-size: 1.75rem; font-weight: 800; color: var(--slate-800); margin-bottom: 4px; }
    .header-text p { color: var(--slate-500); font-size: 0.95rem; }

    .report-card-list { display: flex; flex-direction: column; gap: 20px; }
    .report-item-card { 
        background: #fff; border-radius: 20px; border: 1px solid #f1f5f9; 
        box-shadow: var(--card-shadow); transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex; flex-direction: column;
    }
    .report-item-card:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); }

    .item-header { padding: 24px 28px; display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #f8fafc; }
    .cust-profile { display: flex; align-items: center; gap: 16px; }
    .avatar-circle { 
        width: 48px; height: 48px; border-radius: 14px; background: #eff6ff; color: #3b82f6;
        display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.1rem;
    }
    .info-name { font-weight: 800; color: var(--slate-800); font-size: 1rem; }
    .info-email { font-size: 0.825rem; color: var(--slate-500); font-weight: 500; }

    .status-capsule {
        padding: 5px 14px; border-radius: 30px; font-size: 0.725rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em;
    }
    .capsule-pending { background: #fffbeb; color: #b45309; }
    .capsule-forwarded { background: #fdf2f8; color: #be185d; }
    .capsule-resolved { background: #f0fdf4; color: #15803d; }

    .item-body { padding: 24px 28px; background: #fcfdfe; }
    .msg-content { 
        font-size: 0.95rem; color: #334155; line-height: 1.7; position: relative; padding-left: 20px; border-left: 3px solid #e2e8f0;
    }

    .item-footer { padding: 20px 28px; display: flex; justify-content: space-between; align-items: center; background: #fff; border-radius: 0 0 20px 20px; }
    .meta-time { font-size: 0.8rem; color: var(--slate-500); font-weight: 500; }
    
    .action-row { display: flex; gap: 12px; }
    .btn-icon {
        padding: 10px 20px; border-radius: 12px; font-size: 0.825rem; font-weight: 700; 
        display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .btn-icon:hover { transform: translateY(-1px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
    .btn-pink { background: linear-gradient(135deg, #db2777, #be185d); color: #fff; }
    .btn-pink:hover { background: linear-gradient(135deg, #be185d, #9d174d); }
    .btn-green { background: linear-gradient(135deg, #10b981, #059669); color: #fff; }
    .btn-green:hover { background: linear-gradient(135deg, #059669, #047857); }
    .btn-outline-red { background: #fff1f2; color: #e11d48; padding: 10px; border: 1px solid #fecdd3; }
    .btn-outline-red:hover { background: #ffe4e6; color: #be123c; }

    .empty-state { 
        text-align: center; padding: 48px 24px; background: #fff; 
        border-radius: 16px; border: 1px solid #f1f5f9; 
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .empty-state p { margin: 0; }
</style>

<div class="report-wrap">
    {{-- Page Header --}}
    <div class="header-box">
        <div class="header-text">
            <h2>{{ $page_title }}</h2>
            <p>
                @if($user->role === 'admin')
                    Laporan krusial yang perlu ditindaklanjuti dari petugas.
                @else
                    Tanggapi dan kelola masukan dari customer setiap hari.
                @endif
            </p>
        </div>
    </div>

    {{-- Report Cards --}}
    <div class="report-card-list">
        @forelse($reports as $report)
            <div class="report-item-card">
                <div class="item-header">
                    <div class="cust-profile">
                        <div class="avatar-circle">{{ strtoupper(substr($report->name, 0, 1)) }}</div>
                        <div>
                            <p class="info-name">{{ $report->name }}</p>
                            <p class="info-email">{{ $report->email }}</p>
                        </div>
                    </div>
                    <span class="status-capsule capsule-{{ $report->status }}">{{ $report->status }}</span>
                </div>
                
                <div class="item-body">
                    <div class="msg-content">
                        {{ $report->message }}
                    </div>
                </div>

                <div class="item-footer">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg style="width:14px;height:14px;color:var(--slate-500)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="meta-time">Diterima {{ $report->created_at->format('d M Y, H:i') }} <span style="opacity:0.6;font-weight:400;margin-left:4px;">({{ $report->created_at->diffForHumans() }})</span></p>
                    </div>
                    
                    <div class="action-row">
                        @if($user->role === 'staff' && $report->status === 'pending')
                            <form action="{{ route('admin.reports.customer.forward', $report->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-icon btn-pink">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                                    Teruskan ke Admin
                                </button>
                            </form>
                        @endif

                        @if($report->status !== 'resolved')
                            <form action="{{ route('admin.reports.customer.resolve', $report->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-icon btn-green">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Selesaikan
                                </button>
                            </form>
                        @endif

                        @if($user->role === 'admin')
                            <form action="{{ route('admin.reports.customer.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon btn-outline-red" title="Hapus Laporan">
                                    <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <p class="text-slate-500 font-bold text-lg">Belum ada laporan masuk</p>
                <p class="text-slate-400 text-sm mt-1">Laporan terbaru dari pelanggan akan muncul secara otomatis di daftar ini.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $reports->links() }}
    </div>
</div>
@endsection
