@extends('layouts.admin')
@php $page_title = 'Manajemen Produk'; @endphp

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

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: #3b5d50;
        color: #fff;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 4px 10px rgba(59,93,80,0.25);
    }
    .btn-primary:hover { background: #2d4a3e; transform: translateY(-1px); }
    .btn-primary svg { width: 16px; height: 16px; }

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
    .search-wrap { flex: 1; min-width: 200px; position: relative; }
    .search-wrap svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #94a3b8; }
    .search-input {
        width: 100%;
        padding: 10px 12px 10px 36px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.875rem;
        font-family: 'Inter', sans-serif;
    }
    .search-input:focus { outline: none; border-color: #3b5d50; box-shadow: 0 0 0 3px rgba(59,93,80,0.1); }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
        margin-bottom: 32px;
    }
    .product-card {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        border: 1px solid #f1f5f9;
        transition: all 0.25s;
    }
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.1);
    }
    .product-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f8fafc;
        mix-blend-mode: multiply;
    }
    .product-img-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .product-img-placeholder svg { width: 48px; height: 48px; color: #cbd5e1; }

    .product-body { padding: 18px 20px; }
    .product-name {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-price {
        font-size: 1.1rem;
        font-weight: 800;
        color: #3b5d50;
        margin-bottom: 12px;
    }
    .product-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .stock-ok { background: #f0fdf4; color: #16a34a; }
    .stock-low { background: #fffbeb; color: #d97706; }
    .stock-empty { background: #fef2f2; color: #dc2626; }
    .sold-count { font-size: 0.78rem; color: #94a3b8; font-weight: 500; }

    .product-actions {
        display: flex;
        gap: 8px;
    }
    .btn-edit {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 9px 14px;
        background: #f0f7f4;
        color: #3b5d50;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .btn-edit:hover { background: #3b5d50; color: #fff; }
    .btn-edit svg { width: 13px; height: 13px; }
    .btn-delete {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 9px 12px;
        background: #fef2f2;
        color: #dc2626;
        border-radius: 8px;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Inter', sans-serif;
    }
    .btn-delete:hover { background: #dc2626; color: #fff; }
    .btn-delete svg { width: 14px; height: 14px; }

    .empty-state {
        text-align: center;
        padding: 80px 24px;
        background: #fff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
    }
    .empty-state svg { width: 56px; height: 56px; color: #cbd5e1; margin: 0 auto 16px; }
    .empty-state h3 { font-size: 1.125rem; font-weight: 700; color: #334155; margin-bottom: 6px; }
    .empty-state p { font-size: 0.875rem; color: #94a3b8; margin-bottom: 24px; }

    /* Modal Overlay */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 100;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
        background: #fff;
        border-radius: 20px;
        padding: 36px;
        width: 100%;
        max-width: 520px;
        box-shadow: 0 24px 48px rgba(0,0,0,0.15);
        animation: modalIn 0.25s ease;
        max-height: 90vh;
        overflow-y: auto;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .modal-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .btn-close-modal {
        background: #f1f5f9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        transition: all 0.2s;
    }
    .btn-close-modal:hover { background: #e2e8f0; color: #1e293b; }
    .btn-close-modal svg { width: 16px; height: 16px; }

    .form-group { margin-bottom: 18px; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 700; color: #475569; margin-bottom: 7px; text-transform: uppercase; letter-spacing: 0.04em; }
    .form-control {
        width: 100%;
        padding: 11px 14px;
        border: 1.5px solid #e2e8f0;
        border-radius: 9px;
        font-size: 0.9rem;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        transition: border-color 0.2s;
        background: #fff;
    }
    .form-control:focus { outline: none; border-color: #3b5d50; box-shadow: 0 0 0 3px rgba(59,93,80,0.1); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .form-actions { display: flex; gap: 10px; margin-top: 24px; }
    .btn-cancel {
        flex: 1;
        padding: 12px;
        background: #f1f5f9;
        color: #64748b;
        border: none;
        border-radius: 9px;
        font-size: 0.875rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: #e2e8f0; color: #334155; }
    .btn-save {
        flex: 2;
        padding: 12px;
        background: #3b5d50;
        color: #fff;
        border: none;
        border-radius: 9px;
        font-size: 0.875rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
        box-shadow: 0 4px 10px rgba(59,93,80,0.25);
    }
    .btn-save:hover { background: #2d4a3e; }

    /* Delete Confirm Modal */
    .delete-modal-box {
        background: #fff;
        border-radius: 20px;
        padding: 36px;
        width: 100%;
        max-width: 400px;
        text-align: center;
        box-shadow: 0 24px 48px rgba(0,0,0,0.15);
        animation: modalIn 0.25s ease;
    }
    .delete-icon {
        width: 64px;
        height: 64px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .delete-icon svg { width: 30px; height: 30px; color: #dc2626; }
    .delete-title { font-size: 1.125rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .delete-desc { font-size: 0.875rem; color: #64748b; margin-bottom: 24px; }
    .delete-actions { display: flex; gap: 10px; }
    .btn-delete-confirm {
        flex: 1;
        padding: 12px;
        background: #dc2626;
        color: #fff;
        border: none;
        border-radius: 9px;
        font-size: 0.875rem;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all 0.2s;
    }
    .btn-delete-confirm:hover { background: #b91c1c; }
</style>

<div class="page-header">
    <div>
        <h2>Manajemen Produk</h2>
        <p>{{ $products->total() }} produk terdaftar</p>
    </div>
    <button class="btn-primary" onclick="openAddModal()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah Produk
    </button>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('admin.products.index') }}" class="filter-bar">
    <div class="search-wrap">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" class="search-input" placeholder="Cari nama produk..." value="{{ request('search') }}">
    </div>
    <select name="stock" class="search-input" style="flex:0;width:auto;padding-left:12px;" onchange="this.form.submit()">
        <option value="">Semua Stok</option>
        <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>Stok Rendah (≤10)</option>
        <option value="empty" {{ request('stock') == 'empty' ? 'selected' : '' }}>Habis</option>
    </select>
    <button type="submit" style="padding:10px 18px;background:#3b5d50;color:#fff;border:none;border-radius:8px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
        Cari
    </button>
</form>

{{-- Products Grid --}}
@if($products->count())
    <div class="products-grid">
        @foreach($products as $product)
            <div class="product-card">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" class="product-img" alt="{{ $product->name }}">
                @else
                    <div class="product-img-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="product-body">
                    <p class="product-name">{{ $product->name }}</p>
                    <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="product-meta">
                        @if($product->stock == 0)
                            <span class="stock-badge stock-empty">● Habis</span>
                        @elseif($product->stock <= 10)
                            <span class="stock-badge stock-low">● Stok: {{ $product->stock }}</span>
                        @else
                            <span class="stock-badge stock-ok">● Stok: {{ $product->stock }}</span>
                        @endif
                        <span class="sold-count">Terjual {{ $product->sold_count ?? 0 }}x</span>
                    </div>
                    <div class="product-actions">
                        <button class="btn-edit"
                            onclick="openEditModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, {{ $product->stock }}, '{{ addslashes($product->description ?? '') }}', '{{ addslashes($product->image_url ?? '') }}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                        <button class="btn-delete" onclick="openDeleteModal({{ $product->id }}, '{{ addslashes($product->name) }}')">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div style="display:flex;justify-content:center;margin-top:8px;">
        {{ $products->appends(request()->query())->links() }}
    </div>
@else
    <div class="empty-state">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
        <h3>Belum ada produk</h3>
        <p>Mulai tambahkan produk furnitur pertama Anda</p>
        <button class="btn-primary" onclick="openAddModal()" style="margin:0 auto;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </button>
    </div>
@endif

{{-- ADD / EDIT MODAL --}}
<div class="modal-overlay" id="productModal">
    <div class="modal-box">
        <div class="modal-title">
            <span id="modalTitleText">Tambah Produk Baru</span>
            <button class="btn-close-modal" onclick="closeModal()">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="productForm" method="POST" action="{{ route('admin.products.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" id="input_name" class="form-control" placeholder="Contoh: Kursi Minimalis Oslo" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" name="price" id="input_price" class="form-control" placeholder="1500000" required min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" id="input_stock" class="form-control" placeholder="50" required min="0">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">URL Gambar</label>
                <input type="text" name="image_url" id="input_image_url" class="form-control" placeholder="https://...">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" id="input_description" class="form-control" rows="3" placeholder="Deskripsi singkat produk..."></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batalkan</button>
                <button type="submit" class="btn-save">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

{{-- DELETE MODAL --}}
<div class="modal-overlay" id="deleteModal">
    <div class="delete-modal-box">
        <div class="delete-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <p class="delete-title">Hapus Produk?</p>
        <p class="delete-desc" id="deleteDesc">Tindakan ini tidak dapat diurungkan.</p>
        <div class="delete-actions">
            <button class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="flex:1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete-confirm" style="width:100%;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitleText').textContent = 'Tambah Produk Baru';
    document.getElementById('productForm').action = '{{ route('admin.products.store') }}';
    document.getElementById('formMethod').value = 'POST';
    document.getElementById('input_name').value = '';
    document.getElementById('input_price').value = '';
    document.getElementById('input_stock').value = '';
    document.getElementById('input_description').value = '';
    document.getElementById('input_image_url').value = '';
    document.getElementById('productModal').classList.add('open');
}

function openEditModal(id, name, price, stock, description, imageUrl) {
    document.getElementById('modalTitleText').textContent = 'Edit Produk';
    document.getElementById('productForm').action = '/admin-petugas/products/' + id;
    document.getElementById('formMethod').value = 'PUT';
    document.getElementById('input_name').value = name;
    document.getElementById('input_price').value = price;
    document.getElementById('input_stock').value = stock;
    document.getElementById('input_description').value = description;
    document.getElementById('input_image_url').value = imageUrl;
    document.getElementById('productModal').classList.add('open');
}

function closeModal() {
    document.getElementById('productModal').classList.remove('open');
}

function openDeleteModal(id, name) {
    document.getElementById('deleteDesc').textContent = 'Produk "' + name + '" akan dihapus permanen.';
    document.getElementById('deleteForm').action = '/admin-petugas/products/' + id;
    document.getElementById('deleteModal').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}

// Close modal on overlay click
document.getElementById('productModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});
</script>
@endsection
