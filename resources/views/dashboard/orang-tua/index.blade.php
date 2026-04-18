@extends('app')

@section('title', 'Data Orang Tua')
@section('header_title', 'Master Data Orang Tua')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <p class="text-sm text-gray-500">Kelola semua master data orang tua siswa.</p>
    </div>
    <a href="{{ route('orang-tua.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center">
        <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Orang Tua</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($orangTua as $parent)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                        {{ $parent->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $parent->email }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('orang-tua.edit', $parent->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('orang-tua.destroy', $parent->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                        Belum ada data orang tua.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($orangTua->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $orangTua->links() }}
    </div>
    @endif
</div>

@endsection
