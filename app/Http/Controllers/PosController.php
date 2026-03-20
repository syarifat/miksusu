<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Product;
use App\Models\StallProduct;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    // Menampilkan daftar lapak yang sedang AKTIF saja
    public function index()
    {
        $stalls = Stall::where('status', 'aktif')->latest()->get();
        return view('pos.index', compact('stalls'));
    }

    // Menampilkan halaman kasir untuk lapak yang dipilih
    public function create(Stall $stall)
    {
        // Pastikan lapak masih aktif
        if ($stall->status !== 'aktif') {
            return redirect()->route('pos.index')->with('error', 'Lapak ini sudah ditutup.');
        }

        // Ambil barang bawaan lapak beserta detail produknya
        $stall->load('stallProducts.product');
        
        return view('pos.create', compact('stall'));
    }

    // Memproses transaksi penjualan
    public function store(Request $request, Stall $stall)
    {
        $request->validate([
            'tipe' => 'required|in:order,preorder',
            'nama_titipan' => 'required_if:tipe,preorder|nullable|string|max:255',
            'items' => 'required|array', // Item yang dibeli
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $itemsToInsert = [];

            // 1. Validasi stok dan hitung total harga (SNAPSHOT HARGA terjadi di sini)
            foreach ($request->items as $productId => $qty) {
                if ($qty > 0) {
                    $stallProduct = StallProduct::where('stall_id', $stall->id)
                                        ->where('product_id', $productId)->first();

                    if (!$stallProduct || $stallProduct->stok_sisa < $qty) {
                        throw new \Exception("Stok tidak mencukupi untuk beberapa produk.");
                    }

                    $product = Product::findOrFail($productId);
                    $hargaSatuan = $product->harga_saat_ini; // Ambil harga saat ini
                    $subtotal = $hargaSatuan * $qty;
                    $totalHarga += $subtotal;

                    $itemsToInsert[] = [
                        'product_id' => $productId,
                        'qty' => $qty,
                        'harga_satuan' => $hargaSatuan, // Simpan permanen
                        'subtotal' => $subtotal,
                        'stall_product' => $stallProduct, // Simpan instance untuk update stok nanti
                    ];
                }
            }

            if (empty($itemsToInsert)) {
                throw new \Exception("Tidak ada produk yang dipilih.");
            }

            // 2. Buat Transaksi Utama
            $transaction = Transaction::create([
                'stall_id' => $stall->id,
                'tipe' => $request->tipe,
                'nama_titipan' => $request->tipe === 'preorder' ? $request->nama_titipan : null,
                'total_harga' => $totalHarga,
            ]);

            // 3. Masukkan Detail Transaksi & Kurangi Stok Lapak
            foreach ($itemsToInsert as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi stok sisa di lapak
                $item['stall_product']->decrement('stok_sisa', $item['qty']);
            }

            DB::commit();
            return redirect()->route('pos.create', $stall->id)->with('success', 'Transaksi berhasil dicatat! Total: Rp ' . number_format($totalHarga, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}