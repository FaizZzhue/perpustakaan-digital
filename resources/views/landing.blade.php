<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="bg-gradient-to-br from-[#5aa8ff] to-[#1d4ed8] p-8 shadow-2xl border border-white/20">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-white font-bold text-lg">
                        PERPUSTAKAAN
                    </h1>

                    <p class="text-blue-100 text-sm">
                        Sumatera Selatan
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-10 text-white font-medium">
                <a href="#" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Beranda
                </a>
                <a href="#" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Katalog
                </a>
                <a href="#" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    E-Library
                </a>
                <a href="#" class="hover:text-blue-200 transition focus:outline-none focus:ring-0">
                    Info
                </a>
            </div>

            <a href="/dashboard" class="px-5 py-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white hover:bg-white/20 transition focus:outline-none focus:ring-0">
                Login
            </a>
        </div>

        <div class="text-center py-20">
            <h1 class="text-5xl font-bold text-white leading-tight">
                Selamat Datang di Perpustakaan Digital
            </h1>

            <p class="text-blue-100 text-2xl mt-4">
                Perpustakaan Daerah Sumatera Selatan
            </p>

            <form class="max-w-4xl mx-auto mt-12">
                <div class="bg-white rounded-2xl p-3 flex items-center shadow-2xl">
                    <input type="text" placeholder="Cari buku berdasarkan judul, penulis, ISBN, atau kategori..." class="flex-1 px-5 text-lg outline-none text-gray-700">

                    <button class="w-16 h-16 rounded-2xl bg-blue-600 hover:bg-blue-700 transition text-white text-2xl focus:outline-none focus:ring-0">
                        🔍
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-[30px] p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Koleksi Terbaru
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Buku terbaru perpustakaan digital
                    </p>
                </div>

                <a href="#" class="text-blue-600 font-semibold hover:text-blue-800 transition">
                    Lihat semua 
                </a>
            </div>

            <div class="grid grid-cols-5 gap-6">
                <div class="group">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://picsum.photos/200/300?1" class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h2 class="font-bold text-gray-800 mt-4">
                        Bumi
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Tere Liye
                    </p>

                    <p class="text-green-500 font-semibold mt-3">
                        Tersedia
                    </p>

                </div>

                <div class="group">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://picsum.photos/200/300?2" class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h2 class="font-bold text-gray-800 mt-4">
                        Atomic Habits
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        James Clear
                    </p>

                    <p class="text-green-500 font-semibold mt-3">
                        Tersedia
                    </p>
                </div>

                <div class="group">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://picsum.photos/200/300?3" class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h2 class="font-bold text-gray-800 mt-4">
                        Seni Bersikap Bodo Amat
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Mark Manson
                    </p>

                    <p class="text-green-500 font-semibold mt-3">
                        Tersedia
                    </p>
                </div>

                <div class="group">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://picsum.photos/200/300?4" class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h2 class="font-bold text-gray-800 mt-4">
                        Laskar Pelangi
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Andrea Hirata
                    </p>

                    <p class="text-green-500 font-semibold mt-3">
                        Tersedia
                    </p>

                </div>

                <div class="group">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="https://picsum.photos/200/300?5" class="w-full h-72 object-cover group-hover:scale-105 transition duration-300">
                    </div>

                    <h2 class="font-bold text-gray-800 mt-4">
                        Cara Berpikir Jernih
                    </h2>

                    <p class="text-gray-500 text-sm mt-1">
                        Rolf Dobelli
                    </p>

                    <p class="text-green-500 font-semibold mt-3">
                        Tersedia
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>