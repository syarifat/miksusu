<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil semua produk yang harganya lebih dari 0
        $products = Product::where('harga_saat_ini', '>', 0)->orderBy('nama')->get();
        return view('landing', compact('products'));
    }
}