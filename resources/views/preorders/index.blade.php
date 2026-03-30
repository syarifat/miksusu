<x-app-layout>
    <x-slot name="header">Rekap Preorder</x-slot>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
            <p class="text-xs font-bold text-gray-400 uppercase">Total Pesanan</p>
            <h3 class="text-2xl font-black text-gray-800 mt-1">{{ $totalPreorders }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-yellow-100 p-4">
            <p class="text-xs font-bold text-yellow-500 uppercase">Pending</p>
            <h3 class="text-2xl font-black text-yellow-600 mt-1">{{ $totalPending }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-4">
            <p class="text-xs font-bold text-green-500 uppercase">Selesai</p>
            <h3 class="text-2xl font-black text-green-600 mt-1">{{ $totalSelesai }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-red-100 p-4">
            <p class="text-xs font-bold text-red-400 uppercase">Omzet Selesai</p>
            <h3 class="text-xl font-black text-red-600 mt-1">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form action="{{ route('preorders.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status</label>
                <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                    <option value="">Semua</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>🔄 Diproses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="batal" {{ request('status') === 'batal' ? 'selected' : '' }}>❌ Batal</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pembayaran</label>
                <select name="pembayaran" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                    <option value="">Semua</option>
                    <option value="cash" {{ request('pembayaran') === 'cash' ? 'selected' : '' }}>💵 Cash</option>
                    <option value="qris" {{ request('pembayaran') === 'qris' ? 'selected' : '' }}>📲 QRIS</option>
                    <option value="transfer" {{ request('pembayaran') === 'transfer' ? 'selected' : '' }}>🏦 Transfer</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pengambilan</label>
                <select name="pengambilan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
                    <option value="">Semua</option>
                    <option value="cod" {{ request('pengambilan') === 'cod' ? 'selected' : '' }}>🤝 COD</option>
                    <option value="ambil" {{ request('pengambilan') === 'ambil' ? 'selected' : '' }}>🏪 Ambil</option>
                    <option value="antar" {{ request('pengambilan') === 'antar' ? 'selected' : '' }}>🚚 Antar</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / Admin..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 text-sm">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-md transition-colors h-[42px] text-sm">
                    🔍 Filter
                </button>
                <a href="{{ route('preorders.index') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-lg transition-colors h-[42px] flex items-center text-sm">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold">#</th>
                        <th class="p-4 font-bold">Waktu</th>
                        <th class="p-4 font-bold">Pelanggan</th>
                        <th class="p-4 font-bold">Admin WA</th>
                        <th class="p-4 font-bold">Produk</th>
                        <th class="p-4 font-bold">Pembayaran</th>
                        <th class="p-4 font-bold">Pengambilan</th>
                        <th class="p-4 font-bold text-right">Total</th>
                        <th class="p-4 font-bold text-center">Status</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($preorders as $po)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 text-sm text-gray-500 font-mono">{{ $po->id }}</td>
                        <td class="p-4 text-sm">
                            <p class="font-semibold text-gray-700">{{ $po->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $po->created_at->format('H:i') }}</p>
                        </td>
                        <td class="p-4">
                            <p class="font-bold text-gray-800 text-sm">{{ $po->nama_pelanggan }}</p>
                        </td>
                        <td class="p-4 text-sm">
                            <p class="font-semibold text-gray-700">{{ $po->admin_nama }}</p>
                            <p class="text-xs text-gray-400">{{ $po->admin_wa }}</p>
                        </td>
                        <td class="p-4">
                            <ul class="text-xs space-y-0.5">
                                @foreach($po->items as $item)
                                <li class="text-gray-600">
                                    <span class="font-bold text-gray-800">{{ $item->qty }}x</span> {{ $item->nama_produk }}
                                </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-4">
                            @php
                                $payBadge = match($po->metode_pembayaran) {
                                    'cash' => 'bg-green-100 text-green-700',
                                    'qris' => 'bg-blue-100 text-blue-700',
                                    'transfer' => 'bg-purple-100 text-purple-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-2 py-1 text-[10px] font-bold rounded-md {{ $payBadge }} uppercase">{{ $po->label_pembayaran }}</span>
                        </td>
                        <td class="p-4">
                            @php
                                $delBadge = match($po->metode_pengambilan) {
                                    'cod' => 'bg-orange-100 text-orange-700',
                                    'ambil' => 'bg-teal-100 text-teal-700',
                                    'antar' => 'bg-indigo-100 text-indigo-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="px-2 py-1 text-[10px] font-bold rounded-md {{ $delBadge }} uppercase">{{ $po->label_pengambilan }}</span>
                        </td>
                        <td class="p-4 text-right font-bold text-red-600 text-sm">
                            Rp {{ number_format($po->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center">
                            @php
                                $statusBadge = match($po->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-green-100 text-green-700',
                                    'batal' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                $statusIcon = match($po->status) {
                                    'pending' => '⏳',
                                    'diproses' => '🔄',
                                    'selesai' => '✅',
                                    'batal' => '❌',
                                    default => '',
                                };
                            @endphp
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-full {{ $statusBadge }} uppercase">{{ $statusIcon }} {{ $po->status }}</span>
                        </td>
                        <td class="p-4 text-center" x-data="{ open: false }">
                            <div class="relative inline-block">
                                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 top-full mt-1 w-40 bg-white border border-gray-200 rounded-xl shadow-lg z-10 py-1" x-cloak>
                                    @foreach(['pending', 'diproses', 'selesai', 'batal'] as $s)
                                        @if($po->status !== $s)
                                        <form action="{{ route('preorders.status', $po) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $s }}">
                                            <button type="submit" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-gray-50 transition-colors cursor-pointer">
                                                → {{ ucfirst($s) }}
                                            </button>
                                        </form>
                                        @endif
                                    @endforeach
                                    <hr class="my-1 border-gray-100">
                                    <form action="{{ route('preorders.destroy', $po) }}" method="POST" onsubmit="return confirm('Hapus preorder ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full px-4 py-2 text-left text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="p-8 text-center text-gray-400">
                            <span class="text-4xl block mb-2">📦</span>
                            <p class="font-semibold">Belum ada preorder masuk</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="md:hidden space-y-3">
        @forelse($preorders as $po)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4" x-data="{ expanded: false }">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-bold text-gray-800">{{ $po->nama_pelanggan }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $po->created_at->format('d/m/Y H:i') }} · #{{ $po->id }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-red-600">Rp {{ number_format($po->total_harga, 0, ',', '.') }}</p>
                    @php
                        $statusBadge = match($po->status) {
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'diproses' => 'bg-blue-100 text-blue-700',
                            'selesai' => 'bg-green-100 text-green-700',
                            'batal' => 'bg-red-100 text-red-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $statusBadge }} uppercase mt-1 inline-block">{{ $po->status }}</span>
                </div>
            </div>

            <div class="mt-3 flex gap-1.5 flex-wrap">
                @php
                    $payBadge = match($po->metode_pembayaran) {
                        'cash' => 'bg-green-100 text-green-700',
                        'qris' => 'bg-blue-100 text-blue-700',
                        'transfer' => 'bg-purple-100 text-purple-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                    $delBadge = match($po->metode_pengambilan) {
                        'cod' => 'bg-orange-100 text-orange-700',
                        'ambil' => 'bg-teal-100 text-teal-700',
                        'antar' => 'bg-indigo-100 text-indigo-700',
                        default => 'bg-gray-100 text-gray-700',
                    };
                @endphp
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md {{ $payBadge }}">{{ $po->label_pembayaran }}</span>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md {{ $delBadge }}">{{ $po->label_pengambilan }}</span>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-gray-100 text-gray-600">{{ $po->admin_nama }}</span>
            </div>

            <button @click="expanded = !expanded" class="mt-2 text-xs text-red-500 font-bold cursor-pointer" x-text="expanded ? 'Sembunyikan ▲' : 'Detail ▼'"></button>

            <div x-show="expanded" x-transition class="mt-3 pt-3 border-t border-gray-100 space-y-3" x-cloak>
                <div>
                    <p class="text-xs font-bold text-gray-500 mb-1">Produk:</p>
                    <ul class="text-xs space-y-0.5">
                        @foreach($po->items as $item)
                        <li class="text-gray-600">{{ $item->qty }}x {{ $item->nama_produk }} — <span class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span></li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex gap-2 flex-wrap">
                    @foreach(['pending', 'diproses', 'selesai', 'batal'] as $s)
                        @if($po->status !== $s)
                        <form action="{{ route('preorders.status', $po) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="{{ $s }}">
                            <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg border border-gray-200 hover:bg-gray-50 text-gray-700 cursor-pointer">→ {{ ucfirst($s) }}</button>
                        </form>
                        @endif
                    @endforeach
                    <form action="{{ route('preorders.destroy', $po) }}" method="POST" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold rounded-lg border border-red-200 bg-red-50 text-red-600 hover:bg-red-100 cursor-pointer">🗑️ Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-400">
            <span class="text-4xl block mb-2">📦</span>
            <p class="font-semibold">Belum ada preorder masuk</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $preorders->links() }}
    </div>
</x-app-layout>
