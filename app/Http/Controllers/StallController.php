<?php

namespace App\Http\Controllers;

use App\Models\Stall;
use App\Models\Product;
use App\Models\StallProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StallController extends Controller
{
    public function index()
    {
        // Menampilkan lapak terbaru di atas
        $stalls = Stall::with('stallProducts.product')->latest('tanggal')->latest('id')->get();
        return view('stalls.index', compact('stalls'));
    }

    public function create()
    {
        $products = Product::orderBy('nama')->get();
        return view('stalls.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'tempat' => 'required|string|max:255',
            'stok' => 'required|array', // Array stok dari form
        ]);

        DB::beginTransaction();
        try {
            // 1. Buat Lapak Baru (Default status: aktif)
            $stall = Stall::create([
                'tanggal' => $request->tanggal,
                'tempat' => $request->tempat,
                'status' => 'aktif',
            ]);

            // 2. Simpan Produk yang dibawa (Hanya yang stoknya diisi > 0)
            foreach ($request->stok as $productId => $qty) {
                if ($qty > 0) {
                    StallProduct::create([
                        'stall_id' => $stall->id,
                        'product_id' => $productId,
                        'stok_dibawa' => $qty,
                        'stok_sisa' => $qty, // Awal buka lapak, sisa = dibawa
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('stalls.index')->with('success', 'Lapak berhasil dibuka!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi khusus untuk Akhiri / Buka Kembali Lapak
    public function toggleStatus(Stall $stall)
    {
        $stall->status = $stall->status === 'aktif' ? 'selesai' : 'aktif';
        $stall->save();

        $pesan = $stall->status === 'aktif' ? 'Lapak diaktifkan kembali.' : 'Lapak telah diselesaikan.';
        return back()->with('success', $pesan);
    }

    public function destroy(Stall $stall)
    {
        $stall->delete(); // StallProduct otomatis terhapus karena cascadeOnDelete di migration
        return back()->with('success', 'Data Lapak berhasil dihapus beserta histori stoknya.');
    }
}