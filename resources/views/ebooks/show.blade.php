@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-4xl">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Detail Ebook</h1>
            <p class="text-gray-500 mt-2">Informasi detail mengenai buku digital</p>
        </div>
        <a href="{{ route('ebooks.index') }}" class="px-6 py-3 rounded-2xl bg-white/40 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
            Kembali
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
        <!-- Cover Art -->
        <div class="w-48 h-64 flex-shrink-0">
            @if($ebook->cover_image)
                <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-full h-full rounded-3xl object-cover border-4 border-white shadow-xl">
            @else
                <div class="w-full h-full rounded-3xl bg-blue-100 flex flex-col items-center justify-center text-blue-500 font-bold border-4 border-white shadow-xl">
                    <span class="text-3xl">{{ strtoupper(substr($ebook->title, 0, 2)) }}</span>
                    <span class="text-xs text-blue-400 mt-2">NO COVER</span>
                </div>
            @endif
        </div>

        <!-- Info Details -->
        <div class="flex-1 w-full space-y-4">
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm space-y-3">
                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Judul Ebook</span>
                    <span class="text-lg font-bold text-gray-800">{{ $ebook->title }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Penulis</span>
                    <span class="text-base font-semibold text-blue-700">{{ $ebook->author }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Kategori</span>
                    <span class="text-base font-medium text-gray-800">{{ $ebook->category }}</span>
                </div>

                <div class="flex flex-col border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500 mb-1">Deskripsi</span>
                    <span class="text-base text-gray-700 leading-relaxed">{{ $ebook->description }}</span>
                </div>
            </div>

            <!-- Ebook Action Buttons -->
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('ebooks.read', $ebook->id) }}" target="_blank" class="px-6 py-3 rounded-2xl bg-green-500 hover:bg-green-600 text-white font-semibold shadow-lg transition-all duration-300">
                    Baca PDF di Browser 📖
                </a>

                <a href="{{ route('ebooks.download', $ebook->id) }}" class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-lg transition-all duration-300">
                    Download PDF 📥
                </a>

                @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('ebooks.edit', $ebook->id) }}" class="px-6 py-3 rounded-2xl bg-yellow-500 hover:bg-yellow-600 text-white font-semibold shadow-lg transition-all duration-300">
                        Edit Ebook ✏️
                    </a>

                    <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ebook ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 rounded-2xl bg-red-500 hover:bg-red-600 text-white font-semibold shadow-lg transition-all duration-300 focus:outline-none">
                            Delete Ebook 🗑️
                        </button>
                    </form>
                @endif
                @endauth
            </div>
        </div>
    </div>
</div>

@endsection
