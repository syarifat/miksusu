<x-app-layout>
    <x-slot name="header">Buka Lapak Baru</x-slot>

    <div class="max-w-3xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
        @endif

        <form action="{{ route('stalls.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat / Lokasi</label>
                    <input type="text" name="tempat" placeholder="Misal: Alun-alun, CFD, dll" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <hr class="mb-4">
            
            <div class="mb-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Pilih Barang yang Dibawa</h3>
                <p class="text-sm text-gray-500 mb-4">Isi jumlah stok pada barang yang dibawa. Biarkan kosong atau 0 untuk barang yang tidak dibawa.</p>

                <div class="space-y-3">
                    @foreach($products as $product)
                    <div class="flex items-center justify-between p-3 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-center space-x-3">
                            @if($product->foto_url)
                                <img src="{{ asset('storage/' . $product->foto_url) }}" class="w-10 h-10 rounded-md object-cover">
                            @else
                                <div class="w-10 h-10 rounded-md bg-gray-200 flex items-center justify-center text-xs text-gray-500">No Img</div>
                            @endif
                            <div>
                                <h4 class="font-semibold text-gray-800">{{ $product->nama }}</h4>
                                <p class="text-xs text-red-600 font-medium">Rp {{ number_format($product->harga_saat_ini, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="w-24">
                            <input type="number" name="stok[{{ $product->id }}]" min="0" placeholder="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-center">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="pt-4 flex items-center space-x-3 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors w-full md:w-auto">Buka Lapak Sekarang</button>
                <a href="{{ route('stalls.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors text-center w-full md:w-auto">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>