<x-app-layout>
    <x-slot name="header">Edit Produk: {{ $product->nama }}</x-slot>

    <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="nama" value="{{ old('nama', $product->nama) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="harga_saat_ini" value="{{ old('harga_saat_ini', $product->harga_saat_ini) }}" required min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                @if($product->foto_url)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->foto_url) }}" class="w-24 h-24 object-cover rounded-lg border">
                    </div>
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah foto</p>
            </div>

            <div class="pt-4 flex items-center space-x-3">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors">Update Produk</button>
                <a href="{{ route('products.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>