<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    protected $fillable = [
        'tipe', 
        'kategori', 
        'nominal', 
        'keterangan', 
        'pic', 
        'tanggal_transaksi'
    ];

    // Mengubah format tanggal agar mudah dikelola oleh Carbon di Laravel
    protected function casts(): array
    {
        return [
            'tanggal_transaksi' => 'date',
        ];
    }
}