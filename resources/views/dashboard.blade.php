@extends('layouts.app')

@section('content')

<div class="mb-10">
    <h1 class="text-5xl font-bold text-gray-800">
        Dashboard
    </h1>

    <p class="text-gray-500 mt-3">
        Sistem Manajemen Perpustakaan Digital
    </p>
</div>

<div class="grid grid-cols-3 gap-8">
    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-lg">
                    Total Buku
                </p>

                <h1 class="text-5xl font-bold mt-3 text-gray-800">
                    {{ $totalBooks }}
                </h1>
            </div>

            <div class="w-20 h-20 rounded-3xl bg-blue-500/20 flex items-center justify-center text-4xl shadow-inner">
                📚
            </div>
        </div>

        <p class="text-sm text-green-500 font-medium">
            Koleksi buku tersedia
        </p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-lg">
                    Total Stock
                </p>

                <h1 class="text-5xl font-bold mt-3 text-gray-800">
                    {{ $totalStock }}
                </h1>
            </div>

            <div class="w-20 h-20 rounded-3xl bg-yellow-400/20 flex items-center justify-center text-4xl shadow-inner">
                📦
            </div>
        </div>

        <p class="text-sm text-blue-500 font-medium">
            Total stok seluruh buku
        </p>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-8 hover:scale-[1.02] transition duration-300">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-gray-500 text-lg">
                    Total Kategori
                </p>

                <h1 class="text-5xl font-bold mt-3 text-gray-800">
                    {{ $totalCategory }}
                </h1>
            </div>
            <div class="w-20 h-20 rounded-3xl bg-pink-400/20 flex items-center justify-center text-4xl shadow-inner">
                🏷️
            </div>
        </div>

        <p class="text-sm text-purple-500 font-medium">
            Kategori buku tersedia
        </p>
    </div>
</div>

<div class="grid grid-cols-2 gap-8 mt-10">
    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Statistik Buku
                </h1>

                <p class="text-gray-500 mt-2">
                    Grafik koleksi perpustakaan
                </p>
            </div>

            <div class="text-4xl">
                📈
            </div>
        </div>

        <div class="flex items-end gap-6 h-[250px]">
            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-32 bg-blue-500/70 rounded-t-3xl"></div>
                <span class="text-gray-600">Fiksi</span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-44 bg-cyan-400/70 rounded-t-3xl"></div>
                <span class="text-gray-600">Horror</span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-24 bg-pink-400/70 rounded-t-3xl"></div>
                <span class="text-gray-600">Komik</span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-52 bg-yellow-400/70 rounded-t-3xl"></div>
                <span class="text-gray-600">Novel</span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <div class="w-14 h-36 bg-purple-400/70 rounded-t-3xl"></div>
                <span class="text-gray-600">Sains</span>
            </div>
        </div>
    </div>

    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[32px] p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Aktivitas
                </h1>

                <p class="text-gray-500 mt-2">
                    Aktivitas terbaru perpustakaan
                </p>
            </div>

            <div class="text-4xl">
                🔔
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white/40 rounded-2xl p-5 border border-white/20">
                <h2 class="font-semibold text-gray-800">
                    Buku baru ditambahkan
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Atomic Habits berhasil ditambahkan
                </p>
            </div>

            <div class="bg-white/40 rounded-2xl p-5 border border-white/20">
                <h2 class="font-semibold text-gray-800">
                    Stock diperbarui
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Stock Harry Potter diperbarui
                </p>
            </div>

            <div class="bg-white/40 rounded-2xl p-5 border border-white/20">
                <h2 class="font-semibold text-gray-800">
                    Buku dipinjam
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Novel dipinjam anggota
                </p>
            </div>
        </div>
    </div>
</div>

@endsection