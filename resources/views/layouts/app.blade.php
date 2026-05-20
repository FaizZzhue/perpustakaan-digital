<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#dfe9f3] via-[#ffffff] to-[#d6e4ff]">

    <div class="flex min-h-screen">
        <div class="w-72 bg-[#071739]/90 backdrop-blur-2xl text-white p-6 flex flex-col justify-between shadow-2xl">
            <div>
                <div class="mb-12">
                    <h1 class="text-3xl font-bold tracking-wide">PerpusDigital</h1>
                    <p class="text-sm text-blue-200 mt-2">Sistem Manajemen Perpustakaan</p>
                </div>

                <ul class="space-y-4">
                    <li>
                        <a href="/dashboard" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('dashboard') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="/books" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('books*') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Buku
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('#') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Anggota
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('#') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Peminjaman
                        </a>
                    </li>

                    <li>
                        <a href="#" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('#') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            E-Library
                        </a>
                    </li>
                </ul>
            </div>

            <!-- <div class="bg-white/10 border border-white/10 backdrop-blur-xl p-4 rounded-2xl">
                <h2 class="font-semibold">Admin</h2>
                <p class="text-sm text-gray-300">Perpustakaan Sumsel</p>
            </div> -->
        </div>

        <div class="flex-1 p-10">
            @yield('content')
        </div>
    </div>

</body>
</html>