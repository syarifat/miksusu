<x-app-layout>
    <x-slot name="header">Kategori Keuangan</x-slot>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card Form Tambah --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-red-50 p-4 border-b border-red-100">
                    <h3 class="font-bold text-red-800">Tambah Kategori Baru</h3>
                </div>
                <div class="p-4">
                    <form action="{{ route('finance-categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Tipe</label>
                            <select name="tipe" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="pemasukan">🟢 Pemasukan</option>
                                <option value="pengeluaran">🔴 Pengeluaran</option>
                            </select>
                            @error('tipe')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Kategori</label>
                            <input type="text" name="nama_kategori" required placeholder="Contoh: Gaji Karyawan" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                            @error('nama_kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition-colors">
                            Simpan Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table List --}}
        <div class="md:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 border-b border-gray-200 text-sm">
                            <th class="p-4 font-semibold w-12 text-center">No</th>
                            <th class="p-4 font-semibold">Tipe</th>
                            <th class="p-4 font-semibold w-full">Nama Kategori</th>
                            <th class="p-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $index => $item)
                        <tr class="hover:bg-gray-50 transition-colors" x-data="{ editing: false }">
                            <td class="p-4 text-center text-gray-500 text-sm">{{ $index + 1 }}</td>
                            
                            {{-- View Mode --}}
                            <td class="p-4" x-show="!editing">
                                <span class="px-2 py-1 text-xs font-bold rounded-md {{ $item->tipe == 'pemasukan' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ ucfirst($item->tipe) }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-gray-800 text-sm" x-show="!editing">
                                {{ $item->nama_kategori }}
                            </td>
                            <td class="p-4 text-center space-x-2" x-show="!editing">
                                <button @click="editing = true" class="text-blue-600 hover:underline text-sm font-semibold">Edit</button>
                                <form action="{{ route('finance-categories.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin menghapus kategori ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-sm font-semibold">Hapus</button>
                                </form>
                            </td>

                            {{-- Edit Mode --}}
                            <td colspan="3" class="p-4" x-show="editing" style="display: none;">
                                <form action="{{ route('finance-categories.update', $item) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <select name="tipe" class="border-gray-300 rounded-lg text-sm w-40">
                                        <option value="pemasukan" {{ $item->tipe == 'pemasukan' ? 'selected' : '' }}>🟢 Pemasukan</option>
                                        <option value="pengeluaran" {{ $item->tipe == 'pengeluaran' ? 'selected' : '' }}>🔴 Pengeluaran</option>
                                    </select>
                                    <input type="text" name="nama_kategori" value="{{ $item->nama_kategori }}" class="flex-1 border-gray-300 rounded-lg text-sm" required>
                                    <button type="submit" class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-bold">Simpan</button>
                                    <button type="button" @click="editing = false" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg text-sm font-bold">Batal</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">Belum ada kategori terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
