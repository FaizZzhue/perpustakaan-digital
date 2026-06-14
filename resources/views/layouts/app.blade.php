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
        </div>

        <div class="flex-1 p-10">
            @yield('content')
        </div>
    </div>

</body>
</html>