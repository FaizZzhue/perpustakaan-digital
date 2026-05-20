@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Data Buku</h1>
            <p class="text-gray-500 mt-2">Kelola koleksi buku perpustakaan</p>
        </div>

        <a href="{{ route('books.create') }}" class="px-6 py-4 rounded-2xl bg-blue-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-0">
            Tambah Buku
        </a>
    </div>

    <form method="GET" action="{{ route('books.index') }}" class="mb-6">
        <input type="text" name="search" placeholder="Cari buku..." class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none">
    </form>

    <div class="overflow-hidden rounded-3xl border border-white/30 shadow-lg">
        <table class="w-full border-collapse">
            <thead class="bg-white/60 border-b border-gray-200">
                <tr>
                    <th class="p-5 text-left border-r border-gray-200">ID</th>
                    <th class="p-5 text-left border-r border-gray-200">Judul</th>
                    <th class="p-5 text-left border-r border-gray-200">Penulis</th>
                    <th class="p-5 text-left border-r border-gray-200">Kategori</th>
                    <th class="p-5 text-left border-r border-gray-200">Stok</th>
                    <th class="p-5 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($books as $book)
                <tr class="border-b border-gray-200 hover:bg-white/20 transition">
                    <td class="p-5 border-r border-gray-200">{{ $book->id }}</td>
                    <td class="p-5 font-semibold border-r border-gray-200">{{ $book->title }}</td>
                    <td class="p-5 border-r border-gray-200">{{ $book->author }}</td>
                    <td class="p-5 border-r border-gray-200">{{ $book->category }}</td>
                    <td class="p-5 border-r border-gray-200">{{ $book->stock }}</td>
                    <td class="p-5 flex gap-3">

                        <a href="{{ route('books.show', $book->id) }}" class="px-4 py-2 rounded-xl bg-cyan-400/80 text-white shadow hover:scale-105 transition focus:outline-none focus:ring-0">
                            Detail
                        </a>

                        <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 rounded-xl bg-yellow-400/80 text-white shadow hover:scale-105 transition focus:outline-none focus:ring-0">
                            Edit
                        </a>

                        <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 rounded-xl bg-red-500/80 text-white shadow hover:scale-105 transition focus:outline-none focus:ring-0">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection