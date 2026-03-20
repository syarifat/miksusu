<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // UserSeeder::class,
            // ProductSeeder::class,
            // StallSeeder::class,
            // StallProductSeeder::class,
            // TransactionSeeder::class,
            // TransactionItemSeeder::class,
            // FinanceSeeder::class,
            RealisticSeeder::class,
        ]);
    }
}