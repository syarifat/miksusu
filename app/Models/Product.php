<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = [
        'nama', 
        'harga_saat_ini', 
        'foto_url'
    ];

    /**
     * Get public image URL supporting Cloudflare R2 / S3 and local storage.
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->foto_url) {
            return '';
        }

        if (str_starts_with($this->foto_url, 'http://') || str_starts_with($this->foto_url, 'https://')) {
            return $this->foto_url;
        }

        $disk = config('filesystems.default');

        if ($disk === 'r2' || $disk === 's3') {
            return Storage::disk($disk)->url($this->foto_url);
        }

        return asset('storage/' . $this->foto_url);
    }

    // Relasi: Satu produk bisa ada di banyak detail transaksi
    public function transactionItems(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function stallProducts(): HasMany
    {
        return $this->hasMany(StallProduct::class);
    }
}