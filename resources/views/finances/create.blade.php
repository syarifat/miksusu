<x-app-layout>
    <x-slot name="header">Tambah Catatan Keuangan</x-slot>

    <div class="max-w-2xl bg-white rounded-xl shadow-sm border border-gray-200 p-6" x-data="{ tipe: 'pengeluaran' }">
        <form action="{{ route('finances.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" value="{{ date('Y-m-d') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi</label>
                    <select name="tipe" x-model="tipe" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 font-semibold" :class="tipe == 'pemasukan' ? 'text-green-600' : 'text-red-600'">
                        <option value="pengeluaran">Pengeluaran</option>
                        <option value="pemasukan">Pemasukan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                        <template x-if="tipe == 'pengeluaran'">
                            <>
                                <option value="Bahan Baku">Bahan Baku</option>
                                <option value="Operasional Lapak">Operasional Lapak</option>
                                <option value="Gaji / Komisi">Gaji / Komisi</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </>
                        </template>
                        <template x-if="tipe == 'pemasukan'">
                            <>
                                <option value="Penjualan Luar">Penjualan Luar (Non-Kasir)</option>
                                <option value="Modal Awal">Modal Awal</option>
                                <option value="Lain-lain">Lain-lain</option>
                            </>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" required min="1" placeholder="Misal: 150000" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Keperluan</label>
                <textarea name="keterangan" rows="3" required placeholder="Jelaskan secara detail..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama PIC (Pengambil / Penyetor)</label>
                <input type="text" name="pic" value="{{ Auth::user()->name }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
            </div>

            <div class="pt-4 flex items-center space-x-3">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors">Simpan Catatan</button>
                <a href="{{ route('finances.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>