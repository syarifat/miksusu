<x-app-layout>
    <x-slot name="header">Tambah Produk Baru</x-slot>

    <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                @error('nama') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                <input type="number" name="harga_saat_ini" value="{{ old('harga_saat_ini') }}" required min="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                @error('harga_saat_ini') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk (Opsional)</label>
                <input type="file" name="foto" accept="image/*" class="w-full border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100">
                @error('foto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex items-center space-x-3">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors">Simpan Produk</button>
                <a href="{{ route('products.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>