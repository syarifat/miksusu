<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Preorder extends Model
{
    protected $fillable = [
        'nama_pelanggan',
        'admin_nama',
        'admin_wa',
        'metode_pembayaran',
        'metode_pengambilan',
        'total_harga',
        'status',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PreorderItem::class);
    }

    // Label pembayaran
    public function getLabelPembayaranAttribute(): string
    {
        return match($this->metode_pembayaran) {
            'cash' => 'Cash',
            'qris' => 'QRIS',
            'transfer' => 'Transfer Bank',
            default => $this->metode_pembayaran,
        };
    }

    // Label pengambilan
    public function getLabelPengambilanAttribute(): string
    {
        return match($this->metode_pengambilan) {
            'cod' => 'COD (Bayar di Tempat)',
            'ambil' => 'Ambil di Tempat',
            'antar' => 'Antar ke Rumah',
            default => $this->metode_pengambilan,
        };
    }
}
