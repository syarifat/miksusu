<x-app-layout>
    <x-slot name="header">Laporan Penjualan</x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('reports.sales') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-auto flex-1">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>
            <div class="w-full sm:w-auto flex-1">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>
            <div class="w-full sm:w-auto">
                <div class="w-full sm:w-auto flex space-x-2">
                <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-md transition-colors h-[42px] flex items-center justify-center">
                    Tampilkan Data
                </button>
                
                <a href="{{ route('reports.sales.pdf', request()->all()) }}" target="_blank" class="w-full sm:w-auto px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-lg shadow-md transition-colors h-[42px] flex items-center justify-center text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Cetak PDF
                </a>
            </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Pendapatan Penjualan</p>
                <h3 class="text-2xl font-black text-red-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center">
            <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-500">Total Transaksi Kasir</p>
                <h3 class="text-2xl font-black text-gray-800">{{ $totalTransaksi }} <span class="text-sm font-medium text-gray-500">Nota</span></h3>
            </div>
        </div>
    </div>

    <div class="mb-4 flex justify-end" x-data="{}">
        <button @click="$dispatch('toggle-summary')" class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            <span x-data="{ open: true }" @toggle-summary.window="open = !open" x-text="open ? 'Sembunyikan Ringkasan' : 'Tampilkan Ringkasan'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ showSummary: true }" @toggle-summary.window="showSummary = !showSummary">
        
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-200 p-5 h-fit" 
            x-show="showSummary" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform -translate-x-4"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-x-0"
            x-transition:leave-end="opacity-0 transform -translate-x-4">
            
            <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Rincian Produk Terjual</h3>
            
            @if(count($rekapProduk) > 0)
                <div class="space-y-4">
                    @php $maxQty = $rekapProduk->max('qty'); @endphp
                    @foreach($rekapProduk as $nama => $data)
                        @php $percent = $maxQty > 0 ? ($data['qty'] / $maxQty) * 100 : 0; @endphp
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-sm font-semibold text-gray-700">{{ $nama }}</span>
                                <span class="text-xs font-bold text-gray-900">{{ $data['qty'] }} cup</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ $percent }}%;"></div>
                            </div>
                            <p class="text-xs text-right text-red-600 font-medium">Rp {{ number_format($data['subtotal'], 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-gray-500 text-center py-4">Tidak ada data.</p>
            @endif
        </div>

        <div :class="showSummary ? 'lg:col-span-2' : 'lg:col-span-3'" 
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col transition-all duration-300">
            
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Detail Histori Transaksi</h3>
                <span x-show="!showSummary" class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-md font-bold">Mode Full Width Aktif</span>
            </div>

            <div class="flex-1 overflow-x-auto">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                            <th class="p-4 font-bold">Waktu & Lapak</th>
                            <th class="p-4 font-bold">Tipe</th>
                            <th class="p-4 font-bold">Nama Titipan</th>
                            <th class="p-4 font-bold">Detail Pesanan</th>
                            <th class="p-4 font-bold text-right">Total Transaksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4 text-sm">
                                <p class="font-bold text-gray-800">{{ $trx->stall->tempat }}</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($trx->created_at)->format('d/m/Y H:i') }}</p>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-md {{ $trx->tipe == 'order' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }} uppercase">
                                    {{ $trx->tipe }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-700 font-medium">
                                {{ $trx->nama_titipan ?: '-' }}
                            </td>
                            <td class="p-4">
                                <ul class="text-xs space-y-1">
                                    @foreach($trx->items as $item)
                                    <li class="text-gray-600">
                                        <span class="font-bold text-gray-800">{{ $item->qty }}x</span> 
                                        {{ $item->product ? $item->product->nama : 'Produk Dihapus' }}
                                    </li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="p-4 text-right font-bold text-red-600">
                                Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Belum ada transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>