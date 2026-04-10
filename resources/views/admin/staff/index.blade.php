@extends('layouts.admin')
@php $page_title = 'Petugas'; @endphp

@section('content')
<style>
    .page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; flex-wrap:wrap; gap:16px; }
    .page-header h2 { font-size:1.5rem; font-weight:800; color:#1e293b; }
    .page-header p  { font-size:0.875rem; color:#64748b; margin-top:2px; }

    .btn-primary {
        display:inline-flex; align-items:center; gap:8px; padding:10px 20px;
        background:#3b5d50; color:#fff; border-radius:10px; font-size:0.875rem;
        font-weight:700; text-decoration:none; border:none; cursor:pointer;
        transition:all 0.2s; font-family:'Inter',sans-serif;
        box-shadow:0 4px 10px rgba(59,93,80,0.25);
    }
    .btn-primary:hover { background:#2d4a3e; transform:translateY(-1px); }
    .btn-primary svg { width:16px; height:16px; }

    .info-bar {
        background: linear-gradient(135deg, #3b5d50, #2d4a3e);
        border-radius:16px; padding:22px 28px; margin-bottom:24px;
        display:flex; align-items:center; justify-content:space-between; color:#fff;
        flex-wrap:wrap; gap:16px;
    }
    .info-bar-left h3 { font-size:1rem; font-weight:700; margin-bottom:4px; }
    .info-bar-left p  { font-size:0.8rem; opacity:0.75; }
    .info-count { font-size:2.5rem; font-weight:800; letter-spacing:-0.02em; }

    .filter-bar {
        background:#fff; border-radius:14px; padding:14px 20px; margin-bottom:20px;
        display:flex; gap:12px; align-items:center; flex-wrap:wrap;
        box-shadow:0 1px 4px rgba(0,0,0,0.05); border:1px solid #f1f5f9;
    }
    .search-wrap { flex:1; min-width:200px; position:relative; }
    .search-wrap svg { position:absolute; left:12px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:#94a3b8; }
    .search-input { width:100%; padding:10px 12px 10px 36px; border:1px solid #e2e8f0; border-radius:8px; font-size:0.875rem; font-family:'Inter',sans-serif; }
    .search-input:focus { outline:none; border-color:#3b5d50; box-shadow:0 0 0 3px rgba(59,93,80,0.1); }

    .table-card { background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.05); border:1px solid #f1f5f9; }
    .staff-table { width:100%; border-collapse:collapse; }
    .staff-table thead tr { background:#f8fafc; border-bottom:2px solid #f1f5f9; }
    .staff-table th { padding:13px 20px; font-size:0.72rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.05em; text-align:left; }
    .staff-table td { padding:16px 20px; font-size:0.875rem; color:#334155; border-bottom:1px solid #f8fafc; vertical-align:middle; }
    .staff-table tbody tr:last-child td { border-bottom:none; }
    .staff-table tbody tr:hover td { background:#f8fafc; }

    .user-cell { display:flex; align-items:center; gap:12px; }
    .user-avatar {
        width:40px; height:40px; border-radius:12px; flex-shrink:0;
        background:linear-gradient(135deg, #2563eb, #1d4ed8);
        color:#fff; display:flex; align-items:center; justify-content:center;
        font-weight:800; font-size:0.875rem;
    }
    .user-name  { font-weight:700; color:#1e293b; font-size:0.875rem; }
    .user-email { font-size:0.75rem; color:#94a3b8; }
    .join-date  { font-size:0.8rem; color:#64748b; }

    .actions-cell { display:flex; gap:8px; }
    .btn-edit {
        display:inline-flex; align-items:center; gap:5px; padding:7px 13px;
        background:#f0f7f4; color:#3b5d50; border-radius:8px; font-size:0.78rem;
        font-weight:700; border:none; cursor:pointer; transition:all 0.2s; font-family:'Inter',sans-serif;
    }
    .btn-edit:hover { background:#3b5d50; color:#fff; }
    .btn-edit svg { width:13px; height:13px; }
    .btn-del {
        display:inline-flex; align-items:center; gap:5px; padding:7px 13px;
        background:#fef2f2; color:#dc2626; border-radius:8px; font-size:0.78rem;
        font-weight:700; border:none; cursor:pointer; transition:all 0.2s; font-family:'Inter',sans-serif;
    }
    .btn-del:hover { background:#dc2626; color:#fff; }
    .btn-del svg { width:13px; height:13px; }

    .empty-state { text-align:center; padding:64px 24px; }
    .empty-state svg { width:56px; height:56px; color:#cbd5e1; margin:0 auto 16px; }
    .empty-state h3 { font-size:1.125rem; font-weight:700; color:#334155; margin-bottom:6px; }
    .empty-state p  { font-size:0.875rem; color:#94a3b8; margin-bottom:20px; }

    .pagination-wrap { padding:14px 20px; border-top:1px solid #f1f5f9; display:flex; align-items:center; justify-content:space-between; font-size:0.8rem; color:#64748b; }

    /* Modal */
    .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); backdrop-filter:blur(4px); z-index:200; align-items:center; justify-content:center; padding:24px; }
    .modal-overlay.open { display:flex; }
    .modal-box { background:#fff; border-radius:20px; padding:36px; width:100%; max-width:460px; box-shadow:0 24px 48px rgba(0,0,0,0.15); animation:modalIn 0.25s ease; }
    @keyframes modalIn { from{opacity:0;transform:scale(0.95) translateY(8px)} to{opacity:1;transform:scale(1) translateY(0)} }
    .modal-title { font-size:1.125rem; font-weight:800; color:#1e293b; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; }
    .btn-close { background:#f1f5f9; border:none; width:30px; height:30px; border-radius:8px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#64748b; }
    .btn-close:hover { background:#e2e8f0; }
    .btn-close svg { width:14px; height:14px; }
    .form-group { margin-bottom:16px; }
    .form-label { display:block; font-size:0.78rem; font-weight:700; color:#475569; margin-bottom:6px; text-transform:uppercase; letter-spacing:0.04em; }
    .form-control { width:100%; padding:11px 14px; border:1.5px solid #e2e8f0; border-radius:9px; font-size:0.9rem; font-family:'Inter',sans-serif; color:#1e293b; transition:border-color 0.2s; }
    .form-control:focus { outline:none; border-color:#3b5d50; box-shadow:0 0 0 3px rgba(59,93,80,0.1); }
    .form-hint { font-size:0.72rem; color:#94a3b8; margin-top:5px; }
    .form-actions { display:flex; gap:10px; margin-top:20px; }
    .btn-cancel { flex:1; padding:11px; background:#f1f5f9; color:#64748b; border:none; border-radius:9px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-cancel:hover { background:#e2e8f0; }
    .btn-save { flex:2; padding:11px; background:#3b5d50; color:#fff; border:none; border-radius:9px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; box-shadow:0 4px 10px rgba(59,93,80,0.25); }
    .btn-save:hover { background:#2d4a3e; }

    /* Delete Modal */
    .delete-box { background:#fff; border-radius:20px; padding:36px; width:100%; max-width:380px; text-align:center; animation:modalIn 0.25s ease; }
    .delete-icon { width:60px; height:60px; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; }
    .delete-icon svg { width:28px; height:28px; color:#dc2626; }
    .delete-title { font-size:1.1rem; font-weight:800; color:#1e293b; margin-bottom:8px; }
    .delete-desc  { font-size:0.875rem; color:#64748b; margin-bottom:20px; }
    .btn-del-confirm { flex:1; padding:11px; background:#dc2626; color:#fff; border:none; border-radius:9px; font-size:0.875rem; font-weight:700; cursor:pointer; font-family:'Inter',sans-serif; }
    .btn-del-confirm:hover { background:#b91c1c; }
</style>

<div class="page-header">
    <div>
        <h2>Petugas</h2>
        <p>Kelola akun petugas yang dapat mengakses sistem</p>
    </div>
    <button class="btn-primary" onclick="openAddModal()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Petugas
    </button>
</div>

{{-- Info Banner --}}
<div class="info-bar">
    <div class="info-bar-left">
        <h3>Total Petugas Aktif</h3>
        <p>Petugas dapat mengakses halaman pengelolaan pesanan</p>
    </div>
    <div class="info-count">{{ $totalStaff }}</div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route('admin.staff.index') }}" class="filter-bar">
    <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" name="search" class="search-input" placeholder="Cari nama atau email petugas..." value="{{ request('search') }}">
    </div>
    <button type="submit" style="padding:10px 18px;background:#3b5d50;color:#fff;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">Cari</button>
    @if(request('search'))
        <a href="{{ route('admin.staff.index') }}" style="padding:10px 14px;background:#f1f5f9;color:#64748b;border-radius:8px;font-size:0.875rem;font-weight:600;text-decoration:none;">Reset</a>
    @endif
</form>

{{-- Table --}}
<div class="table-card">
    @if($staffList->count())
        <div style="overflow-x:auto;">
            <table class="staff-table">
                <thead>
                    <tr>
                        <th>Petugas</th>
                        <th>Email</th>
                        <th>Total Pesanan Dikelola</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffList as $staff)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">{{ strtoupper(substr($staff->name, 0, 1)) }}</div>
                                    <span class="user-name">{{ $staff->name }}</span>
                                </div>
                            </td>
                            <td><span class="user-email" style="font-size:0.875rem;color:#334155;">{{ $staff->email }}</span></td>
                            <td>
                                <span style="font-weight:700;color:#3b5d50;">{{ $staff->orders_count }}</span>
                                <span style="color:#94a3b8;font-size:0.8rem;"> pesanan</span>
                            </td>
                            <td><span class="join-date">{{ $staff->created_at->format('d M Y') }}</span></td>
                            <td>
                                <div class="actions-cell">
                                    <button class="btn-edit"
                                        onclick="openEditModal({{ $staff->id }}, '{{ addslashes($staff->name) }}', '{{ addslashes($staff->email) }}')">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <button class="btn-del" onclick="openDeleteModal({{ $staff->id }}, '{{ addslashes($staff->name) }}')">
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
        @if($staffList->hasPages())
            <div class="pagination-wrap">
                <span>Menampilkan {{ $staffList->firstItem() }}–{{ $staffList->lastItem() }} dari {{ $staffList->total() }} petugas</span>
                {{ $staffList->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <h3>Belum ada petugas</h3>
            <p>Tambahkan akun petugas yang bisa mengelola pesanan</p>
            <button class="btn-primary" onclick="openAddModal()" style="margin:0 auto;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Petugas
            </button>
        </div>
    @endif
</div>

{{-- ADD / EDIT MODAL --}}
<div class="modal-overlay" id="staffModal">
    <div class="modal-box">
        <div class="modal-title">
            <span id="modalTitle">Tambah Petugas Baru</span>
            <button class="btn-close" onclick="closeModal()"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <form id="staffForm" method="POST" action="{{ route('admin.staff.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="inp_name" class="form-control" placeholder="Contoh: Budi Santoso" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="inp_email" class="form-control" placeholder="budi@furni.id" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="inp_pass" class="form-control" placeholder="Minimal 8 karakter">
                <p class="form-hint" id="passHint">Minimal 8 karakter</p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="delete-box">
        <div class="delete-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        <p class="delete-title">Hapus Akun Petugas?</p>
        <p class="delete-desc" id="deleteDesc">Tindakan ini tidak dapat diurungkan.</p>
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
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Petugas Baru';
    document.getElementById('staffForm').action = '{{ route('admin.staff.store') }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('inp_name').value = '';
    document.getElementById('inp_email').value = '';
    document.getElementById('inp_pass').value = '';
    document.getElementById('inp_pass').required = true;
    document.getElementById('passHint').textContent = 'Minimal 8 karakter';
    document.getElementById('staffModal').classList.add('open');
}
function openEditModal(id, name, email) {
    document.getElementById('modalTitle').textContent = 'Edit Akun Petugas';
    document.getElementById('staffForm').action = '/admin-petugas/staff/' + id;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('inp_name').value = name;
    document.getElementById('inp_email').value = email;
    document.getElementById('inp_pass').required = false;
    document.getElementById('passHint').textContent = 'Kosongkan jika tidak ingin mengubah password';
    document.getElementById('staffModal').classList.add('open');
}
function closeModal() { document.getElementById('staffModal').classList.remove('open'); }
function openDeleteModal(id, name) {
    document.getElementById('deleteDesc').textContent = 'Akun petugas "' + name + '" akan dihapus permanen.';
    document.getElementById('deleteForm').action = '/admin-petugas/staff/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() { document.getElementById('deleteModal').classList.remove('open'); }
document.getElementById('staffModal').addEventListener('click', e => { if(e.target===e.currentTarget) closeModal(); });
document.getElementById('deleteModal').addEventListener('click', e => { if(e.target===e.currentTarget) closeDeleteModal(); });
</script>
@endsection
