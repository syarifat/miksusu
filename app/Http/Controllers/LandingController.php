<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LandingController extends Controller
{
    public function index()
    {
        // Cache produk landing page selama 24 jam (menghemat TiDB RU dan memangkas latensi)
        $cachedProducts = Cache::remember('landing_products', 86400, function () {
            return Product::where('harga_saat_ini', '>', 0)->orderBy('nama')->get()->toArray();
        });

        $products = Product::hydrate($cachedProducts);

        return response()
            ->view('landing', compact('products'))
            ->header('Cache-Control', 'public, max-age=60, s-maxage=300, stale-while-revalidate=600');
    }
}