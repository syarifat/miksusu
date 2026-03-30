<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('admin_nama');
            $table->string('admin_wa');
            $table->string('metode_pembayaran'); // cash, qris, transfer
            $table->string('metode_pengambilan'); // cod, ambil, antar
            $table->decimal('total_harga', 12, 0)->default(0);
            $table->string('status')->default('pending'); // pending, diproses, selesai, batal
            $table->timestamps();
        });

        Schema::create('preorder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preorder_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nama_produk'); // snapshot nama
            $table->integer('qty');
            $table->decimal('harga_satuan', 12, 0);
            $table->decimal('subtotal', 12, 0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preorder_items');
        Schema::dropIfExists('preorders');
    }
};
