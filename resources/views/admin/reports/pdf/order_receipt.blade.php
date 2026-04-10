<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi</title>
    <style>
        body { font-family: sans-serif; color: #1a1a1a; line-height: 1.4; font-size: 11px; margin: 0; padding: 0; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; background: #fff; }
        .header { display: table; width: 100%; border-bottom: 2px solid #3b5d50; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 28px; font-weight: 900; color: #3b5d50; }
        .status { text-align: right; }
        .status-badge { background: #f0fdf4; color: #16a34a; padding: 5px 15px; border-radius: 20px; font-weight: bold; text-transform: uppercase; }

        .info-table { width: 100%; display: table; margin-bottom: 30px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; }
        .info-label { font-size: 9px; color: #999; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
        .info-value { font-size: 11px; font-weight: bold; }

        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .items-table th { background: #3b5d50; color: #fff; text-align: left; padding: 10px; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .totals-table { width: 100%; display: table; }
        .totals-row { display: table-row; }
        .totals-label { display: table-cell; text-align: right; padding: 5px 10px; font-weight: bold; }
        .totals-value { display: table-cell; text-align: right; padding: 5px 0; width: 120px; }
        .grand-total { font-size: 16px; color: #3b5d50; border-top: 2px solid #eee; }

        .terms { margin-top: 50px; font-size: 9px; color: #777; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table style="width: 100%;">
            <tr>
                <td class="logo">Furni.</td>
                <td style="text-align: right;">
                    <span class="status-badge">PESANAN SELESAI</span>
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px; margin-bottom: 10px; font-size: 14px; font-weight: bold; color: #3b5d50;">STRUK TRANSAKSI</div>

        <table style="width: 100%; margin-bottom: 30px;">
            <tr>
                <td style="width: 50%; vertical-align: top;">
                    <div class="info-label">Diterbitkan Untuk:</div>
                    <div class="info-value">{{ $order->user->name }}</div>
                    <div class="info-value">{{ $order->user->email }}</div>
                    <div style="margin-top: 8px;">
                        <span class="info-label">Alamat Pengiriman:</span><br>
                        {{ $order->address->recipient_name }} ({{ $order->address->phone_number }})<br>
                        {{ $order->address->full_address }}
                    </div>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <div class="info-label">ID Transaksi:</div>
                    <div class="info-value" style="font-family: monospace;">{{ $order->id }}</div>
                    <div class="info-label" style="margin-top: 10px;">Tanggal Pesanan:</div>
                    <div class="info-value">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    <div class="info-label" style="margin-top: 10px;">Metode Pembayaran:</div>
                    <div class="info-value">{{ strtoupper($order->payment_bank) }} Transfer</div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Deskripsi Produk</th>
                    <th style="text-align: center;">Kuantitas</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div style="font-weight: bold;">{{ $item->product->name }}</div>
                        </td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                        <td style="text-align: right;">Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table style="width: 100%;">
            <tr>
                <td style="width: 60%;"></td>
                <td>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: right; padding: 5px;">Subtotal:</td>
                            <td style="text-align: right; padding: 5px;">Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding: 5px;">Ongkos Kirim:</td>
                            <td style="text-align: right; padding: 5px;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td style="text-align: right; padding: 10px 5px; font-weight: bold; font-size: 14px;">Grand Total:</td>
                            <td style="text-align: right; padding: 10px 5px; font-weight: bold; font-size: 14px; color: #3b5d50;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="terms">
            <strong>Catatan:</strong>
            <p>Bukti ini sah secara sistem dan tidak memerlukan tanda tangan basah. Harap simpan struk ini sebagai bukti pembelian yang sah dari Furni.</p>
        </div>
    </div>
</body>
</html>
