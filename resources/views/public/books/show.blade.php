<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku: {{ $book->title }} - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">

    <header class="bg-gradient-to-r from-blue-700 to-blue-900 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-5 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <!-- <div class="bg-white/10 p-2 rounded-lg border border-white/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div> -->
                <div>
                    <h1 class="text-white font-bold tracking-wide">PERPUSTAKAAN</h1>
                    <p class="text-blue-200 text-[10px] font-bold uppercase tracking-widest">Sumatera Selatan</p>
                </div>
            </a>
            <a href="/" class="text-white/80 hover:text-white text-sm font-medium transition">Kembali ke Beranda</a>
        </div>
    </header>

    <main class="flex-grow max-w-5xl mx-auto w-full px-6 py-12">
        <div class="bg-white rounded-[2rem] p-8 md:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-gray-100 flex flex-col md:flex-row gap-10">
            
            <div class="w-full md:w-1/3 shrink-0">
                <div class="relative group rounded-3xl overflow-hidden shadow-2xl aspect-[2/3]">
                    <img src="https://picsum.photos/seed/book-{{ $book->id }}/400/600" 
                         alt="{{ $book->title }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
            </div>

            <div class="flex flex-col">
                <div class="mb-6">
                    <span class="inline-block px-4 py-1 rounded-full text-[10px] font-extrabold bg-blue-50 text-blue-600 uppercase tracking-widest border border-blue-100 mb-4">
                        {{ $book->category }}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-3">
                        {{ $book->title }}
                    </h1>
                    <p class="text-lg text-gray-500 font-medium">
                        Karya <span class="text-gray-900 font-semibold">{{ $book->author }}</span>
                    </p>
                </div>

                <div class="space-y-4 mb-10">
                    <div class="grid grid-cols-2 py-3 border-b border-gray-100">
                        <span class="text-gray-400 font-medium">Kategori</span>
                        <span class="text-gray-900 font-bold text-right">{{ $book->category }}</span>
                    </div>
                    <div class="grid grid-cols-2 py-3 border-b border-gray-100">
                        <span class="text-gray-400 font-medium">Stok Tersedia</span>
                        <span class="text-gray-900 font-bold text-right">{{ $book->stock }} Eksemplar</span>
                    </div>
                    <div class="grid grid-cols-2 py-3 border-b border-gray-100">
                        <span class="text-gray-400 font-medium">Status</span>
                        <span class="text-right">
                            @if($book->stock > 0)
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold bg-green-50 text-green-600 uppercase">Tersedia</span>
                            @else
                                <span class="px-3 py-1 rounded-lg text-[10px] font-extrabold bg-red-50 text-red-600 uppercase">Dipinjam</span>
                            @endif
                        </span>
                    </div>
                </div>

                <div class="mt-auto">
                    <a href="/" class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-600/20 transition-all hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Koleksi
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-8 text-center text-gray-400 text-sm">
        <p>&copy; {{ date('Y') }} Perpustakaan Daerah Sumatera Selatan.</p>
    </footer>

</body>
</html>