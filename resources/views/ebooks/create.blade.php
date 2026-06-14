@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-2xl">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Tambah Ebook</h1>
            <p class="text-gray-500 mt-2">Tambahkan ebook baru ke koleksi E-Library</p>
        </div>
        <a href="{{ route('ebooks.index') }}" class="px-6 py-3 rounded-2xl bg-white/40 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
            Kembali
        </a>
    </div>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Judul Ebook</label>
            <input type="text" name="title" value="{{ old('title') }}" placeholder="Masukkan judul ebook" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Penulis</label>
            <input type="text" name="author" value="{{ old('author') }}" placeholder="Masukkan nama penulis" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Kategori</label>
            <input type="text" name="category" value="{{ old('category') }}" placeholder="Masukkan kategori" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" placeholder="Tuliskan deskripsi lengkap ebook" rows="4" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>{{ old('description') }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Cover Image</label>
            <input type="file" name="cover_image" accept="image/*" class="w-full p-3 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none">
            <p class="text-xs text-gray-400">Format: JPEG, PNG, JPG, GIF (Max. 2MB)</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">File PDF Ebook</label>
            <input type="file" name="pdf_file" accept="application/pdf" class="w-full p-3 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none" required>
            <p class="text-xs text-gray-400">Format: PDF (Max. 10MB)</p>
        </div>

        <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
            Simpan Ebook
        </button>
    </form>
</div>

@endsection
