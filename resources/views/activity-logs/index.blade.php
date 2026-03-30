<x-app-layout>
    <x-slot name="header">
        Log Aktivitas
    </x-slot>

    {{-- Filter Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 md:p-5 mb-5">
        <form method="GET" action="{{ route('activity-logs.index') }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                {{-- Search --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi/user..."
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                </div>

                {{-- Modul --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Modul</label>
                    <select name="modul" class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Modul</option>
                        @foreach($modulList as $m)
                            <option value="{{ $m }}" {{ request('modul') === $m ? 'selected' : '' }}>{{ ucfirst($m) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Aksi --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Aksi</label>
                    <select name="aksi" class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Semua Aksi</option>
                        @foreach($aksiList as $a)
                            <option value="{{ $a }}" {{ request('aksi') === $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full border-gray-300 rounded-lg text-sm focus:ring-red-500 focus:border-red-500">
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg text-sm transition-colors">
                    🔍 Filter
                </button>
                <a href="{{ route('activity-logs.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg text-sm transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Info Total --}}
    <div class="mb-4 text-sm text-gray-500 font-medium">
        Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log
    </div>

    {{-- Mobile Card View --}}
    <div class="space-y-3 lg:hidden">
        @forelse($logs as $log)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
            <div class="flex items-start justify-between mb-2">
                <div class="flex items-center gap-2">
                    @php
                        $aksiColors = [
                            'login' => 'bg-green-100 text-green-700',
                            'logout' => 'bg-gray-100 text-gray-700',
                            'create' => 'bg-blue-100 text-blue-700',
                            'update' => 'bg-yellow-100 text-yellow-700',
                            'delete' => 'bg-red-100 text-red-700',
                            'export' => 'bg-purple-100 text-purple-700',
                            'toggle' => 'bg-orange-100 text-orange-700',
                        ];
                        $aksiColor = $aksiColors[$log->aksi] ?? 'bg-gray-100 text-gray-700';
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $aksiColor }}">
                        {{ strtoupper($log->aksi) }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                        {{ ucfirst($log->modul) }}
                    </span>
                </div>
                <span class="text-xs text-gray-400">{{ $log->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <p class="text-sm text-gray-800 font-medium">{{ $log->deskripsi }}</p>
            <p class="text-xs text-gray-400 mt-1">
                oleh <span class="font-semibold text-gray-600">{{ $log->user->name ?? 'System' }}</span>
                · {{ $log->ip_address }}
            </p>

            @if($log->data_lama || $log->data_baru)
            <details class="mt-2">
                <summary class="text-xs text-red-500 font-semibold cursor-pointer hover:text-red-700">Lihat Detail Data</summary>
                <div class="mt-2 text-xs space-y-1 bg-gray-50 rounded-lg p-3">
                    @if($log->data_lama)
                        <div>
                            <span class="font-bold text-gray-500">Data Lama:</span>
                            <pre class="text-gray-600 whitespace-pre-wrap break-all mt-0.5">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                    @if($log->data_baru)
                        <div>
                            <span class="font-bold text-gray-500">Data Baru:</span>
                            <pre class="text-gray-600 whitespace-pre-wrap break-all mt-0.5">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                </div>
            </details>
            @endif
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center text-gray-500">
            Belum ada log aktivitas.
        </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden lg:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-red-50 text-red-800 border-b border-gray-200">
                    <th class="p-4 font-semibold text-sm">Waktu</th>
                    <th class="p-4 font-semibold text-sm">User</th>
                    <th class="p-4 font-semibold text-sm">Aksi</th>
                    <th class="p-4 font-semibold text-sm">Modul</th>
                    <th class="p-4 font-semibold text-sm">Deskripsi</th>
                    <th class="p-4 font-semibold text-sm">IP</th>
                    <th class="p-4 font-semibold text-sm text-center">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="p-4 text-sm text-gray-500 whitespace-nowrap">
                        <div class="font-medium text-gray-700">{{ $log->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td class="p-4 text-sm font-medium text-gray-800">
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td class="p-4">
                        @php
                            $aksiColors = [
                                'login' => 'bg-green-100 text-green-700',
                                'logout' => 'bg-gray-100 text-gray-700',
                                'create' => 'bg-blue-100 text-blue-700',
                                'update' => 'bg-yellow-100 text-yellow-700',
                                'delete' => 'bg-red-100 text-red-700',
                                'export' => 'bg-purple-100 text-purple-700',
                                'toggle' => 'bg-orange-100 text-orange-700',
                            ];
                            $aksiColor = $aksiColors[$log->aksi] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $aksiColor }}">
                            {{ strtoupper($log->aksi) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            {{ ucfirst($log->modul) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm text-gray-700 max-w-xs truncate" title="{{ $log->deskripsi }}">
                        {{ $log->deskripsi }}
                    </td>
                    <td class="p-4 text-xs text-gray-400 font-mono">{{ $log->ip_address }}</td>
                    <td class="p-4 text-center">
                        @if($log->data_lama || $log->data_baru)
                        <button
                            onclick="document.getElementById('detail-{{ $log->id }}').classList.toggle('hidden')"
                            class="px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg text-xs font-semibold transition-colors">
                            📋 Data
                        </button>
                        @else
                        <span class="text-xs text-gray-300">—</span>
                        @endif
                    </td>
                </tr>
                @if($log->data_lama || $log->data_baru)
                <tr id="detail-{{ $log->id }}" class="hidden bg-gray-50">
                    <td colspan="7" class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                            @if($log->data_lama)
                            <div>
                                <span class="font-bold text-red-500 block mb-1">🔴 Data Lama:</span>
                                <pre class="bg-white border border-gray-200 rounded-lg p-3 text-gray-600 whitespace-pre-wrap break-all overflow-auto max-h-48">{{ json_encode($log->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            @endif
                            @if($log->data_baru)
                            <div>
                                <span class="font-bold text-green-500 block mb-1">🟢 Data Baru:</span>
                                <pre class="bg-white border border-gray-200 rounded-lg p-3 text-gray-600 whitespace-pre-wrap break-all overflow-auto max-h-48">{{ json_encode($log->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">Belum ada log aktivitas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($logs->hasPages())
    <div class="mt-5">
        {{ $logs->links() }}
    </div>
    @endif

</x-app-layout>
