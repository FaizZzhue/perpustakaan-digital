@extends('layouts.app')

@section('content')

<div class="mb-8 md:mb-10">
    <h1 class="text-3xl md:text-5xl font-bold text-gray-800">
        Dashboard
    </h1>
    <p class="text-sm md:text-base text-gray-500 mt-2 md:mt-3">
        Sistem Manajemen Perpustakaan Digital
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Total Buku</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalBooks }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-blue-500/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                📚
            </div>
        </div>
        <p class="text-xs md:text-sm text-green-500 font-medium">Koleksi buku tersedia</p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Total Stock</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalStock }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-yellow-400/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                📦
            </div>
        </div>
        <p class="text-xs md:text-sm text-blue-500 font-medium">Total stok seluruh buku</p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Total Kategori</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalCategory }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-pink-400/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                🏷️
            </div>
        </div>
        <p class="text-xs md:text-sm text-purple-500 font-medium">Kategori buku tersedia</p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Total Anggota</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalMembers }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-green-500/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                👤
            </div>
        </div>
        <p class="text-xs md:text-sm text-green-500 font-medium">Anggota perpustakaan terdaftar</p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Total Peminjaman</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalBorrows }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-cyan-400/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                📖
            </div>
        </div>
        <p class="text-xs md:text-sm text-cyan-500 font-medium">Transaksi peminjaman tercatat</p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-sm md:text-lg">Denda Belum Lunas</p>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 md:mt-3 text-gray-800">
                    {{ $totalFines }}
                </h1>
            </div>
            <div class="w-16 h-16 md:w-20 md:h-20 rounded-3xl bg-red-400/20 flex items-center justify-center text-3xl md:text-4xl shadow-inner">
                💰
            </div>
        </div>
        <p class="text-xs md:text-sm text-red-500 font-medium">Denda menunggu pembayaran</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 mt-8 md:mt-10">
    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8 overflow-hidden">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Statistik Buku</h1>
                <p class="text-sm md:text-base text-gray-500 mt-1 md:mt-2">Jumlah buku per kategori</p>
            </div>
            <div class="text-3xl md:text-4xl">📈</div>
        </div>

        @if($categoryStats->count() > 0)
            @php
                $maxCategory = $categoryStats->max('total');
                $barColors = [
                    'bg-blue-500/70', 'bg-cyan-400/70', 'bg-pink-400/70', 'bg-yellow-400/70',
                    'bg-purple-400/70', 'bg-green-400/70', 'bg-red-400/70', 'bg-indigo-400/70',
                    'bg-orange-400/70', 'bg-teal-400/70',
                ];
            @endphp
            <div class="flex items-end gap-4 h-[250px] overflow-x-auto pb-2 scrollbar-hide w-full">
                @foreach($categoryStats as $index => $cat)
                    @php
                        $barHeight = $maxCategory > 0 ? max(($cat->total / $maxCategory) * 200, 20) : 20;
                        $color = $barColors[$index % count($barColors)];
                    @endphp
                    <div class="flex flex-col items-center gap-2 min-w-[48px] md:min-w-[56px]">
                        <span class="text-xs font-bold text-gray-700">{{ $cat->total }}</span>
                        <div class="w-10 md:w-14 {{ $color }} rounded-t-3xl transition-all duration-500 hover:opacity-80" style="height: {{ $barHeight }}px"></div>
                        <span class="text-gray-600 text-[10px] md:text-xs text-center leading-tight truncate w-full px-1" title="{{ $cat->category }}">{{ $cat->category }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="flex items-center justify-center h-[250px] text-gray-500 text-sm md:text-base">
                Belum ada data buku.
            </div>
        @endif
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-6 md:p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-800">Aktivitas</h1>
                <p class="text-sm md:text-base text-gray-500 mt-1 md:mt-2">Aktivitas terbaru perpustakaan</p>
            </div>
            <div class="text-3xl md:text-4xl">🔔</div>
        </div>

        <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
            @forelse($activities as $activity)
                <div class="bg-white/40 rounded-2xl p-4 border border-white/20 hover:bg-white/60 transition duration-200">
                    <div class="flex items-start gap-3">
                        <span class="text-xl md:text-2xl">{{ $activity['icon'] }}</span>
                        <div class="flex-1 min-w-0">
                            <h2 class="font-semibold text-gray-800 text-sm md:text-base truncate">
                                {{ $activity['label'] }}
                            </h2>
                            <p class="text-gray-500 text-xs mt-0.5 truncate">
                                {{ $activity['description'] }}
                            </p>
                        </div>
                        <span class="text-[10px] md:text-xs text-gray-400 whitespace-nowrap flex-shrink-0">
                            {{ $activity['created_at'] ? \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() : '' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-8 text-sm md:text-base">
                    Belum ada aktivitas.
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection