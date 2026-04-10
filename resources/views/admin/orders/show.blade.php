@extends('layouts.admin')
@php $page_title = 'Detail Pesanan'; @endphp

@section('content')
    <style>
        .order-detail-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            margin-bottom: 40px;
            font-family: 'Inter', sans-serif;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            margin-bottom: 24px;
            color: #ffffff;
            background-color: #3b5d50;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            box-shadow: 0 4px 6px -1px rgba(59, 93, 80, 0.2), 0 2px 4px -1px rgba(59, 93, 80, 0.1);
        }

        .btn-back:hover {
            background-color: #2c463c;
            transform: translateY(-1px);
            box-shadow: 0 6px 8px -1px rgba(59, 93, 80, 0.3), 0 4px 6px -1px rgba(59, 93, 80, 0.2);
            color: #ffffff;
        }

        .order-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            border: 1px solid #f3f4f6;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f9fafe;
            padding-bottom: 24px;
            margin-bottom: 32px;
        }

        .header-left {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .order-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #3b5d50;
            letter-spacing: -0.025em;
            margin: 0;
        }
        
        .order-date {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.belum-bayar {
            background-color: #fce8e8;
            color: #c81e1e;
        }

        .status-badge.paid, .status-badge.selesai {
            background-color: #def7ec;
            color: #03543f;
        }

        .status-badge.pending, .status-badge.dikemas {
            background-color: #eff6ff;
            color: #2563eb;
        }

        .status-badge.menunggu-konfirmasi, .status-badge.dikonfirmasi {
            background-color: #faf5ff;
            color: #7c3aed;
        }
        
        .status-badge.dikirim {
            background-color: #e1eff6;
            color: #1e40af;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .info-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .info-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: #3b5d50;
            border-radius: 4px 0 0 4px;
        }

        .info-card.yellow-accent::before {
            background-color: #f9bf29;
        }

        .info-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #111827;
            margin-top: 0;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #9ca3af;
            letter-spacing: 0.05em;
        }

        .info-value {
            font-size: 0.95rem;
            color: #1f2937;
            font-weight: 500;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: #3b5d50;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #f3f4f6;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-container {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            margin-bottom: 32px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }

        .items-table th {
            background-color: #f8fafc;
            text-align: left;
            padding: 16px 20px;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table td {
            padding: 20px;
            font-size: 0.95rem;
            color: #111827;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table tr:hover td {
            background-color: #f8fafc;
        }

        .product-name {
            font-weight: 600;
            color: #3b5d50;
        }

        .summary-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .summary-card {
            background-color: #ffffff;
            border-radius: 16px;
            padding: 28px 32px;
            border: 1px solid #e5e7eb;
            min-width: 380px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            background-image: linear-gradient(to bottom right, #ffffff, #fdfdfd);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            font-size: 0.95rem;
            color: #6b7280;
        }

        .summary-row.grand-total {
            font-size: 1.5rem;
            font-weight: 800;
            color: #3b5d50;
            border-top: 2px dashed #e5e7eb;
            padding-top: 24px;
            margin-top: 24px;
            margin-bottom: 0;
        }
        
        .grand-total-label {
            color: #111827;
            font-size: 1.125rem;
            font-weight: 700;
        }

        .admin-actions-card {
            background-color: #f8fafc;
            border-radius: 16px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            margin-top: 40px;
        }

        .admin-actions-card h3 {
            font-size: 1.25rem;
            color: #1e293b;
            margin-bottom: 24px;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1e293b;
            background-color: #ffffff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b5d50;
            box-shadow: 0 0 0 3px rgba(59, 93, 80, 0.1);
        }

        .btn-submit {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #3b5d50;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background-color: #2c463c;
        }

        .btn-print {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background-color: #ffffff;
            color: #3b5d50;
            font-weight: 600;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-print:hover {
            background-color: #f1f5f9;
            border-color: #94a3b8;
        }

        .actions-row {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            flex-wrap: wrap;
        }
        
        .flex-1 {
            flex: 1;
            min-width: 200px;
        }
        
        @media print {
            .btn-back, .admin-actions-card {
                display: none !important;
            }
            .order-card {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            body { background: white; }
        }
        
        @media (max-width: 768px) {
            .order-card {
                padding: 24px;
            }
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .summary-card {
                min-width: 100%;
            }
        }
    </style>

    <div class="order-detail-wrapper">
        <a href="{{ route('admin.orders.index') }}" class="btn-back">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Pesanan
        </a>

        <div class="order-card">
            <div class="header-section">
                <div class="header-left">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <h1 class="order-title">Pesanan #{{ $order->id }}</h1>
                        @if($order->status === 'selesai')
                            <a href="{{ route('admin.orders.receipt', $order->id) }}" class="btn-print" style="padding: 7px 14px; font-size: 0.75rem; text-decoration: none;">
                                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Download Struk
                            </a>
                        @endif
                    </div>
                    <span class="order-date">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $order->created_at->format('d F Y, H:i') }} WIB
                    </span>
                </div>
                <span class="status-badge {{ strtolower($order->status) }}">
                    @if($order->status === 'menunggu-konfirmasi') Menunggu Konfirmasi
                    @elseif($order->status === 'dikonfirmasi') Konfirmasi
                    @else {{ str_replace('-', ' ', ucfirst($order->status)) }}
                    @endif
                </span>
            </div>

            <div class="info-grid">
                <!-- Info Pelanggan -->
                <div class="info-card">
                    <h3>
                        <svg style="width: 22px; height: 22px; color: #3b5d50;" fill="none" stroke="currentColor" viewBox="0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Pemesan
                    </h3>
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ $order->user->name ?? 'Guest' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $order->user->email ?? '-' }}</span>
                    </div>
                </div>

                <!-- Info Pengiriman -->
                <div class="info-card yellow-accent">
                    <h3>
                        <svg style="width: 22px; height: 22px; color: #f9bf29;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Tujuan Pengiriman
                    </h3>
                    @if($order->address)
                        <div class="info-row">
                            <span class="info-label">Penerima</span>
                            <span class="info-value">{{ $order->address->recipient_name }} ({{ $order->address->phone_number }})</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Alamat Lengkap</span>
                            <span class="info-value" style="line-height: 1.6;">
                                {{ $order->address->full_address }}
                            </span>
                        </div>
                    @else
                        <div class="info-row">
                            <span class="info-value" style="color: #6b7280; font-style: italic;">Tidak ada info alamat pengiriman</span>
                        </div>
                    @endif
                </div>

                <!-- Info Kurir & Pembayaran -->
                <div class="info-card">
                    <h3>
                        <svg style="width: 22px; height: 22px; color: #3b5d50;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pengiriman & Pembayaran
                    </h3>
                    <div class="info-row">
                        <span class="info-label">Kurir</span>
                        <span class="info-value">{{ $order->shipping_courier ? strtoupper($order->shipping_courier) : '-' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nomor Resi</span>
                        <span class="info-value" style="font-family: monospace; font-size: 1.05rem;">{{ $order->tracking_number ?? 'Belum tersedia' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Metode Pembayaran</span>
                        <span class="info-value">{{ $order->payment_bank ? strtoupper($order->payment_bank) : '-' }}</span>
                    </div>
                </div>
            </div>

            <h2 class="section-title">
                <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Daftar Produk
            </h2>
            
            <div class="table-container">
                <div style="overflow-x: auto;">
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th style="text-align: right;">Harga Satuan</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: right;">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 56px; height: 56px; background-color: #f8fafc; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #f1f5f9; flex-shrink: 0;">
                                                @if($item->product && $item->product->image_url)
                                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover; mix-blend-mode: multiply;">
                                                @else
                                                    <svg style="width: 24px; height: 24px; color: #d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                @endif
                                            </div>
                                            <span class="product-name">{{ $item->product->name ?? 'Produk Dihapus' }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right; font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                    </td>
                                    <td style="text-align: center; font-weight: 600; font-size: 1.05rem;">
                                        x{{ $item->quantity }}
                                    </td>
                                    <td style="text-align: right; font-weight: 700; color: #3b5d50; font-variant-numeric: tabular-nums;">
                                        Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="summary-section">
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Total Harga ({{ $order->items->sum('quantity') }} items)</span>
                        <span style="font-weight: 600; color: #111827;">Rp {{ number_format($order->items->sum(function($item) { return $item->price_at_purchase * $item->quantity; }), 0, ',', '.') }}</span>
                    </div>
                    <!-- Jika ada Biaya admin/ongkir dll -->
                    
                    <div class="summary-row grand-total">
                        <span class="grand-total-label">Total Belanja</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Aksi Admin dihapus untuk Petugas sesuai permintaan --}}
            
        </div>
    </div>
@endsection
