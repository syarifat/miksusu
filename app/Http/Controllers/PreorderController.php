<?php

namespace App\Http\Controllers;

use App\Models\Preorder;
use App\Models\PreorderItem;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;

class PreorderController extends Controller
{
    // Halaman rekap preorder (admin)
    public function index(Request $request)
    {
        $query = Preorder::with('items')->latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter metode pembayaran
        if ($request->filled('pembayaran')) {
            $query->where('metode_pembayaran', $request->pembayaran);
        }

        // Filter metode pengambilan
        if ($request->filled('pengambilan')) {
            $query->where('metode_pengambilan', $request->pengambilan);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('admin_nama', 'like', "%{$search}%");
            });
        }

        $preorders = $query->paginate(20)->withQueryString();

        // Summary stats dalam 1 query agregat tunggal
        $stats = Preorder::selectRaw("
            COUNT(*) as total_preorders,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as total_pending,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as total_selesai,
            SUM(CASE WHEN status = 'selesai' THEN total_harga ELSE 0 END) as total_omzet
        ")->first();

        $totalPreorders = $stats->total_preorders ?? 0;
        $totalPending = $stats->total_pending ?? 0;
        $totalSelesai = $stats->total_selesai ?? 0;
        $totalOmzet = $stats->total_omzet ?? 0;

        return view('preorders.index', compact('preorders', 'totalPreorders', 'totalPending', 'totalSelesai', 'totalOmzet'));
    }

    // API: Simpan preorder dari landing page
    public function store(Request $request)
    {
        // Anti-Bot Honeypot Protection: tolak bot spammer seketika tanpa menyentuh database
        if ($request->filled('website_hp')) {
            return response()->json(['success' => true, 'message' => 'Processed'], 200);
        }

        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'admin_nama' => 'required|string|max:255',
            'admin_wa' => 'required|string|max:30',
            'metode_pembayaran' => 'required|in:cash,qris,transfer',
            'metode_pengambilan' => 'required|in:cod,ambil,antar',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.nama' => 'required|string',
            'items.*.harga' => 'required|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $totalHarga = 0;
        foreach ($request->items as $item) {
            $totalHarga += $item['harga'] * $item['qty'];
        }

        $preorder = Preorder::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'admin_nama' => $request->admin_nama,
            'admin_wa' => $request->admin_wa,
            'metode_pembayaran' => $request->metode_pembayaran,
            'metode_pengambilan' => $request->metode_pengambilan,
            'total_harga' => $totalHarga,
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            PreorderItem::create([
                'preorder_id' => $preorder->id,
                'product_id' => $item['id'],
                'nama_produk' => $item['nama'],
                'qty' => $item['qty'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['harga'] * $item['qty'],
            ]);
        }

        return response()->json(['success' => true, 'preorder_id' => $preorder->id]);
    }

    // Update status preorder
    public function updateStatus(Request $request, Preorder $preorder)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,batal'
        ]);

        $statusLama = $preorder->status;
        $preorder->update(['status' => $request->status]);

        ActivityLogger::log('update', 'preorder', 'Mengubah status preorder #' . $preorder->id . ' (' . $preorder->nama_pelanggan . ') dari ' . $statusLama . ' ke ' . $request->status, 
            ['status' => $statusLama], 
            ['status' => $request->status]
        );

        return back()->with('success', 'Status preorder berhasil diubah menjadi ' . ucfirst($request->status));
    }

    // Hapus preorder
    public function destroy(Preorder $preorder)
    {
        $data = $preorder->toArray();
        $preorder->delete();

        ActivityLogger::log('delete', 'preorder', 'Menghapus preorder #' . $data['id'] . ' (' . $data['nama_pelanggan'] . ')', $data);

        return back()->with('success', 'Preorder berhasil dihapus.');
    }
}
