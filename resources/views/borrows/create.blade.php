@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Tambah Peminjaman</h1>
        <p class="text-gray-500 mt-2">Daftarkan transaksi peminjaman buku baru</p>
    </div>

    <form method="POST" action="{{ route('borrows.store') }}" class="space-y-6">
        @csrf

        <!-- Member Selection -->
        <div>
            <label for="member_id" class="block text-sm font-semibold text-gray-700 mb-2">Anggota Perpustakaan</label>
            <select name="member_id" id="member_id" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none text-gray-800 @error('member_id') border-red-500 @enderror">
                <option value="">-- Pilih Anggota --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }} ({{ $member->member_code }})
                    </option>
                @endforeach
            </select>
            @error('member_id')
                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Book Selection -->
        <div>
            <label for="book_id" class="block text-sm font-semibold text-gray-700 mb-2">Buku</label>
            <select name="book_id" id="book_id" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none text-gray-800 @error('book_id') border-red-500 @enderror">
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} (Stok: {{ $book->stock }}) - {{ $book->author }}
                    </option>
                @endforeach
            </select>
            @error('book_id')
                <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Dates Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="borrow_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pinjam</label>
                <input type="date" name="borrow_date" id="borrow_date" value="{{ old('borrow_date', now()->toDateString()) }}" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none text-gray-800 @error('borrow_date') border-red-500 @enderror">
                @error('borrow_date')
                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">Batas Pengembalian (Due Date)</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', now()->addDays(7)->toDateString()) }}" class="w-full p-4 rounded-2xl bg-white/50 border border-white/40 backdrop-blur-xl focus:outline-none text-gray-800 @error('due_date') border-red-500 @enderror">
                @error('due_date')
                    <p class="text-red-500 text-xs mt-2 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4 pt-4">
            <button type="submit" class="px-6 py-4 rounded-2xl bg-blue-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-0">
                Simpan Transaksi
            </button>
            <a href="{{ route('borrows.index') }}" class="px-6 py-4 rounded-2xl bg-gray-500/20 text-gray-700 font-semibold border border-white/40 hover:scale-105 hover:bg-gray-500/30 transition text-center">
                Batal
            </a>
        </div>

    </form>
</div>

@endsection
