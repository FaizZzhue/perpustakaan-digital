<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Animasi pergerakan cairan (Liquid Morphing) */
        @keyframes morph {
            0%, 100% { border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%; }
            50% { border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%; }
        }

        /* Animasi mengambang (Floating) */
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1) rotate(0deg); }
            50% { transform: translateY(-20px) scale(1.05) rotate(10deg); }
        }

        .liquid-blob {
            animation: morph 8s ease-in-out infinite, float 10s ease-in-out infinite;
        }

        .liquid-blob-reverse {
            animation: morph 10s ease-in-out infinite reverse, float 12s ease-in-out infinite;
        }
        
        /* Animasi slow zoom untuk background buku */
        @keyframes slowZoom {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .bg-zoom {
            animation: slowZoom 30s ease-in-out infinite;
        }
    </style>
</head>
<body class="min-h-screen relative flex items-center justify-center p-6 overflow-hidden">

    <div class="fixed inset-0 z-0 bg-[#071739]">
        <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80" 
             alt="Library Background" 
             class="w-full h-full object-cover opacity-50 bg-zoom" />
        
        <div class="absolute inset-0 bg-gradient-to-br from-[#071739]/80 via-[#071739]/40 to-blue-900/60 mix-blend-multiply"></div>
    </div>

    <div class="fixed inset-0 z-10 flex items-center justify-center pointer-events-none">
        <div class="liquid-blob absolute w-72 h-72 md:w-96 md:h-96 bg-blue-500/40 blur-2xl top-1/4 left-1/4 mix-blend-screen"></div>
        <div class="liquid-blob-reverse absolute w-80 h-80 md:w-[28rem] md:h-[28rem] bg-cyan-400/30 blur-2xl bottom-1/4 right-1/4 mix-blend-screen"></div>
        <div class="liquid-blob absolute w-64 h-64 md:w-80 md:h-80 bg-indigo-500/40 blur-3xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 mix-blend-screen"></div>
    </div>

    <div class="relative z-20 w-full max-w-md bg-white/70 backdrop-blur-2xl border border-white/40 shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-[30px] p-8 space-y-6">
        
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-[#071739]">PerpusDigital</h1>
            <p class="text-gray-600 text-sm font-medium">Masuk ke akun Perpustakaan Digital Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100/90 backdrop-blur-sm border border-red-200 text-red-700 p-4 rounded-2xl text-sm shadow-inner">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div class="space-y-2">
                <label class="block text-sm font-bold text-[#071739]">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full p-4 rounded-2xl bg-white/60 border border-white/50 backdrop-blur-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition text-gray-800 placeholder-gray-400" required autofocus>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-bold text-[#071739]">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full p-4 rounded-2xl bg-white/60 border border-white/50 backdrop-blur-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition text-gray-800 placeholder-gray-400" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 bg-white/50">
                <label for="remember" class="ml-2 block text-sm font-medium text-gray-700 select-none">Ingat saya</label>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:-translate-y-0.5 transition-all duration-300">
                Masuk
            </button>
        </form>

        <div class="text-center border-t border-gray-300/50 pt-5">
            <a href="/" class="text-sm font-semibold text-blue-700 hover:text-blue-800 hover:underline transition">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>