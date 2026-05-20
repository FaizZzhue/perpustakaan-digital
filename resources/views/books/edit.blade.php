@extends('layouts.app')

@section('content')

<div class="bg-white/30 backdrop-blur-xl border border-white/20 shadow-2xl p-8 rounded-3xl w-full max-w-xl">
    <h1 class="text-3xl font-bold mb-6">
        Edit Buku
    </h1>

    @if($errors->any())

    <div class="bg-red-100 text-red-700 p-4 rounded mb-5">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @endif

    <form action="{{ route('books.update', $book->id) }}"
        method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2">
                Judul Buku
            </label>

            <input type="text" name="title" value="{{ $book->title }}" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Penulis
            </label>

            <input type="text" name="author" value="{{ $book->author }}" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Kategori
            </label>

            <input type="text" name="category" value="{{ $book->category }}" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Stock
            </label>

            <input type="number" name="stock" value="{{ $book->stock }}" class="w-full border p-3 rounded">
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="px-6 py-3 rounded-2xl bg-white/20 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-yellow-400/30 hover:shadow-yellow-300/40 transition-all duration-300">
                Update Buku
            </button>

            <a href="{{ route('books.index') }}" class="px-6 py-3 rounded-2xl bg-white/20 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
                Kembali
            </a>
        </div>
    </form>

</div>

@endsection