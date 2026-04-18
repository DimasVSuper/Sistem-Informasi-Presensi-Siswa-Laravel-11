@extends('app')

@section('title', 'Edit Siswa')
@section('header_title', 'Edit Data Siswa')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('siswa.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
        <i data-feather="arrow-left" class="w-4 h-4 mr-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
    <div class="p-8">
        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap Siswa</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" required 
                    class="w-full px-4 py-2 border @error('nama') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="nis" class="block text-sm font-medium text-gray-700 mb-2">Nomor Induk Siswa (NIS)</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" required 
                    class="w-full px-4 py-2 border @error('nis') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all">
                @error('nis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="orang_tua_id" class="block text-sm font-medium text-gray-700 mb-2">Orang Tua / Wali</label>
                <select name="orang_tua_id" id="orang_tua_id" required 
                    class="w-full px-4 py-2 border @error('orang_tua_id') border-red-500 @else border-gray-300 @enderror rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                    <option value="">-- Pilih Orang Tua --</option>
                    @foreach($orangTua as $parent)
                        <option value="{{ $parent->id }}" {{ old('orang_tua_id', $siswa->orang_tua_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->nama }} ({{ $parent->email }})
                        </option>
                    @endforeach
                </select>
                @error('orang_tua_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-8">
                <label class="block text-sm font-medium text-gray-700 mb-2">QR Code Saat Ini</label>
                <div class="flex items-center">
                    <code class="px-3 py-1.5 bg-white border border-gray-300 rounded font-mono text-sm text-gray-600 shadow-sm">
                        {{ $siswa->qr_code }}
                    </code>
                    <span class="ml-3 text-xs text-green-600 font-medium">Aktif</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('siswa.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-medium text-sm transition-colors cursor-pointer">
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
