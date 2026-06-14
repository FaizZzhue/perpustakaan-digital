<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku: {{ $book->title }} - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-[#f8fafc] to-[#e2e8f0] min-h-screen">
    <!-- Header -->
    <div class="bg-gradient-to-br from-[#5aa8ff] to-[#1d4ed8] p-8 shadow-2xl border-b border-white/20">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div>
                    <h1 class="text-white font-bold text-lg tracking-wider">
                        PERPUSTAKAAN
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Sumatera Selatan
                    </p>
                </div>
            </a>

            <div class="flex items-center gap-10 text-white font-medium">
                <a href="/" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Beranda
                </a>
                <a href="/#katalog" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Katalog
                </a>
                <a href="/ebooks" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    E-Library
                </a>
                <a href="/#contact" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Kontak
                </a>
            </div>

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="/dashboard" class="px-5 py-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white hover:bg-white/20 transition focus:outline-none focus:ring-0">
                        Dashboard
                    </a>
                @else
                    <a href="/member/dashboard" class="px-5 py-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white hover:bg-white/20 transition focus:outline-none focus:ring-0">
                        Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="px-5 py-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white hover:bg-white/20 transition focus:outline-none focus:ring-0">
                    Login
                </a>
            @endauth
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-4xl mx-auto py-12 px-6">
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[30px] p-8 md:p-12 shadow-2xl flex flex-col md:flex-row gap-10">
            <!-- Book Cover -->
            <div class="w-full md:w-1/3 flex justify-center">
                <div class="rounded-2xl overflow-hidden shadow-2xl border border-gray-100 max-w-[240px] h-[340px] relative group">
                    <img src="https://picsum.photos/seed/book-{{ $book->id }}/300/450" alt="{{ $book->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-semibold px-2.5 py-1 rounded bg-blue-600/80 backdrop-blur-sm">Cover Buku</span>
                    </div>
                </div>
            </div>

            <!-- Book Info -->
            <div class="w-full md:w-2/3 flex flex-col justify-between">
                <div>
                    <!-- Category Badge -->
                    <span class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 border border-blue-100 mb-4 uppercase tracking-wider">
                        {{ $book->category }}
                    </span>

                    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight">
                        {{ $book->title }}
                    </h1>

                    <p class="text-lg text-gray-500 mt-2 font-medium">
                        Oleh: <span class="text-blue-600">{{ $book->author }}</span>
                    </p>

                    <div class="mt-8 border-t border-gray-100 pt-6 space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-medium">Kategori</span>
                            <span class="text-gray-700 font-semibold text-right">{{ $book->category }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-medium">Ketersediaan Stok</span>
                            <span class="text-gray-700 font-semibold text-right">{{ $book->stock }} Eksemplar</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-medium">Status</span>
                            @if($book->stock > 0)
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-600 border border-green-200">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-100 flex items-center gap-4">
                    <a href="/" class="flex-1 text-center py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg hover:shadow-blue-500/30 transition-all duration-300">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center py-8 text-sm text-gray-500">
        &copy; 2026 Perpustakaan Digital Daerah Sumatera Selatan. All rights reserved.
    </div>
</body>
</html>
