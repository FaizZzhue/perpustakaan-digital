@extends('layouts.app')

@section('content')

<div class="bg-white border border-gray-100 shadow-xl rounded-[30px] p-6 md:p-8 relative z-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Daftar Denda</h1>
            <p class="text-gray-500 mt-2">Kelola denda keterlambatan pengembalian buku</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 font-semibold flex items-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 font-semibold flex items-center">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col xl:flex-row gap-4 justify-between items-center mb-6">
        <form method="GET" action="{{ route('fines.index') }}" class="w-full xl:w-1/3 flex gap-2">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari anggota atau buku..." class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition text-gray-800 placeholder-gray-400">
            <button type="submit" class="px-6 py-3 rounded-2xl bg-gray-100 border border-gray-200 text-gray-700 font-semibold hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-400/50 xl:hidden">
                Cari
            </button>
        </form>

        <div class="flex flex-wrap md:flex-nowrap bg-gray-50 p-1.5 rounded-2xl border border-gray-200 w-full xl:w-auto overflow-x-auto">
            <a href="{{ route('fines.index', ['status' => '', 'search' => $search]) }}" class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-semibold transition {{ !$status ? 'bg-blue-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('fines.index', ['status' => 'belum_lunas', 'search' => $search]) }}" class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-semibold transition {{ $status === 'belum_lunas' ? 'bg-red-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                Belum Lunas
            </a>
            <a href="{{ route('fines.index', ['status' => 'lunas', 'search' => $search]) }}" class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-semibold transition {{ $status === 'lunas' ? 'bg-green-500 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-200' }}">
                Lunas
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-gray-200 shadow-sm overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold w-16">ID</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Anggota</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Buku</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Hari Terlambat</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Jumlah Denda</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Status</th>
                        <th class="p-5 text-left border-r border-gray-200 text-gray-700 font-semibold">Tanggal Bayar</th>
                        <th class="p-5 text-center text-gray-700 font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($fines as $fine)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $fine->id }}</td>
                        <td class="p-5 border-r border-gray-100">
                            <div class="font-semibold text-gray-800">{{ $fine->transaction->member->name }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $fine->transaction->member->member_code }}</div>
                        </td>
                        <td class="p-5 border-r border-gray-100">
                            <div class="font-semibold text-gray-800">{{ $fine->transaction->book->title }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $fine->transaction->book->author }}</div>
                        </td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold border border-gray-200">
                                {{ $fine->late_days }} Hari
                            </span>
                        </td>
                        <td class="p-5 border-r border-gray-100 font-bold text-red-600">
                            Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}
                        </td>
                        <td class="p-5 border-r border-gray-100">
                            @if($fine->status === 'belum_lunas')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">Belum Lunas</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Lunas</span>
                            @endif
                        </td>
                        <td class="p-5 border-r border-gray-100 text-gray-700">
                            {{ $fine->paid_at ? \Carbon\Carbon::parse($fine->paid_at)->translatedFormat('d M Y H:i') : '-' }}
                        </td>
                        <td class="p-5">
                            <div class="flex gap-2 justify-center items-center">
                                <a href="{{ route('fines.show', $fine->id) }}" class="px-3 py-2 rounded-xl bg-cyan-400 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-cyan-500 transition focus:outline-none focus:ring-2 focus:ring-cyan-400/50">
                                    Detail
                                </a>

                                @if($fine->status === 'belum_lunas')
                                    <form action="{{ route('fines.pay', $fine->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Konfirmasi pembayaran denda untuk anggota ini?')">
                                        @csrf
                                        <button type="submit" class="px-3 py-2 rounded-xl bg-green-500 text-white text-xs font-semibold shadow-sm hover:scale-105 hover:bg-green-600 transition focus:outline-none focus:ring-2 focus:ring-green-500/50">
                                            Bayar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500 bg-gray-50">
                            Tidak ada data denda.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection