<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Miksusu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #b91c1c; /* Merah Miksusu */
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #b91c1c;
            font-size: 24px;
            letter-spacing: 2px;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .summary-box {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box td {
            padding: 10px;
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            text-align: center;
            width: 50%;
        }
        .summary-box h3 {
            margin: 0 0 5px 0;
            color: #b91c1c;
            font-size: 18px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #b91c1c;
            color: white;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #777;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>MIKSUSU.</h1>
        <p>Laporan Penjualan</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    <table class="summary-box">
        <tr>
            <td>
                <p style="margin:0; font-size:10px; color:#555;">TOTAL PENDAPATAN</p>
                <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </td>
            <td>
                <p style="margin:0; font-size:10px; color:#555;">TOTAL TRANSAKSI</p>
                <h3>{{ $totalTransaksi }} Nota</h3>
            </td>
        </tr>
    </table>

    <h3 style="margin-bottom: 10px; font-size: 14px;">Rincian Transaksi:</h3>
    
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Tanggal & Lapak</th>
                <th width="15%">Tipe</th>
                <th width="35%">Item Terjual / Nama Titipan</th>
                <th width="20%" class="text-right">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $trx)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $trx->stall->tempat }}</strong><br>
                    <span style="font-size: 10px; color:#666;">{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</span>
                </td>
                <td>
                    {{ strtoupper($trx->tipe) }}
                </td>
                <td>
                    @if($trx->tipe == 'preorder')
                        <span style="font-size: 10px; color:#b91c1c;">Titipan: {{ $trx->nama_titipan }}</span><br>
                    @endif
                    <ul style="margin: 0; padding-left: 15px; font-size: 10px;">
                        @foreach($trx->items as $item)
                            <li>{{ $item->product ? $item->product->nama : 'Produk Dihapus' }} (x{{ $item->qty }})</li>
                        @endforeach
                    </ul>
                </td>
                <td class="text-right">
                    <strong>{{ number_format($trx->total_harga, 0, ',', '.') }}</strong>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada transaksi di rentang tanggal ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Admin Miksusu pada {{ now()->translatedFormat('d F Y H:i') }}
    </div>

</body>
</html>