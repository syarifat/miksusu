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
    
    <div class="flex items-center justify-center h-16 bg-red-800 shadow-md">
        <a href="{{ route('dashboard') }}">
            <h1 class="text-2xl font-bold tracking-wider">MIKSUSU<span class="text-red-300">.</span></h1>
        </a>
    </div>

    <nav class="mt-6 px-4 space-y-2 flex-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
            <span class="font-medium">Dashboard</span>
        </a>
        
        <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-red-600">
            <span class="font-medium">Data Master Produk</span>
        </a>

        <a href="{{ route('stalls.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-red-600">
            <span class="font-medium">Kelola Lapak</span>
        </a>

        <a href="{{ route('pos.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-red-600">
            <span class="font-medium">POS Kasir</span>
        </a>

        <a href="{{ route('finances.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors hover:bg-red-600">
            <span class="font-medium">Kelola Keuangan</span>
        </a>
        <a href="{{ route('reports.sales') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('reports.sales') ? 'bg-red-500 shadow-inner' : 'hover:bg-red-600' }}">
            <span class="font-medium">Laporan Penjualan</span>
        </a>
    </nav>

    <div class="p-4 bg-red-800 border-t border-red-600">
        <div class="flex items-center mb-4">
            <div class="w-10 h-10 rounded-full bg-red-500 border-2 border-white flex items-center justify-center font-bold text-lg">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs text-red-300">{{ Auth::user()->username ?? 'admin' }}</p>
            </div>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-4 py-2 bg-red-900 hover:bg-red-950 rounded-lg text-sm transition-colors text-red-200 hover:text-white flex items-center justify-center font-medium">
                Log Out
            </button>
        </form>
    </div>
</aside>