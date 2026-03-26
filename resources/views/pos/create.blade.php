<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Miksusu - {{ $stall->tempat }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-gray-200 px-4 py-3 flex justify-between items-center sticky top-0 z-50 shadow-sm">
            <div class="flex items-center space-x-3">
                <a href="{{ route('pos.index') }}" class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h1 class="font-black text-red-600 italic tracking-tighter">MIKSUSU.</h1>
                    <p class="text-[10px] text-gray-500 font-bold uppercase leading-none">{{ $stall->tempat }}</p>
                </div>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold text-gray-400 block">{{ \Carbon\Carbon::parse($stall->tanggal)->translatedFormat('d M Y') }}</span>
                <span class="text-[10px] px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold uppercase">Online</span>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-4 py-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-500 text-white font-bold rounded-2xl text-center shadow-lg animate-bounce">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-200 text-red-700 rounded-2xl shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" x-data="{ tipe: 'order' }">
                <form action="{{ route('pos.store', $stall->id) }}" method="POST" class="p-6 md:p-8">
                    @csrf
                    
                    <div class="flex bg-gray-100 p-1.5 rounded-2xl mb-8">
                        <label class="flex-1 text-center cursor-pointer group">
                            <input type="radio" name="tipe" value="order" x-model="tipe" class="hidden">
                            <div :class="tipe === 'order' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-500'" class="py-3 rounded-xl font-bold transition-all">
                                Order Biasa
                            </div>
                        </label>
                        <label class="flex-1 text-center cursor-pointer group">
                            <input type="radio" name="tipe" value="preorder" x-model="tipe" class="hidden">
                            <div :class="tipe === 'preorder' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-500'" class="py-3 rounded-xl font-bold transition-all">
                                Preorder / Jastip
                            </div>
                        </label>
                    </div>

                    <div x-show="tipe === 'preorder'" x-transition x-cloak class="mb-8 p-4 bg-red-50 rounded-2xl border-2 border-red-100">
                        <label class="block text-xs font-black text-red-700 uppercase tracking-widest mb-2">Nama Jastip / Nama Pembeli</label>
                        <input type="text" name="nama_titipan" placeholder="Masukkan nama..." class="w-full border-red-200 rounded-xl shadow-sm focus:border-red-500 focus:ring-red-500 text-lg font-medium">
                    </div>

                    <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Pilih Menu Miksusu</h3>
                    <div class="space-y-4 mb-10">
                        @foreach($stall->stallProducts as $sp)
                        <div class="flex items-center justify-between p-4 border-2 {{ $sp->stok_sisa > 0 ? 'border-gray-50 bg-gray-50' : 'border-gray-100 bg-white opacity-50' }} rounded-2xl transition-all">
                            <div class="flex items-center space-x-4">
                                @if($sp->product->foto_url)
                                    <img src="{{ asset('storage/' . $sp->product->foto_url) }}" class="w-16 h-16 rounded-xl object-cover shadow-sm">
                                @else
                                    <div class="w-16 h-16 rounded-xl bg-gray-200 flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase">No Foto</div>
                                @endif
                                <div>
                                    <h4 class="font-black text-gray-800 leading-tight">{{ $sp->product->nama }}</h4>
                                    <p class="text-sm text-red-600 font-black">Rp {{ number_format($sp->product->harga_saat_ini, 0, ',', '.') }}</p>
                                    <p class="text-[10px] font-bold mt-1 {{ $sp->stok_sisa > 0 ? 'text-gray-400' : 'text-red-600' }}">Sisa: {{ $sp->stok_sisa }}</p>
                                </div>
                            </div>
                            
                            <div class="w-20">
                                @if($sp->stok_sisa > 0)
                                    <input type="number" name="items[{{ $sp->product_id }}]" min="0" max="{{ $sp->stok_sisa }}" placeholder="0" class="w-full border-none bg-white rounded-xl shadow-inner focus:ring-red-500 text-center font-black text-xl py-3">
                                @else
                                    <span class="block text-center text-gray-400 font-black text-[10px] uppercase">Habis</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="submit" class="w-full py-5 bg-red-600 hover:bg-red-700 text-white font-black text-xl rounded-2xl shadow-xl shadow-red-200 transition-all flex justify-center items-center active:scale-95">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Simpan Penjualan
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>