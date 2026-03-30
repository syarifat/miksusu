<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - Miksusu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ef4444;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #b91c1c;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .summary-wrapper {
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-box {
            display: inline-block;
            width: 30%;
            padding: 15px;
            border-radius: 8px;
            margin-right: 2%;
            box-sizing: border-box;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }
        .summary-box:last-child {
            margin-right: 0;
        }
        .summary-title {
            font-size: 11px;
            text-transform: uppercase;
            color: #6b7280;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 18px;
            font-weight: bold;
        }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        
        .type-badge {
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-pemasukan {
            background-color: #dcfce7;
            color: #16a34a;
        }
        .badge-pengeluaran {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Miksusu POS System &middot; Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <!-- Summary Box -->
    <div class="summary-wrapper">
        <div class="summary-box" style="border-bottom: 3px solid #16a34a;">
            <span class="summary-title">Pemasukan</span>
            <span class="summary-value text-green">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</span>
        </div>
        
        <div class="summary-box" style="border-bottom: 3px solid #dc2626;">
            <span class="summary-title">Pengeluaran</span>
            <span class="summary-value text-red">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
        </div>
        
        <div class="summary-box" style="border-bottom: 3px solid #2563eb;">
            <span class="summary-title">Saldo Bersih</span>
            <span class="summary-value text-blue">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Riwayat Transaksi -->
    <h3 style="margin-bottom: 10px; color: #1f2937;">Rincian Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Kategori</th>
                <th width="35%">Keterangan</th>
                <th width="15%">PIC</th>
                <th width="15%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($finances as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d/m/Y') }}</td>
                <td>
                    <span class="type-badge {{ $item->tipe == 'pemasukan' ? 'badge-pemasukan' : 'badge-pengeluaran' }}">
                        {{ $item->kategori }}
                    </span>
                </td>
                <td>{{ $item->keterangan }}</td>
                <td>{{ $item->pic }}</td>
                <td class="text-right font-bold {{ $item->tipe == 'pemasukan' ? 'text-green' : 'text-red' }}">
                    {{ $item->tipe == 'pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada catatan transaksi keuangan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini di-generate secara otomatis oleh Sistem POS Miksusu.</p>
        <p>&copy; {{ date('Y') }} Miksusu &middot; Pengembangan oleh SAT Project</p>
    </div>

</body>
</html>
