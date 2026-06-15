@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 pb-12">
    <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-2">Selamat datang kembali, <span class="font-semibold text-blue-700">{{ Auth::user()->name }}</span>! Kelola data keanggotaan dan peminjaman Anda.</p>
        </div>
        <div class="px-5 py-2 rounded-2xl bg-blue-100 text-blue-700 border border-blue-200 text-sm font-bold capitalize shadow-sm">
            {{ Auth::user()->role }}
        </div>
    </div>

    @if(!$member)
        <div class="bg-red-50/80 backdrop-blur-xl border border-red-200/50 shadow-xl rounded-[30px] p-8 flex flex-col md:flex-row items-center gap-6">
            <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-red-800">Profil Anggota Belum Terhubung</h2>
                <p class="text-red-700/80 mt-1">Akun pengguna Anda (<strong>{{ Auth::user()->email }}</strong>) belum terhubung dengan data anggota perpustakaan. Silakan hubungi petugas perpustakaan untuk mendaftarkan email Anda sebagai anggota agar Anda dapat menikmati layanan peminjaman.</p>
            </div>
        </div>

        <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Informasi Pengguna</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Nama Lengkap</span>
                    <span class="text-base font-bold text-gray-800">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-semibold text-gray-500">Email</span>
                    <span class="text-base font-semibold text-gray-800">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-6 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b border-gray-200 pb-2">Kartu Anggota</h2>
                    
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-32 h-32 mb-4">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full rounded-2xl object-cover border-4 border-white shadow-lg">
                            @else
                                <div class="w-full h-full rounded-2xl bg-blue-100 flex flex-col items-center justify-center text-blue-500 font-bold border-4 border-white shadow-lg">
                                    <span class="text-3xl">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                                    <span class="text-[10px] text-blue-400 mt-1">NO PHOTO</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            @if($member->status == 'Aktif')
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">Aktif</span>
                            @else
                                <span class="px-4 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 shadow-sm">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="font-semibold text-gray-500">Kode Anggota</span>
                            <span class="font-bold text-blue-700 text-base">{{ $member->member_code }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="font-semibold text-gray-500">Nama</span>
                            <span class="font-semibold text-gray-800">{{ $member->name }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="font-semibold text-gray-500">Email</span>
                            <span class="font-medium text-gray-800 truncate max-w-[180px]">{{ $member->email }}</span>
                        </div>
                        <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                            <span class="font-semibold text-gray-500">Telepon</span>
                            <span class="font-medium text-gray-800">{{ $member->phone }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col items-center">
                    @if($member->qr_code)
                        <img src="{{ asset('storage/' . $member->qr_code) }}" alt="QR Code" class="w-28 h-28 border border-gray-200 rounded-xl bg-white shadow-inner p-1">
                    @else
                        <div class="w-28 h-28 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                            QR Code Belum Tersedia
                        </div>
                    @endif
                    <span class="text-[10px] text-gray-400 mt-2 font-mono">{{ $member->member_code }}</span>
                </div>
            </div>

            <div class="lg:col-span-2 flex flex-col justify-between gap-8">
                <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-6 space-y-4">
                    <h2 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-2">Statistik Peminjaman</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-500/10 border border-blue-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-blue-700/80 uppercase tracking-wider">Peminjaman Aktif</span>
                            <span class="text-4xl font-extrabold text-blue-800 mt-2">{{ $activeBorrowCount }}</span>
                            <span class="text-xxs text-blue-600/70 mt-1">Buku sedang dipinjam</span>
                        </div>

                        <div class="bg-indigo-500/10 border border-indigo-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-indigo-700/80 uppercase tracking-wider">Total Peminjaman</span>
                            <span class="text-4xl font-extrabold text-indigo-800 mt-2">{{ $totalBorrowCount }}</span>
                            <span class="text-xxs text-indigo-600/70 mt-1">Seluruh riwayat peminjaman</span>
                        </div>

                        <div class="bg-red-500/10 border border-red-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-red-700/80 uppercase tracking-wider">Peminjaman Terlambat</span>
                            <span class="text-4xl font-extrabold text-red-800 mt-2">{{ $lateBorrowCount }}</span>
                            <span class="text-xxs text-red-600/70 mt-1">Melewati batas waktu</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-6 space-y-4">
                    <h2 class="text-xl font-bold text-gray-800 border-b border-gray-200 pb-2">Statistik Denda</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-purple-500/10 border border-purple-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-purple-700/80 uppercase tracking-wider">Total Denda</span>
                            <span class="text-2xl font-extrabold text-purple-800 mt-2">Rp {{ number_format($totalFines, 0, ',', '.') }}</span>
                            <span class="text-xxs text-purple-600/70 mt-1">Akumulasi denda</span>
                        </div>

                        <div class="bg-rose-500/10 border border-rose-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-rose-700/80 uppercase tracking-wider">Belum Dibayar</span>
                            <span class="text-2xl font-extrabold text-rose-800 mt-2">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</span>
                            <span class="text-xxs text-rose-600/70 mt-1">Wajib segera dilunasi</span>
                        </div>

                        <div class="bg-emerald-500/10 border border-emerald-200/40 p-5 rounded-2xl flex flex-col justify-between">
                            <span class="text-xs font-bold text-emerald-700/80 uppercase tracking-wider">Sudah Dibayar</span>
                            <span class="text-2xl font-extrabold text-emerald-800 mt-2">Rp {{ number_format($paidFines, 0, ',', '.') }}</span>
                            <span class="text-xxs text-emerald-600/70 mt-1">Telah lunas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Peminjaman Aktif</h2>
                <p class="text-gray-500 text-sm mt-1">Buku yang sedang Anda pinjam saat ini</p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-white/30 shadow-lg">
                <table class="w-full border-collapse">
                    <thead class="bg-white/60 border-b border-gray-200">
                        <tr>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Judul Buku</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Tanggal Pinjam</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Batas Kembali</th>
                            <th class="p-4 text-left text-gray-700 text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeBorrows as $borrow)
                        <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10 text-sm">
                            <td class="p-4 border-r border-gray-200 font-semibold text-gray-800">{{ $borrow->book->title }}</td>
                            <td class="p-4 border-r border-gray-200 text-gray-800">{{ \Carbon\Carbon::parse($borrow->borrow_date)->translatedFormat('d M Y') }}</td>
                            <td class="p-4 border-r border-gray-200 text-gray-800">{{ \Carbon\Carbon::parse($borrow->due_date)->translatedFormat('d M Y') }}</td>
                            <td class="p-4">
                                @if($borrow->status === 'dipinjam')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400/20 text-yellow-850 border border-yellow-300">Dipinjam</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-800 border border-red-300">Terlambat</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada peminjaman aktif.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman</h2>
                <p class="text-gray-500 text-sm mt-1">Daftar buku yang telah Anda kembalikan</p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-white/30 shadow-lg">
                <table class="w-full border-collapse">
                    <thead class="bg-white/60 border-b border-gray-200">
                        <tr>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Judul Buku</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Tanggal Pinjam</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Tanggal Kembali</th>
                            <th class="p-4 text-left text-gray-700 text-sm font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowHistory as $borrow)
                        <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10 text-sm">
                            <td class="p-4 border-r border-gray-200 font-semibold text-gray-800">{{ $borrow->book->title }}</td>
                            <td class="p-4 border-r border-gray-200 text-gray-800">{{ \Carbon\Carbon::parse($borrow->borrow_date)->translatedFormat('d M Y') }}</td>
                            <td class="p-4 border-r border-gray-200 text-gray-800">{{ $borrow->return_date ? \Carbon\Carbon::parse($borrow->return_date)->translatedFormat('d M Y') : '-' }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-800 border border-green-300">Dikembalikan</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-gray-500">Belum ada riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Riwayat Denda</h2>
                <p class="text-gray-500 text-sm mt-1">Daftar denda keterlambatan pengembalian buku Anda</p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-white/30 shadow-lg">
                <table class="w-full border-collapse">
                    <thead class="bg-white/60 border-b border-gray-200">
                        <tr>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Judul Buku</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Jumlah Denda</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Keterlambatan (Hari)</th>
                            <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm font-semibold">Status Pembayaran</th>
                            <th class="p-4 text-left text-gray-700 text-sm font-semibold">Tanggal Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fines as $fine)
                        <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10 text-sm">
                            <td class="p-4 border-r border-gray-200 font-semibold text-gray-800">{{ $fine->transaction->book->title }}</td>
                            <td class="p-4 border-r border-gray-200 font-bold text-gray-800">Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}</td>
                            <td class="p-4 border-r border-gray-200 text-gray-805">{{ $fine->late_days }} Hari</td>
                            <td class="p-4 border-r border-gray-200">
                                @if($fine->status === 'belum_lunas')
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/20 text-red-800 border border-red-300">Belum Lunas</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/20 text-green-800 border border-green-300">Lunas</span>
                                @endif
                            </td>
                            <td class="p-4 text-gray-800">
                                {{ $fine->paid_at ? \Carbon\Carbon::parse($fine->paid_at)->translatedFormat('d M Y H:i') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-500">Tidak ada riwayat denda.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
