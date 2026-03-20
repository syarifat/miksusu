<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'nama', 
        'harga_saat_ini', 
        'foto_url'
    ];

    // Relasi: Satu produk bisa ada di banyak detail transaksi
    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}