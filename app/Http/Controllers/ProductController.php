<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Helpers\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_saat_ini' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['nama', 'harga_saat_ini']);

        if ($request->hasFile('foto')) {
            $data['foto_url'] = $request->file('foto')->store('products', 'public');
        }

        $product = Product::create($data);

        ActivityLogger::log('create', 'produk', 'Menambahkan produk baru: ' . $product->nama, null, $product->toArray());

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_saat_ini' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataLama = $product->toArray();
        $data = $request->only(['nama', 'harga_saat_ini']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($product->foto_url && Storage::disk('public')->exists($product->foto_url)) {
                Storage::disk('public')->delete($product->foto_url);
            }
            $data['foto_url'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        ActivityLogger::log('update', 'produk', 'Mengupdate produk: ' . $product->nama, $dataLama, $product->fresh()->toArray());

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        $dataLama = $product->toArray();

        if ($product->foto_url && Storage::disk('public')->exists($product->foto_url)) {
            Storage::disk('public')->delete($product->foto_url);
        }
        
        $product->delete();

        ActivityLogger::log('delete', 'produk', 'Menghapus produk: ' . $dataLama['nama'], $dataLama);

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}