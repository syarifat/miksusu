<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionItem;

class TransactionItemSeeder extends Seeder
{
    public function run(): void
    {
        // Detail Transaksi 1 (Beli Ori 1, Coklat 1)
        TransactionItem::create([
            'transaction_id' => 1, 'product_id' => 1, 'qty' => 1, 'harga_satuan' => 10000, 'subtotal' => 10000
        ]);
        TransactionItem::create([
            'transaction_id' => 1, 'product_id' => 2, 'qty' => 1, 'harga_satuan' => 12000, 'subtotal' => 12000
        ]);

        // Detail Transaksi 2 (Beli Strawberry 3)
        TransactionItem::create([
            'transaction_id' => 2, 'product_id' => 3, 'qty' => 3, 'harga_satuan' => 12000, 'subtotal' => 36000
        ]);
    }
}