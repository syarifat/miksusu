<?php

namespace App\Http\Controllers;

use App\Models\FinanceCategory;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class FinanceCategoryController extends Controller
{
    public function index()
    {
        $categories = FinanceCategory::orderBy('tipe')->orderBy('nama_kategori')->get();
        return view('finance-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category = FinanceCategory::create($request->all());

        ActivityLogger::log('create', 'kategori_keuangan', 'Menambahkan kategori keuangan: ' . ucfirst($category->tipe) . ' - ' . $category->nama_kategori, null, $category->toArray());

        return redirect()->route('finance-categories.index')->with('success', 'Kategori keuangan berhasil ditambahkan!');
    }

    public function update(Request $request, FinanceCategory $financeCategory)
    {
        $request->validate([
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'nama_kategori' => 'required|string|max:255',
        ]);

        $dataLama = $financeCategory->toArray();
        $financeCategory->update($request->all());

        ActivityLogger::log('update', 'kategori_keuangan', 'Mengupdate kategori keuangan: ' . ucfirst($financeCategory->tipe) . ' - ' . $financeCategory->nama_kategori, $dataLama, $financeCategory->fresh()->toArray());

        return redirect()->route('finance-categories.index')->with('success', 'Kategori keuangan berhasil diperbarui!');
    }

    public function destroy(FinanceCategory $financeCategory)
    {
        $dataLama = $financeCategory->toArray();

        $financeCategory->delete();

        ActivityLogger::log('delete', 'kategori_keuangan', 'Menghapus kategori keuangan: ' . ucfirst($dataLama['tipe']) . ' - ' . $dataLama['nama_kategori'], $dataLama);

        return redirect()->route('finance-categories.index')->with('success', 'Kategori keuangan berhasil dihapus!');
    }
}
