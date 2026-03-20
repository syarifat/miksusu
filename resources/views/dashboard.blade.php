<x-app-layout>
    <x-slot name="header">
        Dashboard Miksusu
    </x-slot>

    <div class="bg-red-700 rounded-2xl shadow-lg p-6 mb-6 text-white relative overflow-hidden">
        <div class="relative z-10">
            <h2 class="text-2xl font-black mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-red-100 text-sm">Selamat datang di Panel Admin Miksusu. Yuk, cek ringkasan bisnis hari ini.</p>
        </div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-red-600 rounded-full opacity-50 blur-2xl"></div>
        <div class="absolute right-20 -bottom-10 w-32 h-32 bg-red-800 rounded-full opacity-50 blur-xl"></div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('stalls.create') }}" class="bg-white border border-red-100 p-4 rounded-xl shadow-sm hover:shadow-md hover:border-red-300 transition-all text-center group">
            <div class="w-12 h-12 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-700">Buka Lapak</span>
        </a>
        <a href="{{ route('pos.index') }}" class="bg-white border border-red-100 p-4 rounded-xl shadow-sm hover:shadow-md hover:border-red-300 transition-all text-center group">
            <div class="w-12 h-12 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-700">POS Kasir</span>
        </a>
        <a href="{{ route('finances.create') }}" class="bg-white border border-red-100 p-4 rounded-xl shadow-sm hover:shadow-md hover:border-red-300 transition-all text-center group">
            <div class="w-12 h-12 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-700">Catat Kas</span>
        </a>
        <a href="{{ route('reports.sales') }}" class="bg-white border border-red-100 p-4 rounded-xl shadow-sm hover:shadow-md hover:border-red-300 transition-all text-center group">
            <div class="w-12 h-12 mx-auto bg-red-50 text-red-600 rounded-full flex items-center justify-center mb-2 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <span class="text-sm font-bold text-gray-700">Laporan</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Omzet Penjualan Hari Ini</p>
                <h3 class="text-3xl font-black text-red-600">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-500 mb-1">Total Saldo Kas</p>
                <h3 class="text-3xl font-black text-gray-800">Rp {{ number_format($saldoKas, 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2 flex justify-between items-center">
                Lapak Sedang Buka
                <span class="bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">{{ $lapakAktif->count() }}</span>
            </h3>
            
            <div class="space-y-3">
                @forelse($lapakAktif as $lapak)
                <a href="{{ route('pos.create', $lapak->id) }}" class="flex items-center justify-between p-3 bg-red-50 rounded-lg hover:bg-red-100 transition-colors border border-red-100 group">
                    <div>
                        <h4 class="font-bold text-red-800 text-sm">{{ $lapak->tempat }}</h4>
                        <p class="text-xs text-red-500 font-medium">Klik untuk buka kasir</p>
                    </div>
                    <svg class="w-5 h-5 text-red-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
                @empty
                <div class="text-center py-4">
                    <p class="text-xs text-gray-400 mb-2">Tidak ada lapak aktif.</p>
                    <a href="{{ route('stalls.create') }}" class="text-xs font-bold text-red-600 hover:underline">Buka Lapak Baru &rarr;</a>
                </div>
                @endforelse
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">5 Transaksi Terakhir</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transaksiTerbaru as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-2">
                                <p class="text-sm font-bold text-gray-800">{{ $trx->stall->tempat }}</p>
                                <p class="text-xs text-gray-500">{{ $trx->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-md {{ $trx->tipe == 'order' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} uppercase">
                                    {{ $trx->tipe }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-right">
                                <p class="text-sm font-bold text-red-600">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-sm text-gray-500">Belum ada transaksi sama sekali.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>