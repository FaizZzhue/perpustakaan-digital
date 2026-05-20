@extends('layouts.app')

@section('content')

<div class="bg-white p-8 rounded-xl shadow w-full max-w-xl">
    <h1 class="text-3xl font-bold mb-6">
        Tambah Buku
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

    <form action="{{ route('books.store') }}"
        method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-2">
                Judul Buku
            </label>

            <input type="text" name="title" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Penulis
            </label>

            <input type="text" name="author" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Kategori
            </label>

            <input type="text" name="category" class="w-full border p-3 rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">
                Stock
            </label>

            <input type="number" name="stock" class="w-full border p-3 rounded">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg focus:outline-none focus:ring-0">
            Simpan
        </button>
    </form>
</div>

@endsection