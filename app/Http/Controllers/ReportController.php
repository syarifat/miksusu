<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // Default filter: bulan ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // 1. Ambil data transaksi beserta relasinya
        $transactions = Transaction::with(['stall', 'items.product'])
            ->whereHas('stall', function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->latest()
            ->get();

        $totalPendapatan = $transactions->sum('total_harga');
        $totalTransaksi = $transactions->count();

        // 2. Rekapitulasi Produk Terjual (berdasarkan snapshot di transaction_items)
        $items = TransactionItem::with('product')
            ->whereHas('transaction.stall', function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->get();

        $rekapProduk = $items->groupBy(function($item) {
            return $item->product ? $item->product->nama : 'Produk Dihapus';
        })->map(function($group) {
            return [
                'qty' => $group->sum('qty'),
                'subtotal' => $group->sum('subtotal')
            ];
        })->sortByDesc('qty');

        return view('reports.sales', compact(
            'transactions', 'totalPendapatan', 'totalTransaksi', 'rekapProduk', 'startDate', 'endDate'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Ambil filter tanggal dari URL (sama seperti di halaman web)
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query data (sama persis dengan yang di method sales)
        $transactions = Transaction::with(['stall', 'items.product'])
            ->whereHas('stall', function($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal', [$startDate, $endDate]);
            })
            ->latest()
            ->get();

        $totalPendapatan = $transactions->sum('total_harga');
        $totalTransaksi = $transactions->count();

        // Siapkan data untuk dilempar ke view PDF
        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactions' => $transactions,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
        ];

        // Load view khusus PDF dan download hasilnya
        $pdf = Pdf::loadView('reports.pdf', $data);
        
        // Nama file dinamis
        $namaFile = 'Laporan-Miksusu-' . Carbon::parse($startDate)->format('d-M-Y') . '.pdf';
        
        return $pdf->download($namaFile);
    }
}