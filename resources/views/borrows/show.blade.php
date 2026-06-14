@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Detail Peminjaman</h1>
            <p class="text-gray-500 mt-2">Detail transaksi peminjaman buku perpustakaan</p>
        </div>
        <a href="{{ route('borrows.index') }}" class="px-6 py-3 rounded-2xl bg-white/40 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-500/20 border border-green-500/30 text-green-800 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Section: Member Details & QR -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm flex flex-col items-center text-center">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informasi Anggota</h3>
                
                <div class="w-32 h-32 mb-4">
                    @if($borrow->member->photo)
                        <img src="{{ asset('storage/' . $borrow->member->photo) }}" alt="{{ $borrow->member->name }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-full h-full rounded-full bg-blue-100 flex flex-col items-center justify-center text-blue-500 font-bold border-4 border-white shadow-lg">
                            <span class="text-3xl">{{ strtoupper(substr($borrow->member->name, 0, 2)) }}</span>
                        </div>
                    @endif
                </div>

                <div class="font-bold text-gray-800 text-lg">{{ $borrow->member->name }}</div>
                <div class="text-sm font-semibold text-blue-700 mt-1">{{ $borrow->member->member_code }}</div>
                
                <div class="w-full border-t border-gray-100 my-4 pt-4 text-left space-y-2 text-sm text-gray-600">
                    <div><span class="font-semibold text-gray-700">NIK:</span> {{ $borrow->member->nik }}</div>
                    <div><span class="font-semibold text-gray-700">Telepon:</span> {{ $borrow->member->phone }}</div>
                    <div><span class="font-semibold text-gray-700">Email:</span> {{ $borrow->member->email }}</div>
                </div>

                @if($borrow->member->qr_code)
                    <div class="mt-4 p-3 bg-white rounded-2xl border border-gray-200 shadow-inner">
                        <img src="{{ asset('storage/' . $borrow->member->qr_code) }}" alt="QR Code" class="w-28 h-28">
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Section: Book & Transaction Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Book Details Card -->
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Buku</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Judul Buku</span>
                        <span class="text-base font-bold text-gray-800">{{ $borrow->book->title }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Penulis</span>
                        <span class="text-base text-gray-800 font-medium">{{ $borrow->book->author }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Kategori</span>
                        <span class="text-base text-gray-800 font-medium">{{ $borrow->book->category }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Stok Tersedia</span>
                        <span class="text-base text-gray-800 font-medium">{{ $borrow->book->stock }}</span>
                    </div>
                </div>
            </div>

            <!-- Transaction Details Card -->
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Transaksi</h3>
                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Tanggal Pinjam</span>
                        <span class="text-base text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($borrow->borrow_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Batas Pengembalian (Due Date)</span>
                        <span class="text-base text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($borrow->due_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Tanggal Kembali</span>
                        <span class="text-base text-gray-800 font-semibold">
                            {{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Status</span>
                        @if($borrow->status === 'dipinjam')
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400/20 text-yellow-800 border border-yellow-300">Dipinjam</span>
                        @elseif($borrow->status === 'dikembalikan')
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-800 border border-green-300">Dikembalikan</span>
                        @else
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-800 border border-red-300">Terlambat</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="flex justify-end gap-4 mt-8 pt-4 border-t border-gray-200">
        @if(in_array($borrow->status, ['dipinjam', 'terlambat']))
            <form action="{{ route('borrows.return', $borrow->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 rounded-2xl bg-green-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-green-600 transition duration-300 focus:outline-none">
                    Kembalikan Buku
                </button>
            </form>
        @endif

        <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-6 py-3 rounded-2xl bg-red-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-red-600 transition duration-300 focus:outline-none">
                Hapus Transaksi
            </button>
        </form>
    </div>
</div>

@endsection
