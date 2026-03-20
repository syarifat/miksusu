<x-app-layout>
    <x-slot name="header">Kelola Keuangan</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-green-500 p-4">
            <p class="text-sm font-semibold text-gray-500 mb-1">Total Pemasukan</p>
            <h3 class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-red-500 p-4">
            <p class="text-sm font-semibold text-gray-500 mb-1">Total Pengeluaran</p>
            <h3 class="text-2xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white rounded-xl shadow-sm border-l-4 border-blue-500 p-4">
            <p class="text-sm font-semibold text-gray-500 mb-1">Saldo Bersih</p>
            <h3 class="text-2xl font-bold text-blue-600">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
        </div>
    </div>

    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Riwayat Transaksi</h2>
        <a href="{{ route('finances.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors text-sm">
            + Catat Transaksi
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-x-auto">
        <table class="w-full text-left border-collapse whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 text-gray-700 border-b border-gray-200 text-sm">
                    <th class="p-4 font-semibold">Tanggal</th>
                    <th class="p-4 font-semibold">Kategori</th>
                    <th class="p-4 font-semibold">Keterangan</th>
                    <th class="p-4 font-semibold">PIC</th>
                    <th class="p-4 font-semibold text-right">Nominal</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($finances as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 text-gray-800 text-sm">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->translatedFormat('d M Y') }}</td>
                    <td class="p-4">
                        <span class="px-2 py-1 text-xs font-bold rounded-md {{ $item->tipe == 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="p-4 text-gray-600 text-sm whitespace-normal min-w-[200px]">{{ $item->keterangan }}</td>
                    <td class="p-4 text-gray-800 text-sm">{{ $item->pic }}</td>
                    <td class="p-4 font-bold text-right {{ $item->tipe == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $item->tipe == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ route('finances.edit', $item->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('finances.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin menghapus data ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">Belum ada catatan keuangan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>