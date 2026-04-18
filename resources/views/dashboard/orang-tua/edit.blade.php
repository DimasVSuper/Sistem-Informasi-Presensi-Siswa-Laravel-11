@extends('app')

@section('title', 'Edit Orang Tua')
@section('header_title', 'Edit Data Orang Tua')

@section('content')

<div class="mb-6">
    <a href="{{ route('orang-tua.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
        <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-8">
        <form action="{{ route('orang-tua.update', $orangTua->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $orangTua->nama) }}" required 
                    class="w-full px-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $orangTua->email) }}" required 
                    class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                <p class="text-xs text-gray-500 mt-1">Email ini akan mendapatkan notifikasi presensi kehadiran anak.</p>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('orang-tua.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium text-sm transition-colors cursor-pointer">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 border border-transparent text-white rounded-xl hover:bg-indigo-700 font-medium text-sm transition-colors shadow-sm">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
