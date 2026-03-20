<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['nama' => 'Susu Murni Original', 'harga_saat_ini' => 10000, 'foto_url' => null],
            ['nama' => 'Miksusu Coklat', 'harga_saat_ini' => 12000, 'foto_url' => null],
            ['nama' => 'Miksusu Strawberry', 'harga_saat_ini' => 12000, 'foto_url' => null],
            ['nama' => 'Miksusu Melon', 'harga_saat_ini' => 12000, 'foto_url' => null],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}