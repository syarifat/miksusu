<style>
    /* Styling khusus untuk scrollbar di menu navigasi agar lebih elegan */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #ef4444; /* warna merah (red-500) yang menyatu dengan background */
        border-radius: 10px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #fca5a5; /* saat kursor di atas navigasi, scrollbar akan sedikit lebih terang */
    }
    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #ef4444 transparent;
    }
</style>

<div x-show="sidebarOpen" 
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900 bg-opacity-50 z-20 lg:hidden" 
     @click="sidebarOpen = false" style="display: none;">
</div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-30 w-64 bg-red-700 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col">
    
    <div class="flex items-center justify-center h-16 bg-red-800 shadow-md shrink-0">
        <a href="{{ route('dashboard') }}">
            <h1 class="text-2xl font-bold tracking-wider">MIKSUSU<span class="text-red-300">.</span></h1>
        </a>
    </div>

    <!-- Gunakan custom-scrollbar di sini -->
    <nav class="mt-4 pb-8 space-y-1 flex-1 overflow-y-auto custom-scrollbar">
        
        <!-- ================= KATEGORI UTAMA ================= -->
        <p class="text-xs font-bold text-red-300 uppercase tracking-widest mb-2 mt-4 px-6">Utama</p>
        <div class="px-3 space-y-1">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
            @endif
            
            <a href="{{ route('pos.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('pos.*') ? 'bg-red-500 shadow-inner bg-opacity-80 border border-red-400' : 'hover:bg-red-600 border border-transparent' }}">
                <span class="font-bold text-sm tracking-wide">POS Kasir</span>
            </a>
        </div>

        @if(auth()->user()->role === 'admin')
            <!-- ================= KATEGORI OPERASIONAL ================= -->
            <p class="text-xs font-bold text-red-300 uppercase tracking-widest mb-2 mt-8 px-6">Operasional Bisnis</p>
            <div class="px-3 space-y-1">
                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Data Master Produk</span>
                </a>
                
                <a href="{{ route('stalls.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('stalls.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Manajemen Lapak</span>
                </a>
                
                <a href="{{ route('preorders.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('preorders.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Rekap Preorder</span>
                </a>
            </div>

            <!-- ================= KATEGORI KEUANGAN ================= -->
            <p class="text-xs font-bold text-red-300 uppercase tracking-widest mb-2 mt-8 px-6">Keuangan & Laporan</p>
            <div class="px-3 space-y-1">
                <a href="{{ route('finances.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('finances.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Catatan Penghasilan</span>
                </a>
                
                <a href="{{ route('finance-categories.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('finance-categories.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Kategori Transaksi</span>
                </a>
                
                <a href="{{ route('reports.sales') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('reports.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Laporan Penjualan (PDF)</span>
                </a>
            </div>

            <!-- ================= KATEGORI SISTEM ================= -->
            <p class="text-xs font-bold text-red-300 uppercase tracking-widest mb-2 mt-8 px-6">Sistem Keamanan</p>
            <div class="px-3 space-y-1">
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('users.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Kelola Akun Kasir</span>
                </a>
                
                <a href="{{ route('activity-logs.index') }}" class="flex items-center px-4 py-2.5 rounded-lg transition-colors {{ request()->routeIs('activity-logs.*') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
                    <span class="font-medium text-sm">Riwayat Aktivitas Log</span>
                </a>
            </div>
        @endif
        
    </nav>

    <div class="p-4 bg-red-800 border-t border-red-600 shrink-0">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 rounded-full bg-red-500 border-2 border-white flex items-center justify-center font-bold text-lg">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="ml-3 truncate">
                <p class="text-sm font-medium truncate">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-red-300 truncate">{{ ucfirst(Auth::user()->role ?? 'admin') }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-center px-4 py-2.5 bg-red-900 border border-red-700 hover:bg-red-950 rounded-lg text-sm text-red-200 hover:text-white font-bold tracking-wide shadow-inner transition-colors">
                Keluar Aplikasi
            </button>
        </form>
    </div>
</aside>