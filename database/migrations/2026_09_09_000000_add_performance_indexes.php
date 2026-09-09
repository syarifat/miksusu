<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('modul');
            $table->index('aksi');
        });

        Schema::table('stalls', function (Blueprint $table) {
            $table->index('tanggal');
            $table->index('status');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('tipe');
        });

        Schema::table('finances', function (Blueprint $table) {
            $table->index('tanggal_transaksi');
            $table->index('tipe');
        });

        Schema::table('preorders', function (Blueprint $table) {
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['modul']);
            $table->dropIndex(['aksi']);
        });

        Schema::table('stalls', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['status']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['tipe']);
        });

        Schema::table('finances', function (Blueprint $table) {
            $table->dropIndex(['tanggal_transaksi']);
            $table->dropIndex(['tipe']);
        });

        Schema::table('preorders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['created_at']);
        });
    }
};
