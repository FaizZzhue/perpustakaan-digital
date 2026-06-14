@extends('layouts.app')

@section('content')

<div class="bg-white border border-gray-100 shadow-xl rounded-[30px] p-6 md:p-8 relative z-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">E-Library</h1>
            <p class="text-gray-500 mt-2">Kelola koleksi buku digital (Ebook)</p>
        </div>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('ebooks.create') }}" class="px-6 py-3 rounded-2xl bg-blue-500 text-white font-semibold shadow-lg shadow-blue-500/30 hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-4 focus:ring-blue-500/30">
                    + Tambah Ebook
                </a>
            @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 font-semibold flex items-center">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" action="{{ route('ebooks.index') }}" class="mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Ebook berdasarkan judul, penulis, atau kategori..." class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-gray-800 placeholder-gray-400">
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
                        <th class="p-5 text-center border-r border-gray-200 text-gray-700 font-semibold w-24">Cover</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Judul</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Penulis</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Kategori</th>
                        <th class="p-5 text-center text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($ebooks as $ebook)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $ebook->id }}</td>
                        <td class="p-5 border-r border-gray-100 flex justify-center">
                            @if($ebook->cover_image)
                                <img src="{{ asset('storage/' . $ebook->cover_image) }}" alt="{{ $ebook->title }}" class="w-12 h-16 rounded-lg object-cover shadow-sm border border-gray-200">
                            @else
                                <div class="w-12 h-16 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 font-bold text-[10px] text-center leading-tight border border-gray-200">
                                    NO COVER
                                </div>
                            @endif
                        </td>
                        <td class="p-5 font-semibold border-r border-gray-100 text-gray-800">{{ $ebook->title }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $ebook->author }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 border border-gray-200">
                                {{ $ebook->category }}
                            </span>
                        </td>
                        <td class="p-5">
                            <div class="flex flex-wrap gap-2 justify-center items-center">
                                <a href="{{ route('ebooks.show', $ebook->id) }}" class="px-3 py-2 rounded-xl bg-cyan-400 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-cyan-500 transition focus:outline-none focus:ring-2 focus:ring-cyan-400/50">
                                    Detail
                                </a>

                                <a href="{{ route('ebooks.read', $ebook->id) }}" target="_blank" class="px-3 py-2 rounded-xl bg-green-500 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-green-600 transition focus:outline-none focus:ring-2 focus:ring-green-500/50">
                                    Baca PDF
                                </a>

                                <a href="{{ route('ebooks.download', $ebook->id) }}" class="px-3 py-2 rounded-xl bg-blue-500 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                                    Download
                                </a>

                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('ebooks.edit', $ebook->id) }}" class="px-3 py-2 rounded-xl bg-yellow-400 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-yellow-500 transition focus:outline-none focus:ring-2 focus:ring-yellow-400/50">
                                            Edit
                                        </a>

                                        <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ebook ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 rounded-xl bg-red-500 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-500/50">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 bg-gray-50">
                            Belum ada data ebook yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection