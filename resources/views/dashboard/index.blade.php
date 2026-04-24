@extends('app')

@section('title', 'Dashboard')
@section('header_title', 'Ringkasan Hari Ini')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-indigo-50 text-indigo-600 rounded-xl mr-5">
            <i data-feather="users" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Siswa</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalSiswa }}</h3>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-blue-50 text-blue-600 rounded-xl mr-5">
            <i data-feather="users" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Total Orang Tua</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalOrangTua }}</h3>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-green-50 text-green-600 rounded-xl mr-5">
            <i data-feather="user-check" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Hadir Hari Ini</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $totalHadir }}</h3>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 flex items-center">
        <div class="p-4 bg-orange-50 text-orange-500 rounded-xl mr-5">
            <i data-feather="user-minus" class="w-8 h-8"></i>
        </div>
        <div>
            <p class="text-sm text-gray-500 font-medium mb-1">Belum Absen</p>
            <h3 class="text-3xl font-bold text-gray-800">{{ $belumHadir }}</h3>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <h3 class="font-semibold text-gray-800 text-lg">Log Presensi Hari Ini</h3>
        <span class="text-xs font-medium text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</span>
    </div>
    
    @if($recentPresensi->isEmpty())
        <div class="p-12 text-center text-gray-500">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                <i data-feather="inbox" class="w-8 h-8 text-gray-400"></i>
            </div>
            <p>Belum ada siswa yang melakukan scan presensi hari ini.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Waktu Scan</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">NIS</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentPresensi as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                            {{ $p->waktu }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-800">{{ $p->siswa->nama }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                            {{ $p->siswa->nis }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                {{ $p->status }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
