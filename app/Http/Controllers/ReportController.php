<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Build query berdasarkan mode filter: 'tanggal' atau 'lapak'
     */
    private function buildQuery(Request $request)
    {
        $mode = $request->input('mode', 'tanggal');
        $stallId = null;
        $startDate = null;
        $endDate = null;
        $selectedStall = null;

        if ($mode === 'lapak') {
            $stallId = $request->input('stall_id');
            $selectedStall = $stallId ? Stall::find($stallId) : null;

            $transactionQuery = Transaction::with(['stall', 'items.product'])
                ->where('stall_id', $stallId)
                ->latest();

            $itemQuery = TransactionItem::with('product')
                ->whereHas('transaction', function($q) use ($stallId) {
                    $q->where('stall_id', $stallId);
                });

            if ($selectedStall) {
                $startDate = $selectedStall->tanggal;
                $endDate = $selectedStall->tanggal;
            }
        } else {
            $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

            $transactionQuery = Transaction::with(['stall', 'items.product'])
                ->whereHas('stall', function($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                })
                ->latest();

            $itemQuery = TransactionItem::with('product')
                ->whereHas('transaction.stall', function($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal', [$startDate, $endDate]);
                });
        }

        return compact('transactionQuery', 'itemQuery', 'startDate', 'endDate', 'mode', 'stallId', 'selectedStall');
    }

    public function sales(Request $request)
    {
        $built = $this->buildQuery($request);

        $transactions = $built['transactionQuery']->get();
        $totalPendapatan = $transactions->sum('total_harga');
        $totalTransaksi = $transactions->count();

        $items = $built['itemQuery']->get();
        $rekapProduk = $items->groupBy(function($item) {
            return $item->product ? $item->product->nama : 'Produk Dihapus';
        })->map(function($group) {
            return [
                'qty' => $group->sum('qty'),
                'subtotal' => $group->sum('subtotal')
            ];
        })->sortByDesc('qty');

        $stalls = Stall::orderBy('tanggal', 'desc')->get();

        return view('reports.sales', [
            'transactions' => $transactions,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
            'rekapProduk' => $rekapProduk,
            'startDate' => $built['startDate'],
            'endDate' => $built['endDate'],
            'mode' => $built['mode'],
            'stalls' => $stalls,
            'stallId' => $built['stallId'],
            'selectedStall' => $built['selectedStall'],
        ]);
    }

    public function exportPdf(Request $request)
    {
        $built = $this->buildQuery($request);

        $transactions = $built['transactionQuery']->get();
        $totalPendapatan = $transactions->sum('total_harga');
        $totalTransaksi = $transactions->count();

        $items = $built['itemQuery']->get();
        $rekapProduk = $items->groupBy(function($item) {
            return $item->product ? $item->product->nama : 'Produk Dihapus';
        })->map(function($group) {
            return [
                'qty' => $group->sum('qty'),
                'subtotal' => $group->sum('subtotal')
            ];
        })->sortByDesc('qty');

        $data = [
            'startDate' => $built['startDate'],
            'endDate' => $built['endDate'],
            'mode' => $built['mode'],
            'transactions' => $transactions,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
            'rekapProduk' => $rekapProduk,
            'selectedStall' => $built['selectedStall'],
        ];

        $pdf = Pdf::loadView('reports.pdf', $data);

        $namaFile = 'Laporan-Miksusu';
        if ($built['mode'] === 'lapak' && $built['selectedStall']) {
            $namaFile .= '-' . str_replace(' ', '_', $built['selectedStall']->tempat);
        }
        $namaFile .= '-' . Carbon::parse($built['startDate'])->format('d-M-Y') . '.pdf';

        $logLabel = $built['mode'] === 'lapak' && $built['selectedStall']
            ? 'Lapak: ' . $built['selectedStall']->tempat
            : 'Periode ' . Carbon::parse($built['startDate'])->format('d/m/Y') . ' - ' . Carbon::parse($built['endDate'])->format('d/m/Y');

        ActivityLogger::log('export', 'laporan', 'Export PDF laporan penjualan. ' . $logLabel . '. Total: Rp ' . number_format($totalPendapatan, 0, ',', '.') . ' (' . $totalTransaksi . ' transaksi)');

        return $pdf->download($namaFile);
    }
}