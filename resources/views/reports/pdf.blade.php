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
            border-bottom: 2px solid #b91c1c;
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
        .header .stall-name {
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        .filter-info {
            background-color: #fef2f2;
            border: 1px solid #fca5a5;
            border-radius: 4px;
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 11px;
        }
        .filter-info span {
            font-weight: bold;
            color: #b91c1c;
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
        h3.section-title {
            margin-bottom: 10px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
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
        table.rekap-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            margin-bottom: 20px;
        }
        table.rekap-table th, table.rekap-table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            text-align: left;
            font-size: 11px;
        }
        table.rekap-table th {
            background-color: #374151;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
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
        @if($mode === 'lapak' && $selectedStall)
            <p>Laporan Penjualan — Per Lapak</p>
            <p class="stall-name">{{ $selectedStall->tempat }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($selectedStall->tanggal)->translatedFormat('d F Y') }}</p>
        @else
            <p>Laporan Penjualan</p>
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
        @endif
    </div>

    {{-- Filter Info --}}
    <div class="filter-info">
        @if($mode === 'lapak' && $selectedStall)
            <span>Mode:</span> Per Lapak |
            <span>Lapak:</span> {{ $selectedStall->tempat }} |
            <span>Tanggal:</span> {{ \Carbon\Carbon::parse($selectedStall->tanggal)->format('d/m/Y') }} |
            <span>Status:</span> {{ ucfirst($selectedStall->status) }}
        @else
            <span>Mode:</span> Rentang Tanggal |
            <span>Dari:</span> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} |
            <span>Sampai:</span> {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        @endif
    </div>

    {{-- Ringkasan --}}
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

    {{-- Rekapitulasi Produk --}}
    @if(count($rekapProduk) > 0)
    <h3 class="section-title">Rekapitulasi Produk Terjual:</h3>
    <table class="rekap-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Nama Produk</th>
                <th width="20%" class="text-center">Qty Terjual</th>
                <th width="30%" class="text-right">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $totalQty = 0; @endphp
            @foreach($rekapProduk as $nama => $data)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td><strong>{{ $nama }}</strong></td>
                <td class="text-center">{{ $data['qty'] }}</td>
                <td class="text-right">{{ number_format($data['subtotal'], 0, ',', '.') }}</td>
            </tr>
            @php $totalQty += $data['qty']; @endphp
            @endforeach
            <tr style="background-color: #fef2f2; font-weight: bold;">
                <td colspan="2" class="text-right">TOTAL</td>
                <td class="text-center">{{ $totalQty }}</td>
                <td class="text-right">{{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    {{-- Detail Transaksi --}}
    <h3 class="section-title">Rincian Transaksi:</h3>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Tanggal & Lapak</th>
                <th width="10%">Tipe</th>
                <th width="35%">Item Terjual / Nama Titipan</th>
                <th width="25%" class="text-right">Total (Rp)</th>
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
                <td colspan="5" style="text-align: center; padding: 20px;">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Admin Miksusu pada {{ now()->translatedFormat('d F Y H:i') }}
    </div>

</body>
</html>