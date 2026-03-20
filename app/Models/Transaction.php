<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'stall_id', 
        'tipe', 
        'nama_titipan', 
        'total_harga'
    ];

    public function stall(): BelongsTo
    {
        return $this->belongsTo(Stall::class);
    }

    // Relasi: Satu transaksi punya banyak detail barang (item)
    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}