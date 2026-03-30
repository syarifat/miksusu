<x-app-layout>
    <x-slot name="header">Edit User (Pengguna)</x-slot>

    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-2">Edit Data User</h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input id="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Username Login -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username Login</label>
                <input id="username" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="text" name="username" value="{{ old('username', $user->username) }}" required placeholder="Tanpa spasi, contoh: budi123">
                @error('username') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Hak Akses (Role) -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Hak Akses (Role)</label>
                <!-- Cegah admin mengganti role dirinya sendiri! -->
                <select id="role" name="role" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" required>
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>🧑‍💼 KASIR (Akses hanya Menu POS saja)</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>👑 ADMIN (Akses penuh ke semua menu sistem)</option>
                </select>
                @error('role') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                @if(auth()->id() === $user->id)
                    <p class="text-xs text-orange-500 mt-1 font-semibold block">Peringatan: Jika Anda mengubah role akun ini (milik Anda) ke Kasir, Anda akan langsung kehilangan akses ke dashboard & menu kelola.</p>
                @endif
            </div>

            <hr class="my-4 border-gray-200">

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-bold text-gray-700 mb-3">Ubah Password (Kosongkan jika tidak ingin mengubah password)</h4>
                
                <div class="space-y-4">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <input id="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="password" name="password" autocomplete="new-password">
                        @error('password') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <input id="password_confirmation" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500" type="password" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation') <span class="text-red-600 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center space-x-3 border-t border-gray-100 mt-6">
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors w-full md:w-auto">
                    Simpan Perubahan
                </button>
                <a href="{{ route('users.index') }}" class="px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg transition-colors text-center w-full md:w-auto">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
