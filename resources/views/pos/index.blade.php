<x-app-layout>
    <x-slot name="header">Menu POS (Pilih Lapak)</x-slot>

    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-2">Pilih Lapak yang Sedang Buka</h2>
        <p class="text-gray-500 mb-6">Silakan pilih lapak aktif di bawah ini untuk mulai mencatat penjualan.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($stalls as $stall)
            <a href="{{ route('pos.create', $stall->id) }}" class="block p-5 bg-red-50 hover:bg-red-100 border-2 border-red-200 hover:border-red-500 rounded-xl transition-all group">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-red-800 group-hover:text-red-900">{{ $stall->tempat }}</h3>
                    <span class="px-2 py-1 bg-red-600 text-white text-xs font-bold rounded-md animate-pulse">AKTIF</span>
                </div>
                <p class="text-sm text-red-600 font-medium">{{ \Carbon\Carbon::parse($stall->tanggal)->translatedFormat('l, d M Y') }}</p>
                <div class="mt-4 flex items-center text-sm text-red-700 font-bold">
                    Buka Mesin Kasir 
                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
            @empty
            <div class="col-span-full p-6 text-center border-2 border-dashed border-gray-300 rounded-xl bg-gray-50">
                <p class="text-gray-500 mb-3">Tidak ada lapak yang sedang aktif saat ini.</p>
                <a href="{{ route('stalls.create') }}" class="inline-block px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-semibold hover:bg-gray-900">Buka Lapak Dulu</a>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>