<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Perpustakaan Digital</title>

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 min-h-screen bg-[#0B1F4D] text-white p-5">
            <h1 class="text-2xl font-bold mb-10">
                Perpustakaan
            </h1>

            <ul class="space-y-4">
                <li>
                    <a href="/books" class="block p-3 rounded-xl bg-blue-600 hover:bg-blue-500 transition">
                        Buku
                    </a>
                </li>
            </ul>

        </div>

        <!-- Content -->
        <div class="flex-1 p-8">
            @yield('content')
        </div>

    </div>

</body>
</html>