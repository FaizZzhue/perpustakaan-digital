@extends('layouts.app')

@section('content')

<div class="bg-white/30 backdrop-blur-xl border border-white/20 shadow-2xl p-8 rounded-3xl w-full max-w-xl">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        Edit Anggota
    </h1>

    @if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5 border border-red-200 shadow-sm">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Nama Lengkap
            </label>
            <input type="text" name="name" value="{{ old('name', $member->name) }}" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                NIK
            </label>
            <input type="text" name="nik" value="{{ old('nik', $member->nik) }}" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="16 digit nomor induk" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Email
            </label>
            <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="contoh@domain.com" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Nomor Telepon
            </label>
            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="08xxxxxxxxxx" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Alamat
            </label>
            <textarea name="address" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3" required>{{ old('address', $member->address) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Status Keanggotaan
            </label>
            <select name="status" class="w-full border p-3 rounded-2xl bg-white/50 border-white/40 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="Aktif" {{ old('status', $member->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status', $member->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold text-gray-700">
                Foto Profil
            </label>
            
            @if($member->photo)
                <div class="mb-3">
                    <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="Foto profil" class="w-24 h-24 rounded-2xl object-cover border-2 border-white shadow-md">
                </div>
            @endif

            <input type="file" name="photo" class="w-full border p-2 rounded-2xl bg-white/50 border-white/40 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto. Format: JPEG, PNG, JPG, GIF. Maks: 2MB.</p>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="px-6 py-3 rounded-2xl bg-yellow-500/80 text-white font-semibold shadow-lg hover:scale-105 hover:bg-yellow-600 transition duration-300">
                Update Anggota
            </button>

            <a href="{{ route('members.index') }}" class="px-6 py-3 rounded-2xl bg-white/25 backdrop-blur-lg border border-white/30 shadow-lg text-gray-800 font-semibold hover:bg-gray-300/30 hover:shadow-gray-300/40 transition-all duration-300">
                Kembali
            </a>
        </div>
    </form>
</div>

@endsection
