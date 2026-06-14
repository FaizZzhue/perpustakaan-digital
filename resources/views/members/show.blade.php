@extends('layouts.app')

@section('content')

<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-5xl">
    <div class="flex justify-between items-center mb-8 border-b border-gray-200 pb-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Detail Anggota</h1>
            <p class="text-gray-500 mt-2">Informasi profil lengkap anggota perpustakaan</p>
        </div>
        <a href="{{ route('members.index') }}" class="px-6 py-3 rounded-2xl bg-white/40 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
            Kembali
        </a>
    </div>

    <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
        <!-- Profile Photo -->
        <div class="w-48 h-48 flex-shrink-0">
            @if($member->photo)
                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-full h-full rounded-3xl object-cover border-4 border-white shadow-xl">
            @else
                <div class="w-full h-full rounded-3xl bg-blue-100 flex flex-col items-center justify-center text-blue-500 font-bold border-4 border-white shadow-xl">
                    <span class="text-5xl">{{ strtoupper(substr($member->name, 0, 2)) }}</span>
                    <span class="text-xs text-blue-400 mt-2">NO PHOTO</span>
                </div>
            @endif
        </div>

        <!-- Info Details -->
        <div class="flex-1 w-full space-y-4">
            <div class="bg-white/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 shadow-sm space-y-3">
                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Kode Anggota</span>
                    <span class="text-lg font-bold text-blue-700">{{ $member->member_code }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Nama Lengkap</span>
                    <span class="text-base font-semibold text-gray-800">{{ $member->name }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">NIK (KTP)</span>
                    <span class="text-base font-medium text-gray-800">{{ $member->nik }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Email</span>
                    <span class="text-base font-medium text-gray-800">{{ $member->email }}</span>
                </div>

                <div class="flex justify-between items-center border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500">Nomor Telepon</span>
                    <span class="text-base font-medium text-gray-800">{{ $member->phone }}</span>
                </div>

                <div class="flex flex-col border-b border-gray-100 pb-2">
                    <span class="text-sm font-semibold text-gray-500 mb-1">Alamat</span>
                    <span class="text-base text-gray-800 leading-relaxed">{{ $member->address }}</span>
                </div>

                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500">Status Keanggotaan</span>
                    @if($member->status == 'Aktif')
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">Aktif</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- QR Code -->
        <div class="w-48 bg-white/50 backdrop-blur-xl p-4 rounded-3xl border border-white/40 shadow-xl flex flex-col items-center justify-center gap-2">
            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Digital Card QR</span>
            @if($member->qr_code)
                <img src="{{ asset('storage/' . $member->qr_code) }}" alt="QR Code" class="w-36 h-36 border border-gray-200 rounded-2xl bg-white shadow-inner">
            @else
                <div class="w-36 h-36 rounded-2xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-400 text-xs text-center p-2">
                    QR Code Gagal Dibuat
                </div>
            @endif
            <span class="text-xxs text-gray-400 mt-1">{{ $member->member_code }}</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end gap-4 mt-8 pt-4 border-t border-gray-200">
        <a href="{{ route('members.edit', $member->id) }}" class="px-6 py-3 rounded-2xl bg-yellow-400/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-yellow-500 transition duration-300">
            Edit Profil
        </a>
    </div>
</div>

{{-- ===== A. Peminjaman Aktif ===== --}}
<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-5xl mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Peminjaman Aktif</h2>
    <p class="text-gray-500 mb-6 text-sm">Buku yang sedang dipinjam oleh anggota ini</p>

    <div class="overflow-hidden rounded-3xl border border-white/30 shadow-lg">
        <table class="w-full border-collapse">
            <thead class="bg-white/60 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Judul Buku</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Tanggal Pinjam</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Batas Kembali</th>
                    <th class="p-4 text-left text-gray-700 text-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeBorrows as $borrow)
                <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10">
                    <td class="p-4 border-r border-gray-200 font-semibold text-gray-800">{{ $borrow->book->title }}</td>
                    <td class="p-4 border-r border-gray-200 text-gray-800">{{ \Carbon\Carbon::parse($borrow->borrow_date)->translatedFormat('d M Y') }}</td>
                    <td class="p-4 border-r border-gray-200 text-gray-800">{{ \Carbon\Carbon::parse($borrow->due_date)->translatedFormat('d M Y') }}</td>
                    <td class="p-4">
                        @if($borrow->status === 'dipinjam')
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-400/20 text-yellow-800 border border-yellow-300">Dipinjam</span>
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

{{-- ===== B. Riwayat Peminjaman ===== --}}
<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-5xl mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Peminjaman</h2>
    <p class="text-gray-500 mb-6 text-sm">Daftar buku yang sudah dikembalikan</p>

    <div class="overflow-hidden rounded-3xl border border-white/30 shadow-lg">
        <table class="w-full border-collapse">
            <thead class="bg-white/60 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Judul Buku</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Tanggal Pinjam</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Tanggal Kembali</th>
                    <th class="p-4 text-left text-gray-700 text-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowHistory as $borrow)
                <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10">
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

{{-- ===== C. Riwayat Denda ===== --}}
<div class="bg-white/40 backdrop-blur-2xl border border-white/30 shadow-2xl rounded-[30px] p-8 max-w-5xl mt-8">
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Riwayat Denda</h2>
    <p class="text-gray-500 mb-6 text-sm">Daftar denda keterlambatan anggota</p>

    <div class="overflow-hidden rounded-3xl border border-white/30 shadow-lg">
        <table class="w-full border-collapse">
            <thead class="bg-white/60 border-b border-gray-200">
                <tr>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Judul Buku</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Jumlah Denda</th>
                    <th class="p-4 text-left border-r border-gray-200 text-gray-700 text-sm">Status Pembayaran</th>
                    <th class="p-4 text-left text-gray-700 text-sm">Tanggal Bayar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fines as $fine)
                <tr class="border-b border-gray-200 hover:bg-white/20 transition bg-white/10">
                    <td class="p-4 border-r border-gray-200 font-semibold text-gray-800">{{ $fine->transaction->book->title }}</td>
                    <td class="p-4 border-r border-gray-200 font-bold text-gray-800">Rp {{ number_format($fine->fine_amount, 0, ',', '.') }}</td>
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
                    <td colspan="4" class="p-6 text-center text-gray-500">Tidak ada riwayat denda.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
