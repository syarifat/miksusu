<x-app-layout>
    <x-slot name="header">Edit Catatan Keuangan</x-slot>

    <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('finances.update', $finance->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" value="{{ $finance->tanggal_transaksi->format('Y-m-d') }}" required class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                    <select name="tipe" class="w-full border-gray-300 rounded-lg shadow-sm">
                        <option value="pengeluaran" {{ $finance->tipe == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        <option value="pemasukan" {{ $finance->tipe == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori (Ubah manual jika perlu)</label>
                    <input type="text" name="kategori" value="{{ $finance->kategori }}" required class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" value="{{ $finance->nominal }}" required min="1" class="w-full border-gray-300 rounded-lg shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Keperluan</label>
                <textarea name="keterangan" rows="3" required class="w-full border-gray-300 rounded-lg shadow-sm">{{ $finance->keterangan }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC</label>
                <input type="text" name="pic" value="{{ $finance->pic }}" required class="w-full border-gray-300 rounded-lg shadow-sm">
            </div>

            <div class="pt-4 flex items-center space-x-3">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors">Update Catatan</button>
                <a href="{{ route('finances.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>