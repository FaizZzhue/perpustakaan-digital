@extends('layouts.app')

@section('content')

<div class="bg-white border border-gray-100 shadow-xl rounded-[30px] p-6 md:p-8 relative z-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Data Buku</h1>
            <p class="text-gray-500 mt-2">Kelola koleksi buku perpustakaan</p>
        </div>

        <a href="{{ route('books.create') }}" class="px-6 py-3 rounded-2xl bg-blue-500 text-white font-semibold shadow-lg shadow-blue-500/30 hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-4 focus:ring-blue-500/30">
            + Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 font-semibold flex items-center">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('books.index') }}" class="mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari buku berdasarkan judul, penulis, atau kategori..." class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-gray-800 placeholder-gray-400">
        <button type="submit" class="px-6 py-3 rounded-2xl bg-gray-100 border border-gray-200 text-gray-700 font-semibold hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-400/50">
            Cari
        </button>
    </form>

    <div class="rounded-3xl border border-gray-200 shadow-sm overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold w-16">ID</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Judul</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Penulis</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Kategori</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold w-24">Stok</th>
                        <th class="p-5 text-center text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($books as $book)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $book->id }}</td>
                        <td class="p-5 font-semibold border-r border-gray-100 text-gray-800">{{ $book->title }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $book->author }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                {{ $book->category }}
                            </span>
                        </td>
                        <td class="p-5 border-r border-gray-100 text-gray-700 font-semibold {{ $book->stock == 0 ? 'text-red-500' : '' }}">
                            {{ $book->stock }}
                        </td>
                        <td class="p-5">
                            <div class="flex gap-2 justify-center items-center">
                                <a href="{{ route('books.show', $book->id) }}" class="px-4 py-2 rounded-xl bg-cyan-400 text-white text-sm shadow-sm hover:scale-105 hover:bg-cyan-500 transition focus:outline-none focus:ring-2 focus:ring-cyan-400/50">
                                    Detail
                                </a>

                                <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 rounded-xl bg-yellow-400 text-white text-sm shadow-sm hover:scale-105 hover:bg-yellow-500 transition focus:outline-none focus:ring-2 focus:ring-yellow-400/50">
                                    Edit
                                </a>

                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm shadow-sm hover:scale-105 hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-500/50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 bg-gray-50">
                            Tidak ada data buku ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection