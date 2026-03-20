<x-app-layout>
    <x-slot name="header">Kelola Lapak</x-slot>

    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Lapak</h2>
        <a href="{{ route('stalls.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors text-sm">
            + Buka Lapak Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($stalls as $stall)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
            <div class="{{ $stall->status == 'aktif' ? 'bg-red-600' : 'bg-gray-600' }} px-4 py-3 text-white flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">{{ $stall->tempat }}</h3>
                    <p class="text-xs text-red-100">{{ \Carbon\Carbon::parse($stall->tanggal)->translatedFormat('l, d M Y') }}</p>
                </div>
                <span class="px-2 py-1 text-xs font-bold rounded-md {{ $stall->status == 'aktif' ? 'bg-white text-red-600' : 'bg-gray-800 text-white' }} uppercase">
                    {{ $stall->status }}
                </span>
            </div>

            <div class="p-4 flex-1">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Barang Bawaan:</h4>
                <ul class="space-y-2 text-sm">
                    @forelse($stall->stallProducts as $sp)
                    <li class="flex justify-between items-center border-b border-gray-100 pb-1">
                        <span class="text-gray-700">{{ $sp->product->nama }}</span>
                        <div class="text-right">
                            <span class="font-bold text-gray-900">{{ $sp->stok_sisa }}</span>
                            <span class="text-xs text-gray-400">/ {{ $sp->stok_dibawa }}</span>
                        </div>
                    </li>
                    @empty
                    <li class="text-gray-400 italic">Tidak ada barang yang dicatat.</li>
                    @endforelse
                </ul>
            </div>

            <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex justify-between space-x-2">
                <form action="{{ route('stalls.toggle-status', $stall->id) }}" method="POST" class="flex-1">
                    @csrf @method('PATCH')
                    @if($stall->status == 'aktif')
                        <button type="submit" onclick="return confirm('Akhiri lapak ini? Transaksi tidak bisa ditambah lagi ke lapak ini nantinya.');" class="w-full py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-semibold transition-colors">Selesaikan Lapak</button>
                    @else
                        <button type="submit" onclick="return confirm('Buka kembali lapak ini?');" class="w-full py-2 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 rounded-lg text-sm font-semibold transition-colors">Buka Kembali</button>
                    @endif
                </form>

                <form action="{{ route('stalls.destroy', $stall->id) }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Yakin menghapus histori lapak ini secara permanen?');" class="py-2 px-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg text-sm font-semibold transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full p-8 text-center bg-white rounded-xl border border-gray-200">
            <p class="text-gray-500">Belum ada data lapak. Silakan buka lapak baru.</p>
        </div>
        @endforelse
    </div>
</x-app-layout>