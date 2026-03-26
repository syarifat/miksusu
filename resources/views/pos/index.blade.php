<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Miksusu - Pilih Lapak</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-red-600 shadow-lg p-4 text-white text-center">
            <h1 class="text-2xl font-black tracking-tighter italic">MIKSUSU. POS</h1>
        </header>

        <main class="flex-grow container mx-auto px-4 py-8">
            @if(session('error'))
                <div class="max-w-4xl mx-auto mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="mb-8 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pilih Lapak Aktif</h2>
                        <p class="text-gray-500 italic">Silakan pilih lokasi jualan yang sedang berlangsung untuk mulai mencatat pesanan.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @forelse($stalls as $stall)
                        <a href="{{ route('pos.create', $stall->id) }}" class="block p-6 bg-white hover:bg-red-50 border-2 border-gray-100 hover:border-red-500 rounded-2xl transition-all shadow-sm hover:shadow-md group">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-red-700 transition-colors">{{ $stall->tempat }}</h3>
                                <span class="px-2 py-1 bg-red-600 text-white text-[10px] font-black rounded-md animate-pulse uppercase">BUKA</span>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">{{ \Carbon\Carbon::parse($stall->tanggal)->translatedFormat('l, d M Y') }}</p>
                            <div class="flex items-center text-sm text-red-600 font-bold">
                                Buka Mesin Kasir 
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full py-12 text-center border-2 border-dashed border-gray-200 rounded-2xl bg-gray-50">
                            <p class="text-gray-400 mb-4">Tidak ada lapak yang aktif saat ini.</p>
                            <p class="text-sm text-gray-500">Hubungi Admin untuk membuka lapak baru.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>

        <footer class="p-4 text-center text-gray-400 text-xs">
            &copy; {{ date('Y') }} Miksusu Point of Sale. Built for speed.
        </footer>
    </div>
</body>
</html>