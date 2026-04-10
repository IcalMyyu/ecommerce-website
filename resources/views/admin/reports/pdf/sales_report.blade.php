<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.5; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #3b5d50; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #3b5d50; font-size: 24px; }
        .header p { margin: 5px 0; color: #666; }
        
        .summary-box { margin-bottom: 30px; width: 100%; border-collapse: collapse; }
        .summary-box td { padding: 15px; border: 1px solid #eee; background: #fcfcfc; }
        .label { font-size: 10px; font-weight: bold; color: #999; text-transform: uppercase; display: block; margin-bottom: 5px; }
        .value { font-size: 18px; font-weight: bold; color: #333; }

        .section-title { font-size: 14px; font-weight: bold; margin-bottom: 15px; border-left: 4px solid #3b5d50; padding-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { background: #f8f8f8; color: #555; text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .footer { text-align: center; font-size: 10px; color: #aaa; margin-top: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FURNI | LAPORAN PENJUALAN</h1>
        <p>Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>
        <p>Dicetak pada: {{ now()->format('d M Y, H:i') }}</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <span class="label">Total Pendapatan</span>
                <span class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </td>
            <td>
                <span class="label">Total Transaksi</span>
                <span class="value">{{ $completedOrdersCount }} Transaksi</span>
            </td>
            <td>
                <span class="label">Rata-rata Penjualan</span>
                <span class="value">Rp {{ $completedOrdersCount > 0 ? number_format($totalRevenue / $completedOrdersCount, 0, ',', '.') : 0 }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Produk Terlaris</div>
    <table>
        <thead>
            <tr>
                <th width="50">No</th>
                <th>Nama Produk</th>
                <th width="100">Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProducts as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->total_sold }} unit</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Transaksi Terkini</div>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini dibuat secara otomatis oleh sistem furni. Terimakasih atas bisnis Anda.
    </div>
</body>
</html>
