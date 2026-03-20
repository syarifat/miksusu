<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Finance;
use Carbon\Carbon;

class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        Finance::create([
            'tipe' => 'pengeluaran',
            'kategori' => 'Bahan Baku',
            'nominal' => 150000,
            'keterangan' => 'Beli susu sapi murni 10 liter, es batu, dan cup plastik',
            'pic' => 'Admin Miksusu',
            'tanggal_transaksi' => Carbon::today(),
        ]);
    }
}