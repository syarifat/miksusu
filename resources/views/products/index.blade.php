<x-app-layout>
    <x-slot name="header">
        Data Master Produk
    </x-slot>

    <div class="mb-4 flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
        <a href="{{ route('products.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors text-sm">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:hidden">
        @foreach($products as $item)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex items-center space-x-4">
            <div class="w-16 h-16 rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden">
                @if($item->foto_url)
                    <img src="{{ asset('storage/' . $item->foto_url) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">No Img</div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-gray-800">{{ $item->nama }}</h3>
                <p class="text-red-600 font-semibold">Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</p>
                <div class="mt-2 flex space-x-2">
                    <a href="{{ route('products.edit', $item->id) }}" class="text-sm text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('products.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-red-50 text-red-800 border-b border-gray-200">
                    <th class="p-4 font-semibold">Foto</th>
                    <th class="p-4 font-semibold">Nama Produk</th>
                    <th class="p-4 font-semibold">Harga Saat Ini</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $item)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 w-20">
                        @if($item->foto_url)
                            <img src="{{ asset('storage/' . $item->foto_url) }}" alt="Foto" class="w-12 h-12 rounded-lg object-cover border">
                        @else
                            <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-400 border">Kosong</div>
                        @endif
                    </td>
                    <td class="p-4 font-medium text-gray-800">{{ $item->nama }}</td>
                    <td class="p-4 text-red-600 font-semibold">Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</td>
                    <td class="p-4 text-center space-x-2">
                        <a href="{{ route('products.edit', $item->id) }}" class="px-3 py-1 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-md text-sm transition-colors">Edit</a>
                        <form action="{{ route('products.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md text-sm transition-colors">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>