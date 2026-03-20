<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

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

        Finance::create($request->all());

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

        $finance->update($request->all());

        return redirect()->route('finances.index')->with('success', 'Catatan keuangan berhasil diperbarui!');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();
        return back()->with('success', 'Catatan keuangan berhasil dihapus!');
    }
}