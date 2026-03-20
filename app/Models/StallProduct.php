<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StallProduct extends Model
{
    protected $fillable = [
        'stall_id', 
        'product_id', 
        'stok_dibawa', 
        'stok_sisa'
    ];

    public function stall(): BelongsTo
    {
        return $this->belongsTo(Stall::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}