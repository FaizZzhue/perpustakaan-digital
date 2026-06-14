@extends('layouts.app')

@section('content')

<div class="bg-white border border-gray-100 shadow-xl rounded-[30px] p-6 md:p-8 relative z-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">Data Anggota</h1>
            <p class="text-gray-500 mt-2">Kelola data anggota perpustakaan digital</p>
        </div>

        <a href="{{ route('members.create') }}" class="px-6 py-3 rounded-2xl bg-blue-500 text-white font-semibold shadow-lg shadow-blue-500/30 hover:scale-105 hover:bg-blue-600 transition focus:outline-none focus:ring-4 focus:ring-blue-500/30">
            + Tambah Anggota
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-green-50 border border-green-200 text-green-800 flex items-center">
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('members.index') }}" class="mb-6 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari anggota berdasarkan nama, kode, NIK, email..." class="w-full px-5 py-3 rounded-2xl bg-gray-50 border border-gray-200 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-400/50 transition">
        <button type="submit" class="px-6 py-3 rounded-2xl bg-gray-100 border border-gray-200 text-gray-700 font-semibold hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-400/50">
            Cari
        </button>
    </form>

    <div class="rounded-3xl border border-gray-200 shadow-sm overflow-hidden bg-white">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse whitespace-nowrap">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-5 text-left border-r border-gray-200 w-16 font-semibold text-gray-700">ID</th>
                        <th class="p-5 text-left border-r border-gray-200 w-24 font-semibold text-gray-700">Foto</th>
                        <th class="p-5 text-left border-r border-gray-200 font-semibold text-gray-700">Kode</th>
                        <th class="p-5 text-left border-r border-gray-200 font-semibold text-gray-700">Nama</th>
                        <th class="p-5 text-left border-r border-gray-200 font-semibold text-gray-700">NIK</th>
                        <th class="p-5 text-left border-r border-gray-200 font-semibold text-gray-700">Email</th>
                        <th class="p-5 text-left border-r border-gray-200 font-semibold text-gray-700">Status</th>
                        <th class="p-5 text-center font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($members as $member)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="p-5 border-r border-gray-100 text-gray-700">{{ $member->id }}</td>
                        <td class="p-5 border-r border-gray-100">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm">
                            @else
                                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 font-bold border-2 border-white shadow-sm">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                            @endif
                        </td>
                        <td class="p-5 font-semibold border-r border-gray-100 text-blue-600">{{ $member->member_code }}</td>
                        <td class="p-5 font-semibold border-r border-gray-100 text-gray-800">{{ $member->name }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-600">{{ $member->nik }}</td>
                        <td class="p-5 border-r border-gray-100 text-gray-600">{{ $member->email }}</td>
                        <td class="p-5 border-r border-gray-100">
                            @if($member->status == 'Aktif')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Aktif</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">Nonaktif</span>
                            @endif
                        </td>
                        <td class="p-5">
                            <div class="flex gap-2 justify-center items-center">
                                <a href="{{ route('members.show', $member->id) }}" class="px-4 py-2 rounded-xl bg-cyan-400 text-white text-sm shadow-sm hover:scale-105 hover:bg-cyan-500 transition focus:outline-none focus:ring-2 focus:ring-cyan-400/50">
                                    Detail
                                </a>

                                <a href="{{ route('members.edit', $member->id) }}" class="px-4 py-2 rounded-xl bg-yellow-400 text-white text-sm shadow-sm hover:scale-105 hover:bg-yellow-500 transition focus:outline-none focus:ring-2 focus:ring-yellow-400/50">
                                    Edit
                                </a>

                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')" class="inline-block m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-red-500 text-white text-sm shadow-sm hover:scale-105 hover:bg-red-600 transition focus:outline-none focus:ring-2 focus:ring-red-500/50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-gray-500 bg-gray-50">Tidak ada data anggota ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection