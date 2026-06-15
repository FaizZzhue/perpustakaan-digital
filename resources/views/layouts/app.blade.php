<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-[#dfe9f3] via-[#ffffff] to-[#d6e4ff]" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <div x-show="sidebarOpen" 
         x-transition.opacity 
         class="fixed inset-0 z-40 bg-[#071739]/40 backdrop-blur-sm lg:hidden" 
         @click="sidebarOpen = false">
    </div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-[#071739]/90 backdrop-blur-2xl text-white p-6 flex flex-col justify-between shadow-2xl transition-transform duration-300">
        
        <div>
            <div class="mb-12 flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-wide">PerpusDigital</h1>
                    <p class="text-sm text-blue-200 mt-2">Sistem Manajemen Perpustakaan</p>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <ul class="space-y-4">
                @if(Auth::check() && Auth::user()->role === 'admin')
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
                        <a href="{{ route('members.index') }}" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('members*') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Anggota
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('borrows.index') }}" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('borrows*') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Peminjaman
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('fines.index') }}" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('fines*') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Denda
                        </a>
                    </li>
                @elseif(Auth::check() && Auth::user()->role === 'member')
                    <li>
                        <a href="{{ route('member.dashboard') }}" class="flex items-center gap-3 p-4 rounded-2xl transition
                            {{ request()->is('member/dashboard') 
                                ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                                : 'hover:bg-white/10' }}">
                            Dashboard Member
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('ebooks.index') }}" class="flex items-center gap-3 p-4 rounded-2xl transition
                        {{ request()->is('ebooks*') 
                            ? 'bg-blue-500/20 border border-white/10 backdrop-blur-xl' 
                            : 'hover:bg-white/10' }}">
                        E-Library
                    </a>
                </li>
            </ul>
        </div>

        @auth
        <div class="bg-white/10 border border-white/10 backdrop-blur-xl p-4 rounded-2xl mt-8">
            <div class="flex flex-col gap-3">
                <div>
                    <h2 class="font-semibold text-sm truncate">{{ Auth::user()->name }}</h2>
                    <span class="inline-block px-2.5 py-0.5 mt-1 rounded-full text-[10px] font-bold bg-blue-500/30 text-blue-200 border border-blue-500/20 capitalize">
                        {{ Auth::user()->role }}
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-red-500/20 hover:bg-red-500/40 border border-red-500/30 rounded-xl text-red-200 hover:text-white transition text-xs font-semibold focus:outline-none">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </aside>

    <div :class="sidebarOpen ? 'lg:ml-72' : 'lg:ml-0'" class="flex-1 flex flex-col min-h-screen transition-all duration-300">
        
        <header class="flex items-center px-4 sm:px-6 py-4 bg-white/40 backdrop-blur-md border-b border-white/50 sticky top-0 z-30 shadow-sm">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-[#071739] bg-white/60 hover:bg-white rounded-xl transition shadow-sm focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <h2 class="ml-4 text-xl font-bold text-[#071739] lg:hidden">PerpusDigital</h2>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-10 overflow-x-hidden">
            @yield('content')
        </main>
        
    </div>

</body>
</html>