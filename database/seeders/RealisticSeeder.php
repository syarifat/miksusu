<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Stall;
use App\Models\StallProduct;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Finance;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class RealisticSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Buat Akun Admin (Jika belum ada)
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            ['name' => 'Admin Miksusu', 'password' => Hash::make('password')]
        );

        // 2. Data Master Produk
        $productsData = [
            ['nama' => 'Susu Murni Original', 'harga_saat_ini' => 10000],
            ['nama' => 'Miksusu Coklat', 'harga_saat_ini' => 12000],
            ['nama' => 'Miksusu Strawberry', 'harga_saat_ini' => 12000],
            ['nama' => 'Miksusu Melon', 'harga_saat_ini' => 12000],
        ];
        
        $products = [];
        foreach ($productsData as $pd) {
            $products[] = Product::firstOrCreate(['nama' => $pd['nama']], $pd);
        }

        // 3. Catat Modal Awal (Mundur 15 hari yang lalu)
        $startDate = Carbon::today()->subDays(14);
        Finance::create([
            'tipe' => 'pemasukan',
            'kategori' => 'Modal Awal',
            'nominal' => 1500000,
            'keterangan' => 'Modal awal bisnis Miksusu',
            'pic' => $admin->name,
            'tanggal_transaksi' => $startDate->copy()->subDay(),
        ]);

        $lokasiLapak = ['Alun-Alun', 'GOR', 'CFD Taman', 'Pasar Senggol', 'Depan Kampus'];

        // 4. Looping Simulasi 8 Lapak (Selama 2 Minggu Terakhir)
        for ($i = 0; $i < 8; $i++) {
            // Jeda antar lapak 1-2 hari agar tersebar di 14 hari
            $tanggalLapak = $startDate->copy()->addDays($i * 1.7)->startOfDay(); 

            // Buka Lapak (Status otomatis dibuat selesai karena ini histori)
            $stall = Stall::create([
                'tanggal' => $tanggalLapak,
                'tempat' => $faker->randomElement($lokasiLapak),
                'status' => 'selesai', 
                'created_at' => $tanggalLapak,
                'updated_at' => $tanggalLapak,
            ]);

            // Catat Pengeluaran Lapak (Es batu, kresek, dll)
            Finance::create([
                'tipe' => 'pengeluaran',
                'kategori' => 'Operasional Lapak',
                'nominal' => $faker->numberBetween(20000, 45000),
                'keterangan' => 'Biaya es batu, parkir, dan operasional di ' . $stall->tempat,
                'pic' => $admin->name,
                'tanggal_transaksi' => $tanggalLapak,
                'created_at' => $tanggalLapak,
                'updated_at' => $tanggalLapak,
            ]);

            // Set Stok Bawaan Lapak
            $stallProducts = [];
            foreach ($products as $product) {
                $stokDibawa = $faker->numberBetween(25, 60); // Bawa 25-60 cup per rasa
                $stallProducts[] = StallProduct::create([
                    'stall_id' => $stall->id,
                    'product_id' => $product->id,
                    'stok_dibawa' => $stokDibawa,
                    'stok_sisa' => $stokDibawa, // Nanti dikurangi oleh transaksi
                    'created_at' => $tanggalLapak,
                    'updated_at' => $tanggalLapak,
                ]);
            }

            // Simulasi Transaksi (15 sampai 35 pelanggan per lapak)
            $jumlahPelanggan = $faker->numberBetween(15, 35);

            for ($j = 0; $j < $jumlahPelanggan; $j++) {
                // Pelanggan datang di jam acak (antara jam 15:00 - 21:00)
                $waktuTransaksi = $tanggalLapak->copy()->addHours(15)->addMinutes($faker->numberBetween(0, 360));
                
                // 15% kemungkinan ini adalah Jastip/Preorder
                $isPreorder = $faker->boolean(15); 

                $transaction = Transaction::create([
                    'stall_id' => $stall->id,
                    'tipe' => $isPreorder ? 'preorder' : 'order',
                    'nama_titipan' => $isPreorder ? 'Titipan ' . $faker->firstName : null,
                    'total_harga' => 0, // Dihitung di bawah
                    'created_at' => $waktuTransaksi,
                    'updated_at' => $waktuTransaksi,
                ]);

                $totalHargaTrx = 0;
                $macamProdukDibeli = $faker->numberBetween(1, 3); // Beli 1 sampai 3 rasa
                $produkPilihan = $faker->randomElements($stallProducts, $macamProdukDibeli);

                foreach ($produkPilihan as $sp) {
                    $qtyBeli = $faker->numberBetween(1, 4); // Beli 1-4 cup per rasa

                    // Validasi stok sebelum dibeli
                    if ($sp->stok_sisa >= $qtyBeli) {
                        $hargaSatuan = $sp->product->harga_saat_ini;
                        $subtotal = $hargaSatuan * $qtyBeli;

                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'product_id' => $sp->product_id,
                            'qty' => $qtyBeli,
                            'harga_satuan' => $hargaSatuan,
                            'subtotal' => $subtotal,
                            'created_at' => $waktuTransaksi,
                            'updated_at' => $waktuTransaksi,
                        ]);

                        $totalHargaTrx += $subtotal;
                        
                        // Kurangi stok sisa lapak
                        $sp->decrement('stok_sisa', $qtyBeli);
                    }
                }

                // Update total bayar atau hapus jika pelanggan gagal beli (stok habis)
                if ($totalHargaTrx > 0) {
                    $transaction->update(['total_harga' => $totalHargaTrx]);
                } else {
                    $transaction->delete();
                }
            }
        }

        // 5. Buat 1 Lapak "Aktif" Hari Ini untuk Testing POS Kasir
        $stallHariIni = Stall::create([
            'tanggal' => Carbon::today(),
            'tempat' => 'Alun-Alun (Test Kasir)',
            'status' => 'aktif',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        foreach ($products as $product) {
            StallProduct::create([
                'stall_id' => $stallHariIni->id,
                'product_id' => $product->id,
                'stok_dibawa' => 50,
                'stok_sisa' => 50,
            ]);
        }
    }
}