<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Transaksi 1: Pembeli langsung (Order)
        Transaction::create([
            'stall_id' => 1,
            'tipe' => 'order',
            'nama_titipan' => null,
            'total_harga' => 22000,
        ]);

        // Transaksi 2: Jastip/Referral (Preorder)
        Transaction::create([
            'stall_id' => 1,
            'tipe' => 'preorder',
            'nama_titipan' => 'Budi Jastip',
            'total_harga' => 36000,
        ]);
    }
}