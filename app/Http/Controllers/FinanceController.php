<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('tanggal_transaksi', 'desc')->latest()->get();
        
        // Hitung rekapitulasi simpel
        $totalPemasukan = $finances->where('tipe', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $finances->where('tipe', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        return view('finances.index', compact('finances', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
    }

    public function exportPdf()
    {
        $finances = Finance::orderBy('tanggal_transaksi', 'desc')->latest()->get();
        
        $totalPemasukan = $finances->where('tipe', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $finances->where('tipe', 'pengeluaran')->sum('nominal');
        $saldo = $totalPemasukan - $totalPengeluaran;

        $pdf = Pdf::loadView('finances.pdf', compact('finances', 'totalPemasukan', 'totalPengeluaran', 'saldo'));
        
        ActivityLogger::log('export', 'keuangan', 'Mengekspor laporan keuangan ke PDF');

        return $pdf->download('Laporan_Keuangan_Miksusu.pdf');
    }

    public function create()
    {
        return view('finances.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
            'pic' => 'required|string|max:100',
            'tanggal_transaksi' => 'required|date',
        ]);

        $finance = Finance::create($request->all());

        ActivityLogger::log('create', 'keuangan', 'Menambahkan catatan keuangan: ' . ucfirst($finance->tipe) . ' - ' . $finance->kategori . ' (Rp ' . number_format($finance->nominal, 0, ',', '.') . ')', null, $finance->toArray());

        return redirect()->route('finances.index')->with('success', 'Catatan keuangan berhasil ditambahkan!');
    }

    public function edit(Finance $finance)
    {
        return view('finances.edit', compact('finance'));
    }

    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'kategori' => 'required|string|max:100',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string',
            'pic' => 'required|string|max:100',
            'tanggal_transaksi' => 'required|date',
        ]);

        $dataLama = $finance->toArray();
        $finance->update($request->all());

        ActivityLogger::log('update', 'keuangan', 'Mengupdate catatan keuangan: ' . ucfirst($finance->tipe) . ' - ' . $finance->kategori, $dataLama, $finance->fresh()->toArray());

        return redirect()->route('finances.index')->with('success', 'Catatan keuangan berhasil diperbarui!');
    }

    public function destroy(Finance $finance)
    {
        $dataLama = $finance->toArray();

        $finance->delete();

        ActivityLogger::log('delete', 'keuangan', 'Menghapus catatan keuangan: ' . ucfirst($dataLama['tipe']) . ' - ' . $dataLama['kategori'] . ' (Rp ' . number_format($dataLama['nominal'], 0, ',', '.') . ')', $dataLama);

        return back()->with('success', 'Catatan keuangan berhasil dihapus!');
    }
}