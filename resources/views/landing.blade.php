<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 font-sans antialiased text-gray-800">

    <header class="bg-gradient-to-br from-blue-500 to-blue-800 pb-32" x-data="{ mobileMenu: false }">
        
        <nav class="container mx-auto px-6 py-6 flex justify-between items-center relative z-20">
            <div class="flex items-center gap-3">
                <div>
                    <h1 class="text-white font-bold text-xl tracking-wide">
                        PERPUSTAKAAN
                    </h1>
                    <p class="text-blue-200 text-xs font-medium tracking-wider uppercase">
                        Sumatera Selatan
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8 text-white font-medium text-sm">
                <a href="/" class="hover:text-blue-200 transition">Beranda</a>
                <a href="#katalog" class="hover:text-blue-200 transition">Katalog</a>
                <a href="/ebooks" class="hover:text-blue-200 transition">E-Library</a>
                <a href="#contact" class="hover:text-blue-200 transition">Kontak</a>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:block">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? '/dashboard' : '/member/dashboard' }}" 
                           class="px-5 py-2.5 rounded-lg border border-white/30 bg-white/10 backdrop-blur-md text-white text-sm font-semibold hover:bg-white/20 transition shadow-lg">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="px-5 py-2 rounded-xl border border-white/30 bg-white/10 backdrop-blur-xl text-white hover:bg-white/20 transition focus:outline-none focus:ring-0">
                            Masuk
                        </a>
                    @endauth
                </div>

                <button @click="mobileMenu = !mobileMenu" class="md:hidden text-white focus:outline-none">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenu" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div x-show="mobileMenu" 
                 x-transition.opacity
                 class="absolute top-full left-0 w-full bg-blue-800/95 backdrop-blur-lg border-t border-white/10 md:hidden shadow-2xl rounded-b-2xl" 
                 x-cloak style="display: none;">
                <div class="flex flex-col px-6 py-5 space-y-4 text-white text-sm">
                    <a href="/" class="hover:text-blue-200">Beranda</a>
                    <a href="#katalog" class="hover:text-blue-200">Katalog</a>
                    <a href="/ebooks" class="hover:text-blue-200">E-Library</a>
                    <a href="#contact" class="hover:text-blue-200">Kontak</a>
                    <hr class="border-white/10 my-2">
                    @auth
                        <a href="{{ Auth::user()->role === 'admin' ? '/dashboard' : '/member/dashboard' }}" 
                           class="w-full text-center px-5 py-2.5 rounded-lg border border-white/30 bg-white/10 text-white text-sm font-semibold hover:bg-white/20 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full text-center px-5 py-2.5 rounded-lg border border-white/30 bg-white/10 text-white text-sm font-semibold hover:bg-white/20 transition">
                            Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="container mx-auto px-6 text-center py-16 md:py-20 relative z-10">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight mb-4 drop-shadow-md">
                Jelajahi Dunia Melalui<br>Perpustakaan Digital
            </h2>
            <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto mb-10">
                Akses ribuan koleksi buku, jurnal, dan literatur dari Perpustakaan Daerah Sumatera Selatan secara mudah dan cepat.
            </p>

            <form action="{{ route('landing') }}" method="GET" class="max-w-3xl mx-auto relative group">
                <div class="bg-white rounded-2xl p-2 flex flex-col sm:flex-row items-center gap-2 sm:gap-0 shadow-2xl transition-all duration-300 focus-within:ring-4 focus-within:ring-blue-300/50">
                    <div class="flex items-center w-full sm:flex-1">
                        <span class="pl-4 sm:pl-5 text-gray-400 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 sm:w-6 sm:h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </span>
                        <input type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}" 
                                placeholder="Cari buku berdasarkan judul..." 
                                class="w-full px-3 py-3 sm:py-4 text-sm sm:text-base outline-none text-gray-700 bg-transparent placeholder-gray-400">
                    </div>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-3 sm:py-4 rounded-xl bg-blue-600 hover:bg-blue-700 transition text-white font-semibold text-sm sm:text-base shadow-md">
                        Cari Buku
                    </button>
                </div>
            </form>
        </div>
    </header>

    <main class="container mx-auto px-6 -mt-16 relative z-10 pb-5">

        @if(isset($searchResults))
        <section id="pencarian" class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 mb-10">
            <div class="mb-8 border-b border-gray-100 pb-5">
                <h3 class="text-2xl font-bold text-gray-800">Hasil Pencarian</h3>
                <p class="text-gray-500 mt-1">Ditemukan <span class="font-bold text-blue-600">{{ $searchResults->count() }}</span> buku untuk kata kunci "{{ $search }}"</p>
            </div>

            @if($searchResults->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <div class="text-4xl mb-3">📚</div>
                    <h4 class="text-lg font-bold text-gray-700">Buku tidak ditemukan</h4>
                    <p class="text-gray-500 mt-1">Silakan coba dengan kata kunci atau ejaan yang berbeda.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    @foreach($searchResults as $book)
                        <a href="{{ route('public.books.show', $book->id) }}" class="group block h-full">
                            <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full relative">
                                
                                <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                    <img src="https://picsum.photos/seed/book-{{ $book->id }}/400/600" 
                                         alt="Cover {{ $book->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
                                    
                                    <div class="absolute top-3 right-3">
                                        @if($book->stock > 0)
                                            <span class="px-2.5 py-1 bg-green-500/90 text-white text-[11px] font-bold rounded-md backdrop-blur-sm shadow-sm">Tersedia</span>
                                        @else
                                            <span class="px-2.5 py-1 bg-red-500/90 text-white text-[11px] font-bold rounded-md backdrop-blur-sm shadow-sm">Dipinjam</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4 flex-1 flex flex-col">
                                    <span class="text-[11px] text-blue-600 font-bold uppercase tracking-wider mb-1">{{ $book->category }}</span>
                                    <h4 class="font-bold text-gray-800 text-sm md:text-base leading-snug mb-1 line-clamp-2 group-hover:text-blue-600 transition">
                                        {{ $book->title }}
                                    </h4>
                                    <p class="text-gray-500 text-xs md:text-sm mt-auto line-clamp-1">
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

        <section id="katalog" class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 mb-10">
            <div class="flex justify-between items-end mb-8 border-b border-gray-100 pb-5">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">Koleksi Terbaru</h3>
                    <p class="text-gray-500 mt-1">Tambahan literatur terkini di perpustakaan kami</p>
                </div>
                <a href="#" class="hidden md:inline-flex items-center gap-1 text-blue-600 font-semibold hover:text-blue-800 transition text-sm">
                    Lihat Semua Koleksi <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @forelse($latestBooks as $book)
                    <a href="{{ route('public.books.show', $book->id) }}" class="group block h-full">
                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full relative">
                            
                            <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                <img src="https://picsum.photos/seed/book-{{ $book->id }}/400/600" 
                                     alt="Cover {{ $book->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-in-out">
                            
                                <div class="absolute top-3 right-3">
                                    @if($book->stock > 0)
                                        <span class="px-2.5 py-1 bg-green-500/90 text-white text-[11px] font-bold rounded-md backdrop-blur-sm shadow-sm">Tersedia</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-500/90 text-white text-[11px] font-bold rounded-md backdrop-blur-sm shadow-sm">Dipinjam</span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-4 flex-1 flex flex-col">
                                <span class="text-[11px] text-blue-600 font-bold uppercase tracking-wider mb-1">{{ $book->category }}</span>
                                <h4 class="font-bold text-gray-800 text-sm md:text-base leading-snug mb-1 line-clamp-2 group-hover:text-blue-600 transition">
                                    {{ $book->title }}
                                </h4>
                                <p class="text-gray-500 text-xs md:text-sm mt-auto line-clamp-1">
                                    {{ $book->author }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="text-4xl mb-3">📭</div>
                        <h4 class="text-lg font-bold text-gray-700">Belum ada koleksi buku</h4>
                        <p class="text-gray-500 mt-1">Koleksi buku terbaru akan segera ditambahkan ke dalam sistem.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <a href="#" class="inline-block px-6 py-3 bg-blue-50 text-blue-700 font-semibold rounded-xl hover:bg-blue-100 transition w-full">
                    Lihat Semua Koleksi
                </a>
            </div>
        </section>

        <section id="contact" class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100">
            <div class="grid md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Hubungi Kami</h3>
                        <p class="text-gray-500 leading-relaxed">
                            Punya pertanyaan seputar layanan Perpustakaan Digital Daerah Sumatera Selatan? Silakan hubungi kami melalui informasi kontak berikut atau kunjungi lokasi kami pada jam operasional.
                        </p>
                    </div>
                    
                    <div>
                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-3">Media Sosial</h4>
                        <div class="flex gap-4">
                            <a href="#" class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                            </a>
                            <a href="#" class="w-12 h-12 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-600 hover:bg-pink-600 hover:text-white transition duration-300 shadow-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 p-5 sm:p-8 rounded-3xl border border-gray-100 shadow-inner flex flex-col justify-center space-y-6 w-full overflow-hidden">
                    <div class="flex items-start gap-4 sm:gap-5">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center shrink-0 text-xl">📍</div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800">Alamat Lengkap</h4>
                            <p class="text-gray-500 text-sm mt-1 leading-relaxed break-words">Jl. Demang Lebar Daun No. 9, Ilir Barat I, Palembang, Sumatera Selatan, Indonesia 30137</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 sm:gap-5">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center shrink-0 text-xl">📞</div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800">Nomor Telepon</h4>
                            <p class="text-gray-500 text-sm mt-1">+62 711 356789</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 sm:gap-5">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center shrink-0 text-xl">✉️</div>
                        <div class="min-w-0">
                            <h4 class="font-bold text-gray-800">Email Resmi</h4>
                            <p class="text-gray-500 text-sm mt-1 break-all sm:break-words">info@perpuspalembang.go.id</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    </body>
</html>