@extends('layouts.app')

@section('content')

<div class="bg-white border border-gray-100 shadow-xl rounded-[30px] p-6 md:p-8 relative z-10 max-w-4xl mx-auto">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Detail Buku</h1>
            <p class="text-gray-500 mt-2">Informasi lengkap mengenai data buku</p>
        </div>

        <a href="{{ route('books.index') }}" class="px-6 py-3 rounded-2xl bg-gray-100 border border-gray-200 text-gray-700 font-semibold shadow-sm hover:bg-gray-200 hover:scale-105 transition focus:outline-none focus:ring-4 focus:ring-gray-200/50 flex items-center gap-2">
            <span>&larr;</span> Kembali
        </a>
    </div>

    <div class="space-y-6">
        
        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
            <p class="text-sm text-gray-500 font-semibold mb-1">Judul Buku</p>
            <p class="text-2xl md:text-3xl font-bold text-gray-800">{{ $book->title }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <p class="text-sm text-gray-500 font-semibold mb-2">Penulis</p>
                <p class="text-lg font-semibold text-gray-800">{{ $book->author }}</p>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <p class="text-sm text-gray-500 font-semibold mb-2">Kategori</p>
                <span class="px-4 py-1.5 rounded-full text-sm font-semibold bg-white text-gray-700 border border-gray-200 inline-block shadow-sm">
                    {{ $book->category }}
                </span>
            </div>

            <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                <p class="text-sm text-gray-500 font-semibold mb-2">Stok Tersedia</p>
                <p class="text-2xl font-bold {{ $book->stock == 0 ? 'text-red-500' : 'text-blue-600' }}">
                    {{ $book->stock }} <span class="text-base font-medium text-gray-500">Eksemplar</span>
                </p>
            </div>

        </div>
    </div>

</div>

@endsection