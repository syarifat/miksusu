<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Transaction;
use App\Models\Finance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'kasir') {
            return redirect()->route('pos.index');
        }

        $startOfDay = Carbon::today()->startOfDay();

        // 1. Ambil Lapak yang statusnya masih 'aktif'
        $lapakAktif = Stall::where('status', 'aktif')->get();

        // 2. Hitung omzet khusus hari ini (menggunakan index created_at)
        $omzetHariIni = Transaction::where('created_at', '>=', $startOfDay)->sum('total_harga');

        // 3. Hitung Saldo Kas Keseluruhan dalam 1 query agregat tunggal
        $financeSummary = Finance::selectRaw("
            SUM(CASE WHEN tipe = 'pemasukan' THEN nominal ELSE 0 END) as total_pemasukan,
            SUM(CASE WHEN tipe = 'pengeluaran' THEN nominal ELSE 0 END) as total_pengeluaran
        ")->first();

        $saldoKas = ($financeSummary->total_pemasukan ?? 0) - ($financeSummary->total_pengeluaran ?? 0);

        // 4. Ambil 5 Transaksi terakhir untuk mini-history (eager load stall)
        $transaksiTerbaru = Transaction::with('stall')->latest()->take(5)->get();

        return view('dashboard', compact('lapakAktif', 'omzetHariIni', 'saldoKas', 'transaksiTerbaru'));
    }
}