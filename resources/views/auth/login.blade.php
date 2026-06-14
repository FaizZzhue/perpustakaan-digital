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
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#dfe9f3] via-[#ffffff] to-[#d6e4ff] flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 space-y-6">
        <div class="text-center space-y-2">
            <h1 class="text-3xl font-bold text-[#071739]">PerpusDigital</h1>
            <p class="text-gray-500 text-sm">Masuk ke akun Perpustakaan Digital Anda</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100/80 border border-red-200 text-red-700 p-4 rounded-2xl text-sm">
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
                <label class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required autofocus>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" placeholder="••••••••" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember" class="ml-2 block text-sm text-gray-700 select-none">Ingat saya</label>
            </div>

            <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg hover:shadow-blue-500/20 transition-all duration-300">
                Masuk
            </button>
        </form>

        <div class="text-center border-t border-white/20 pt-4">
            <a href="/" class="text-sm text-blue-600 hover:underline">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
