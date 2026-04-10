@extends('layouts.admin')

@section('content')
<style>
    .order-container {
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
        align-items: flex-start;
    }
    
    .block-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 24px;
    }
    
    .col-left {
        flex: 1;
        min-width: 60%;
    }
    
    .col-right {
        width: 320px;
        flex-shrink: 0;
    }
    
    @media (max-width: 1024px) {
        .col-right { width: 100%; }
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #3b5d50;
        margin-top: 0;
        margin-bottom: 24px;
        letter-spacing: 0.02em;
        border-bottom: 2px solid #f3f4f6;
        padding-bottom: 12px;
    }
    
    /* Back Button */
    .btn-back {
        display: inline-flex;
        align-items: center;
        padding: 10px 20px;
        background-color: #ffffff;
        color: #3b5d50;
        border: 1px solid #3b5d50;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        margin-bottom: 24px;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background-color: #3b5d50;
        color: #ffffff;
    }
    
    /* Items table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
    }
    .items-table th, .items-table td {
        padding: 16px 12px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
    }
    .items-table th {
        font-size: 0.85rem;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .items-table td {
        font-size: 0.95rem;
        color: #111827;
        font-weight: 500;
        vertical-align: middle;
    }
    .items-table tr:last-child td {
        border-bottom: none;
    }
    
    /* Summary rows */
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 0.95rem;
        color: #4b5563;
    }
    .summary-row.total {
        font-size: 1.25rem;
        font-weight: 700;
        color: #3b5d50;
        border-top: 2px solid #e5e7eb;
        margin-top: 12px;
        padding-top: 20px;
    }
    
    /* Info Card Details */
    .info-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 600;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #111827;
        margin-top: 0;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .product-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        background-color: #f3f4f6;
    }
</style>

<a href="{{ route('admin.dashboard') }}" class="btn-back">
    &larr; Kembali ke Dasbor
</a>

<div class="order-container">
    
    <div class="col-left">
        <!-- Item List -->
        <div class="block-card">
            <h2 class="section-title">Produk yang Dibeli</h2>
            <div style="overflow-x: auto;">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th colspan="2">Produk</th>
                            <th style="text-align: center;">Kuantitas</th>
                            <th style="text-align: right;">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td style="width: 60px; padding-right: 0;">
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="product-img">
                                @else
                                    <div class="product-img"></div>
                                @endif
                            </td>
                            <td>{{ $item->product->name ?? 'Produk Dihapus' }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}x</td>
                            <td style="text-align: right; font-weight: 700;">Rp. {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="block-card">
            <h2 class="section-title">Ringkasan Pembayaran</h2>
            <div style="max-width: 400px; margin-left: auto;">
                <div class="summary-row">
                    <span>Subtotal Produk</span>
                    <span style="font-weight: 600;">Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span>Biaya Pengiriman</span>
                    <span style="font-weight: 600;">Rp. 0</span>
                </div>
                <div class="summary-row total">
                    <span>Total Pembayaran</span>
                    <span>Rp. {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Sidebar -->
    <div class="col-right">
        
        <!-- Status Pesanan -->
        <div class="block-card">
            <h2 class="section-title">Informasi Pesanan</h2>
            
            <p class="info-label">Status Saat Ini</p>
            <p class="info-value">
                <span class="status-badge">{{ ucfirst(str_replace('-', ' ', $order->status)) }}</span>
            </p>
            
            <p class="info-label">Tanggal Pemesanan</p>
            <p class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</p>
            
            <p class="info-label">Metode Pembayaran</p>
            <p class="info-value">{{ strtoupper($order->payment_method ?? 'Bank Transfer') }}</p>
        </div>

        <!-- Info Pelanggan -->
        <div class="block-card">
            <h2 class="section-title">Data Pelanggan</h2>
            
            <p class="info-label">Nama Pelanggan</p>
            <p class="info-value">{{ $order->user->name ?? 'Guest' }}</p>
            
            <p class="info-label">Email Pelanggan</p>
            <p class="info-value">{{ $order->user->email ?? '-' }}</p>
            
            <!-- Address decode logic -->
            @php
                $address = json_decode($order->shipping_address, true);
            @endphp
            
            <p class="info-label">Alamat Pengiriman</p>
            @if($address)
            <p class="info-value" style="font-weight: 500; color: #4b5563;">
                <strong style="color: #111827;">{{ $address['fullName'] ?? '-' }}</strong><br>
                {{ $address['streetAddress'] ?? '-' }}<br>
                {{ $address['city'] ?? '-' }}, {{ $address['state'] ?? '-' }}<br>
                Kode Pos: {{ $address['postalCode'] ?? '-' }}<br>
                Telp: {{ $address['phone'] ?? '-' }}
            </p>
            @else
            <p class="info-value" style="font-weight: 500; color: #6b7280; font-style: italic;">
                Data alamat rusak atau tidak tersedia.
            </p>
            @endif
        </div>
        
    </div>
</div>
@endsection
