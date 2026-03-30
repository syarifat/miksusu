<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\StallProduct;
use App\Models\Finance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ApiPosController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username atau password salah.'
            ], 401);
        }

        if ($user->role !== 'kasir') {
            return response()->json([
                'status' => 'error',
                'message' => 'Hanya Kasir yang dapat login ke aplikasi mobile POS.'
            ], 403);
        }

        // Generate Token via Sanctum
        $token = $user->createToken('mobile-pos-token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role
            ],
            // Opsional: Kirim daftar lapak yang ditugaskan biar HP langsung tau
            'stalls' => $user->stalls()->where('status', 'aktif')->select('stalls.id', 'tempat')->get()
        ], 200);
    }
    public function sync(Request $request)
    {
        // Data yang dikirim Android berupa array 'transactions'
        $transactionsData = $request->input('transactions');

        if (empty($transactionsData)) {
            return response()->json(['message' => 'Tidak ada data untuk disinkron'], 400);
        }

        $syncedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($transactionsData as $data) {
                // 1. CEK DUPLIKAT: Pastikan ID dari HP (local_id) belum pernah masuk
                $alreadyExists = Transaction::where('local_id', $data['local_id'])->exists();
                if ($alreadyExists) continue;

                // 2. SIMPAN TRANSAKSI UTAMA
                $transaction = Transaction::create([
                    'local_id' => $data['local_id'], // Gunakan UUID dari HP
                    'stall_id' => $data['stall_id'],
                    'total_harga' => $data['total_harga'],
                    'tipe' => $data['tipe'],
                    'nama_titipan' => $data['nama_titipan'] ?? null,
                    'created_at' => $data['created_at'], // Gunakan waktu saat HP offline
                ]);

                // 3. SIMPAN DETAIL ITEM & POTONG STOK
                foreach ($data['items'] as $item) {
                    $transaction->items()->create([
                        'product_id' => $item['product_id'],
                        'qty' => $item['qty'],
                        'harga_satuan' => $item['harga_satuan'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    // Update stok di Lapak terkait
                    $stallProduct = StallProduct::where('stall_id', $data['stall_id'])
                        ->where('product_id', $item['product_id'])
                        ->first();
                    
                    if ($stallProduct) {
                        $stallProduct->decrement('stok_sisa', $item['qty']);
                    }
                }

                // 4. AUTO-INSERT KE LAPORAN KEUANGAN
                Finance::create([
                    'tanggal_transaksi' => date('Y-m-d H:i:s', strtotime($data['created_at'])),
                    'tipe' => 'pemasukan',
                    'kategori' => 'Penjualan Kasir Mobile',
                    'nominal' => $data['total_harga'],
                    'keterangan' => "Penjualan Offline via App: " . ($data['nama_titipan'] ?? 'Pelanggan Umum'),
                    'pic' => 'Kasir Mobile'
                ]);

                $syncedCount++;
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => "Berhasil sinkronisasi $syncedCount transaksi.",
                'count' => $syncedCount
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal Sinkron POS: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan di server.'
            ], 500);
        }
    }

    public function katalog(Request $request)
    {
        // Ambil data user yang sedang request (Kasir)
        $user = $request->user();

        // Ambil lapak yang ditugaskan ke kasir ini beserta stok produknya
        $stalls = $user->stalls()->where('status', 'aktif')->with(['stallProducts' => function($query) {
            $query->where('stok_sisa', '>', 0)->with('product');
        }])->get();

        if ($stalls->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum ditugaskan ke lapak manapun yang sedang aktif.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $stalls
        ], 200);
    }
}