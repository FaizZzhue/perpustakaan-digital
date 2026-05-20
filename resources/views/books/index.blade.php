@extends('layouts.app')

@section('content')

<div class="bg-white p-6 rounded-xl shadow">
    <div class="flex justify-between items-center mb-5">
        <div>
            <h1 class="text-3xl font-bold">
                Data Buku
            </h1>

            <p class="text-gray-500">
                Daftar koleksi buku perpustakaan
            </p>
        </div>

        <a href="{{ route('books.create') }}"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg">
            Tambah Buku
        </a>
    </div>

    <table class="w-full border rounded-lg overflow-hidden shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-4">ID</th>
                <th class="p-4">Judul</th>
                <th class="p-4">Penulis</th>
                <th class="p-4">Kategori</th>
                <th class="p-4">Stok</th>
                <th class="p-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr class="border-b">
                <td class="p-4">
                    {{ $book->id }}
                </td>

                <td class="p-4 font-semibold">
                    {{ $book->title }}
                </td>

                <td class="p-4">
                    {{ $book->author }}
                </td>

                <td class="p-4">
                    {{ $book->category }}
                </td>

                <td class="p-4">
                    {{ $book->stock }}
                </td>

                <td class="p-4 flex gap-2">
                    <a href="{{ route('books.edit', $book->id) }}" class="bg-yellow-400 px-4 py-2 rounded text-white">
                        Edit
                    </a>

                    <form action="{{ route('books.destroy', $book->id) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="bg-red-500 px-4 py-2 rounded text-white">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection