<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital Sumatera Selatan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-gray-800 flex flex-col min-h-screen">

    <header class="relative bg-gradient-to-br from-blue-600 to-blue-900 pb-40 overflow-hidden" x-data="{ mobileMenu: false }">
        
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?auto=format&fit=crop&w=1920&q=80" 
                 alt="Library" class="w-full h-full object-cover opacity-20 mix-blend-overlay">
        </div>
        
        <nav class="container mx-auto px-6 py-6 flex justify-between items-center relative z-20">
            <div class="flex items-center gap-3">
                <!-- <div class="bg-white/10 p-2 rounded-xl backdrop-blur-sm border border-white/20">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div> -->
                <div>
                    <h1 class="text-white font-extrabold text-xl tracking-wide">
                        PERPUSTAKAAN
                    </h1>
                    <p class="text-blue-200 text-[10px] font-bold tracking-widest uppercase">
                        Sumatera Selatan
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8 text-white font-medium text-sm">
                <a href="/" class="hover:text-blue-200 hover:-translate-y-0.5 transition-transform">Beranda</a>
                <a href="#katalog" class="hover:text-blue-200 hover:-translate-y-0.5 transition-transform">Katalog</a>
                <a href="/ebooks" class="hover:text-blue-200 hover:-translate-y-0.5 transition-transform">E-Library</a>
                <a href="#contact" class="hover:text-blue-200 hover:-translate-y-0.5 transition-transform">Kontak</a>
            </div>

            <div class="flex items-center gap-4 relative z-20">
                <div class="hidden md:block">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? '/dashboard' : '/member/dashboard' }}" 
                           class="px-6 py-2.5 rounded-xl border border-white/30 bg-white/10 backdrop-blur-md text-white text-sm font-semibold hover:bg-white/20 transition shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-6 py-2.5 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white font-semibold hover:bg-white/20 transition focus:outline-none shadow-lg">
                            Masuk
                        </a>
                    @endauth
                </div>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-white bg-white/10 p-2 rounded-lg border border-white/20 focus:outline-none backdrop-blur-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div x-show="mobileMenu" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-5"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute top-full left-0 w-full bg-blue-900/95 backdrop-blur-xl border-t border-white/10 md:hidden shadow-2xl rounded-b-3xl" 
                 x-cloak style="display: none;">
                <div class="flex flex-col px-6 py-6 space-y-5 text-white text-sm font-medium">
                    <a href="/" class="hover:text-blue-300 flex items-center gap-3"><span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Beranda</a>
                    <a href="#katalog" class="hover:text-blue-300 flex items-center gap-3"><span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Katalog</a>
                    <a href="/ebooks" class="hover:text-blue-300 flex items-center gap-3"><span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> E-Library</a>
                    <a href="#contact" class="hover:text-blue-300 flex items-center gap-3"><span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Kontak</a>
                    <hr class="border-white/10 my-2">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? '/dashboard' : '/member/dashboard' }}" 
                           class="w-full text-center px-5 py-3 rounded-xl border border-white/30 bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full text-center px-5 py-3 rounded-xl border border-white/30 bg-white/10 text-white font-semibold hover:bg-white/20 transition">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-6 text-center py-16 md:py-24 relative z-10">
            <h2 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6 drop-shadow-lg">
                Jelajahi Dunia Melalui<br>
                <span class="text-blue-200">Perpustakaan Digital</span>
            </h2>
            <p class="text-blue-50 text-lg md:text-xl max-w-2xl mx-auto mb-12 drop-shadow">
                Akses tak terbatas ke ribuan koleksi buku, jurnal, dan literatur dari Perpustakaan Daerah Sumatera Selatan. Kapan saja, di mana saja.
            </p>

            <form action="{{ route('landing') }}" method="GET" class="max-w-3xl mx-auto relative group">
                <div class="bg-white/95 backdrop-blur-md rounded-2xl p-2.5 flex flex-col sm:flex-row items-center gap-2 sm:gap-0 shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 focus-within:ring-4 focus-within:ring-blue-400/50">
                    <div class="flex items-center w-full sm:flex-1">
                        <span class="pl-4 sm:pl-5 text-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>
                        <input type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}" 
                                placeholder="Cari buku, penulis, atau kategori..." 
                                class="w-full px-4 py-3 sm:py-4 text-sm sm:text-base font-medium outline-none text-gray-800 bg-transparent placeholder-gray-400">
                    </div>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3.5 sm:py-4 rounded-xl bg-blue-600 hover:bg-blue-700 transition text-white font-bold text-sm sm:text-base shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        Cari Buku
                    </button>
                </div>
            </form>
        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] transform translate-y-1 z-0 pointer-events-none">
            <svg class="relative block w-full h-[60px] md:h-[120px]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="rgba(248, 250, 252, 0.3)" d="M0,160L48,144C96,128,192,96,288,106.7C384,117,480,171,576,165.3C672,160,768,96,864,96C960,96,1056,160,1152,176C1248,192,1344,160,1392,144L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                <path fill="rgba(248, 250, 252, 0.6)" d="M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,122.7C960,117,1056,171,1152,192C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                <path fill="#f8fafc" d="M0,256L48,245.3C96,235,192,213,288,181.3C384,149,480,107,576,117.3C672,128,768,192,864,213.3C960,235,1056,213,1152,202.7C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </header>

    <main class="container mx-auto px-6 -mt-16 relative z-10 pb-16 flex-grow">

        @if(!isset($searchResults))
        <div class="grid md:grid-cols-3 gap-6 mb-16">
            <div class="bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-gray-100 flex gap-4 items-start hover:-translate-y-1 transition duration-300">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-2xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Koleksi Lengkap</h4>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">Ribuan buku fiksi, akademik, dan jurnal siap dibaca kapan saja.</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-gray-100 flex gap-4 items-start hover:-translate-y-1 transition duration-300">
                <div class="bg-green-100 text-green-600 p-3 rounded-2xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Akses 24/7</h4>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">Nikmati layanan perpustakaan tanpa batasan waktu dan tempat.</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl shadow-[0_4px_20px_rgb(0,0,0,0.05)] border border-gray-100 flex gap-4 items-start hover:-translate-y-1 transition duration-300">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-2xl shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 text-lg">Berbasis E-Book</h4>
                    <p class="text-gray-500 text-sm mt-1 leading-relaxed">Selain buku fisik, temukan perpustakaan elektronik langsung di genggaman.</p>
                </div>
            </div>
        </div>
        @endif

        @if(isset($searchResults))
        <section id="pencarian" class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 mb-16">
            <div class="mb-8 border-b border-gray-100 pb-5 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Hasil Pencarian</h3>
                    <p class="text-gray-500 mt-1">Ditemukan <span class="font-bold text-blue-600">{{ $searchResults->count() }}</span> buku untuk kata kunci "{{ $search }}"</p>
                </div>
                <a href="/" class="text-sm text-gray-500 hover:text-blue-600 border border-gray-200 px-4 py-2 rounded-lg transition">Hapus Pencarian</a>
            </div>

            @if($searchResults->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="text-5xl mb-4">📚</div>
                    <h4 class="text-xl font-bold text-gray-800">Buku tidak ditemukan</h4>
                    <p class="text-gray-500 mt-2 max-w-md mx-auto">Silakan coba dengan kata kunci, judul, atau nama penulis yang berbeda.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($searchResults as $book)
                        <a href="{{ route('public.books.show', $book->id) }}" class="group block h-full">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full relative">
                                <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                    <img src="https://picsum.photos/seed/book-{{ $book->id }}/400/600" 
                                         alt="Cover {{ $book->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                                    <div class="absolute top-3 right-3">
                                        @if($book->stock > 0)
                                            <span class="px-3 py-1 bg-green-500/90 text-white text-[10px] uppercase font-extrabold rounded-md backdrop-blur-md shadow-sm">Tersedia</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-500/90 text-white text-[10px] uppercase font-extrabold rounded-md backdrop-blur-md shadow-sm">Dipinjam</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="p-5 flex-1 flex flex-col">
                                    <span class="text-[10px] text-blue-600 font-extrabold uppercase tracking-widest mb-1.5">{{ $book->category }}</span>
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base leading-snug mb-1.5 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $book->title }}
                                    </h4>
                                    <p class="text-gray-500 text-xs md:text-sm mt-auto line-clamp-1 font-medium">
                                        {{ $book->author }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
        @endif

        <section id="katalog" class="bg-white rounded-3xl p-8 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 mb-16">
            <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-5">
                <div>
                    <h3 class="text-3xl font-extrabold text-gray-800">Koleksi Terbaru</h3>
                    <p class="text-gray-500 mt-2 font-medium">Tambahan literatur terkini di perpustakaan kami</p>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-2 text-blue-600 font-bold hover:text-blue-800 transition text-sm">
                    Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @forelse($latestBooks as $book)
                    <a href="{{ route('public.books.show', $book->id) }}" class="group block h-full">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition duration-300 border border-gray-100 flex flex-col h-full relative">
                            <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                <img src="https://picsum.photos/seed/book-{{ $book->id }}/400/600" 
                                     alt="Cover {{ $book->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-in-out">
                                <div class="absolute top-3 right-3">
                                    @if($book->stock > 0)
                                        <span class="px-3 py-1 bg-green-500/90 text-white text-[10px] uppercase font-extrabold rounded-md backdrop-blur-md shadow-sm">Tersedia</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-500/90 text-white text-[10px] uppercase font-extrabold rounded-md backdrop-blur-md shadow-sm">Dipinjam</span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <span class="text-[10px] text-blue-600 font-extrabold uppercase tracking-widest mb-1.5">{{ $book->category }}</span>
                                <h4 class="font-bold text-gray-800 text-sm md:text-base leading-snug mb-1.5 line-clamp-2 group-hover:text-blue-600 transition">
                                    {{ $book->title }}
                                </h4>
                                <p class="text-gray-500 text-xs md:text-sm mt-auto line-clamp-1 font-medium">
                                    {{ $book->author }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                        <div class="text-5xl mb-4">📭</div>
                        <h4 class="text-xl font-bold text-gray-800">Belum ada koleksi buku</h4>
                        <p class="text-gray-500 mt-2">Koleksi buku terbaru akan segera ditambahkan ke dalam sistem.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-10 text-center md:hidden">
                <a href="#" class="inline-flex justify-center items-center gap-2 px-6 py-3.5 bg-blue-50 text-blue-700 font-bold rounded-xl hover:bg-blue-100 transition w-full">
                    Lihat Semua Koleksi
                </a>
            </div>
        </section>

        <section id="contact" class="bg-white rounded-3xl p-8 md:p-12 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
            <div class="grid md:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-3xl font-extrabold text-gray-800 mb-4">Butuh Bantuan?</h3>
                        <p class="text-gray-500 text-lg leading-relaxed">
                            Tim Perpustakaan Daerah Sumatera Selatan siap membantu kelancaran akses literatur Anda. Silakan hubungi kami atau kunjungi langsung pada jam operasional.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ikuti Kami</h4>
                        <div class="flex gap-4">
                            <a href="#" class="w-12 h-12 rounded-2xl bg-slate-50 border border-gray-100 flex items-center justify-center text-gray-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-2xl bg-slate-50 border border-gray-100 flex items-center justify-center text-gray-600 hover:bg-pink-600 hover:border-pink-600 hover:text-white transition duration-300 shadow-sm hover:shadow-lg hover:-translate-y-1">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-6 sm:p-10 rounded-3xl border border-gray-200 shadow-inner flex flex-col justify-center space-y-8 w-full overflow-hidden">
                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center shrink-0 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-gray-800 text-lg">Alamat</h4>
                            <p class="text-gray-500 text-sm mt-1.5 leading-relaxed break-words">Jl. Demang Lebar Daun No. 9, Ilir Barat I, Palembang, Sumatera Selatan, Indonesia 30137</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center shrink-0 text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-gray-800 text-lg">Telepon</h4>
                            <p class="text-gray-500 text-sm mt-1.5">+62 711 356789</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 sm:gap-6">
                        <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-gray-100 flex items-center justify-center shrink-0 text-pink-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-gray-800 text-lg">Email</h4>
                            <p class="text-gray-500 text-sm mt-1.5 break-all sm:break-words">info@perpuspalembang.go.id</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto py-10">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="text-gray-800 font-extrabold tracking-wide">PerpusDigital</span>
            </div>
            <p class="text-gray-500 text-sm text-center md:text-left font-medium">
                &copy; {{ date('Y') }} Perpustakaan Daerah Sumatera Selatan. Seluruh hak cipta dilindungi.
            </p>
        </div>
    </footer>

</body>
</html>