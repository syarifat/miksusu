<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StallProduct;

class StallProductSeeder extends Seeder
{
    public function run(): void
    {
        // Membawa 4 produk ke lapak Alun-Alun (stall_id = 1)
        $stokLapak = [
            ['stall_id' => 1, 'product_id' => 1, 'stok_dibawa' => 50, 'stok_sisa' => 50],
            ['stall_id' => 1, 'product_id' => 2, 'stok_dibawa' => 30, 'stok_sisa' => 30],
            ['stall_id' => 1, 'product_id' => 3, 'stok_dibawa' => 20, 'stok_sisa' => 20],
            ['stall_id' => 1, 'product_id' => 4, 'stok_dibawa' => 20, 'stok_sisa' => 20],
        ];

        foreach ($stokLapak as $stok) {
            StallProduct::create($stok);
        }
    }
}