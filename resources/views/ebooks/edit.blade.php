@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-2xl">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Edit Ebook</h1>
            <p class="text-gray-500 mt-2">Perbarui informasi ebook di koleksi E-Library</p>
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

    <form action="{{ route('ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Judul Ebook</label>
            <input type="text" name="title" value="{{ old('title', $ebook->title) }}" placeholder="Masukkan judul ebook" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Penulis</label>
            <input type="text" name="author" value="{{ old('author', $ebook->author) }}" placeholder="Masukkan nama penulis" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Kategori</label>
            <input type="text" name="category" value="{{ old('category', $ebook->category) }}" placeholder="Masukkan kategori" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Deskripsi</label>
            <textarea name="description" placeholder="Tuliskan deskripsi lengkap ebook" rows="4" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none focus:border-blue-400 transition" required>{{ old('description', $ebook->description) }}</textarea>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">Cover Image</label>
            @if($ebook->cover_image)
                <div class="mb-3 flex items-center gap-4">
                    <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-16 h-24 rounded-lg object-cover shadow border border-gray-100">
                    <span class="text-sm text-gray-500">Cover saat ini</span>
                </div>
            @endif
            <input type="file" name="cover_image" accept="image/*" class="w-full p-3 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none">
            <p class="text-xs text-gray-400">Pilih berkas baru jika ingin mengganti cover (Max. 2MB)</p>
        </div>

        <div class="space-y-2">
            <label class="block font-semibold text-gray-700">File PDF Ebook</label>
            <div class="mb-3 flex items-center gap-4">
                <span class="px-3 py-1.5 rounded-xl bg-green-50 text-green-700 border border-green-200 text-xs font-semibold">PDF tersedia</span>
                <a href="{{ route('ebooks.read', $ebook->id) }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat PDF saat ini</a>
            </div>
            <input type="file" name="pdf_file" accept="application/pdf" class="w-full p-3 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none">
            <p class="text-xs text-gray-400">Pilih berkas PDF baru jika ingin mengganti file ebook (Max. 10MB)</p>
        </div>

        <button type="submit" class="w-full py-4 rounded-2xl bg-blue-600 text-white font-semibold shadow-lg hover:bg-blue-700 transition duration-300">
            Perbarui Ebook
        </button>
    </form>
</div>

@endsection
