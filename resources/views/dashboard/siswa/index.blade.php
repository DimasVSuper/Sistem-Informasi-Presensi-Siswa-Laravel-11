@extends('app')

@section('title', 'Data Siswa')
@section('header_title', 'Master Data Siswa')

@section('content')

<div class="mb-6 flex justify-between items-center">
    <div>
        <p class="text-sm text-gray-500">Kelola semua master data siswa beserta QR Code presensi.</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('generate') }}" target="_blank" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center">
            <i data-feather="printer" class="w-4 h-4 mr-2"></i> Cetak Semua QR
        </a>
        <a href="{{ route('siswa.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center">
            <i data-feather="plus" class="w-4 h-4 mr-2"></i> Tambah Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Siswa</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">NIS</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">QR Code</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Orang Tua</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($siswa as $s)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                        {{ $s->nama }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $s->nis }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-mono rounded border border-gray-200">
                            {{ $s->qr_code }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $s->orangTua->nama ?? '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('siswa.edit', $s->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data siswa ini? Semua log presensi anak ini juga akan terhapus.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        Belum ada data siswa.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($siswa->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $siswa->links() }}
    </div>
    @endif
</div>

@endsection
