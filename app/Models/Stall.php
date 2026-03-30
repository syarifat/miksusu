<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stall extends Model
{
    protected $fillable = [
        'tanggal', 
        'tempat', 
        'status'
    ];

    // Relasi: Lapak bawa banyak produk
    public function stallProducts(): HasMany
    {
        return $this->hasMany(StallProduct::class);
    }

    // Relasi: Lapak punya banyak transaksi
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi: Lapak dijaga oleh beberapa kasir (user)
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}