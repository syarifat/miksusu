<x-app-layout>
    <x-slot name="header">Kasir Lapak: {{ $stall->tempat }}</x-slot>

    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('pos.index') }}" class="text-sm text-gray-500 hover:text-red-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Pilih Lapak
        </a>
        <span class="px-3 py-1 bg-red-100 text-red-800 text-sm font-bold rounded-full border border-red-200">
            {{ \Carbon\Carbon::parse($stall->tanggal)->translatedFormat('d M Y') }}
        </span>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 font-bold rounded-lg text-lg text-center shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-6" x-data="{ tipe: 'order' }">
        <form action="{{ route('pos.store', $stall->id) }}" method="POST">
            @csrf
            
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Tipe Transaksi</label>
                <div class="flex space-x-4 mb-4">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="tipe" value="order" x-model="tipe" class="w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="font-medium text-gray-800">Order Biasa</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="tipe" value="preorder" x-model="tipe" class="w-5 h-5 text-red-600 focus:ring-red-500">
                        <span class="font-medium text-gray-800">Preorder / Jastip</span>
                    </label>
                </div>

                <div x-show="tipe === 'preorder'" x-collapse x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jastip / Referral</label>
                    <input type="text" name="nama_titipan" placeholder="Misal: Titipan Budi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="text-xs text-gray-500 mt-1">*Wajib diisi untuk membedakan pesanan jastip.</p>
                </div>
            </div>

            <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Keranjang Belanja</h3>
            <div class="space-y-3 mb-6">
                @foreach($stall->stallProducts as $sp)
                <div class="flex items-center justify-between p-3 border {{ $sp->stok_sisa > 0 ? 'border-gray-200 bg-white' : 'border-red-100 bg-red-50 opacity-60' }} rounded-lg">
                    <div class="flex items-center space-x-3">
                        @if($sp->product->foto_url)
                            <img src="{{ asset('storage/' . $sp->product->foto_url) }}" class="w-12 h-12 rounded-md object-cover border">
                        @else
                            <div class="w-12 h-12 rounded-md bg-gray-200 flex items-center justify-center text-xs text-gray-500 border">No Img</div>
                        @endif
                        <div>
                            <h4 class="font-bold text-gray-800">{{ $sp->product->nama }}</h4>
                            <p class="text-sm text-red-600 font-semibold">Rp {{ number_format($sp->product->harga_saat_ini, 0, ',', '.') }}</p>
                            <p class="text-xs font-medium mt-1 {{ $sp->stok_sisa > 0 ? 'text-gray-500' : 'text-red-500 font-bold' }}">Sisa stok: {{ $sp->stok_sisa }}</p>
                        </div>
                    </div>
                    
                    <div class="w-24">
                        @if($sp->stok_sisa > 0)
                            <input type="number" name="items[{{ $sp->product_id }}]" min="0" max="{{ $sp->stok_sisa }}" placeholder="0" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-center font-bold text-lg">
                        @else
                            <span class="block text-center text-red-600 font-bold text-sm bg-red-100 py-2 rounded-lg">HABIS</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <button type="submit" class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold text-lg rounded-xl shadow-lg transition-colors flex justify-center items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Proses Pembayaran
            </button>
        </form>
    </div>
</x-app-layout>