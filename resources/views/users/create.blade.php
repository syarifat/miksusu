<x-app-layout>
    <x-slot name="header">Tambah User (Pengguna Baru)</x-slot>

    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Form Pendaftaran User</h2>

        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso">
                @error('name') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Username Login -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username Login</label>
                <input id="username" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="text" name="username" value="{{ old('username') }}" required placeholder="Tanpa spasi, contoh: budi123">
                @error('username') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Hak Akses (Role) -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role)</label>
                <select id="role" name="role" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    <option value="" disabled selected>-- Pilih Role Akses --</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>🧑‍💼 KASIR (Akses hanya Menu POS saja)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👑 ADMIN (Akses penuh ke semua menu sistem)</option>
                </select>
                @error('role') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="password" name="password" required autocomplete="new-password">
                @error('password') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input id="password_confirmation" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="password" name="password_confirmation" required autocomplete="new-password">
                @error('password_confirmation') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 flex items-center space-x-3 border-t border-gray-100">
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md transition-colors w-full md:w-auto">
                    Simpan User Baru
                </button>
                <a href="{{ route('users.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors text-center w-full md:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
