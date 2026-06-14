@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Detail Denda</h1>
            <p class="text-gray-500 mt-2">Detail transaksi denda keterlambatan buku</p>
        </div>
        <a href="{{ route('fines.index') }}" class="px-6 py-3 rounded-2xl bg-white/40 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
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
                    @if($fine->transaction->member->photo)
                        <img src="{{ asset('storage/' . $fine->transaction->member->photo) }}" alt="{{ $fine->transaction->member->name }}" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg">
                    @else
                        <div class="w-full h-full rounded-full bg-blue-100 flex flex-col items-center justify-center text-blue-500 font-bold border-4 border-white shadow-lg">
                            <span class="text-3xl">{{ strtoupper(substr($fine->transaction->member->name, 0, 2)) }}</span>
                        </div>
                    @endif
                </div>

                <div class="font-bold text-gray-800 text-lg">{{ $fine->transaction->member->name }}</div>
                <div class="text-sm font-semibold text-blue-700 mt-1">{{ $fine->transaction->member->member_code }}</div>
                
                <div class="w-full border-t border-gray-100 my-4 pt-4 text-left space-y-2 text-sm text-gray-600">
                    <div><span class="font-semibold text-gray-700">NIK:</span> {{ $fine->transaction->member->nik }}</div>
                    <div><span class="font-semibold text-gray-700">Telepon:</span> {{ $fine->transaction->member->phone }}</div>
                    <div><span class="font-semibold text-gray-700">Email:</span> {{ $fine->transaction->member->email }}</div>
                </div>

                @if($fine->transaction->member->qr_code)
                    <div class="mt-4 p-3 bg-white rounded-2xl border border-gray-200 shadow-inner">
                        <img src="{{ asset('storage/' . $fine->transaction->member->qr_code) }}" alt="QR Code" class="w-28 h-28">
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Section: Book, Transaction & Fine Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Book Details Card -->
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Buku</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Judul Buku</span>
                        <span class="text-base font-bold text-gray-800">{{ $fine->transaction->book->title }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Penulis</span>
                        <span class="text-base text-gray-800 font-medium">{{ $fine->transaction->book->author }}</span>
                    </div>
                </div>
            </div>

            <!-- Transaction Details Card -->
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Transaksi</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Tanggal Pinjam</span>
                        <span class="text-base text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($fine->transaction->borrow_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Batas Pengembalian</span>
                        <span class="text-base text-gray-800 font-semibold">{{ \Carbon\Carbon::parse($fine->transaction->due_date)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Tanggal Kembali</span>
                        <span class="text-base text-gray-800 font-semibold">
                            {{ $fine->transaction->return_date ? \Carbon\Carbon::parse($fine->transaction->return_date)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Fine Details Card -->
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b border-gray-100 pb-2">Informasi Denda</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Hari Terlambat</span>
                        <span class="text-base text-red-650 font-bold">{{ $fine->late_days }} Hari</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Jumlah Denda (Rp 1.000 / Hari)</span>
                        <span class="text-base text-gray-800 font-bold">Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}</span>
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Status Pembayaran</span>
                        @if($fine->status === 'belum_lunas')
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-800 border border-red-300">Belum Lunas</span>
                        @else
                            <span class="inline-block mt-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-800 border border-green-300">Lunas</span>
                        @endif
                    </div>
                    <div>
                        <span class="block text-gray-500 font-semibold mb-1">Tanggal Pembayaran</span>
                        <span class="text-base text-gray-800 font-semibold">
                            {{ $fine->paid_at ? \Carbon\Carbon::parse($fine->paid_at)->translatedFormat('d F Y H:i') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Footer -->
    <div class="flex justify-end gap-4 mt-8 pt-4 border-t border-gray-200">
        @if($fine->status === 'belum_lunas')
            <form action="{{ route('fines.pay', $fine->id) }}" method="POST">
                @csrf
                <button type="submit" class="px-6 py-3 rounded-2xl bg-green-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-green-600 transition duration-300 focus:outline-none">
                    Bayar Denda
                </button>
            </form>
        @endif
    </div>
</div>

@endsection
