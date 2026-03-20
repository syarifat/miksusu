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
        $hariIni = Carbon::today();

        // 1. Ambil Lapak yang statusnya masih 'aktif'
        $lapakAktif = Stall::where('status', 'aktif')->get();

        // 2. Hitung omzet khusus hari ini (dari tabel transaksi POS)
        $omzetHariIni = Transaction::whereDate('created_at', $hariIni)->sum('total_harga');

        // 3. Hitung Saldo Kas Keseluruhan (Pemasukan - Pengeluaran)
        $pemasukan = Finance::where('tipe', 'pemasukan')->sum('nominal');
        $pengeluaran = Finance::where('tipe', 'pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        // 4. Ambil 5 Transaksi terakhir untuk mini-history
        $transaksiTerbaru = Transaction::with('stall')->latest()->take(5)->get();

        return view('dashboard', compact('lapakAktif', 'omzetHariIni', 'saldoKas', 'transaksiTerbaru'));
    }
}