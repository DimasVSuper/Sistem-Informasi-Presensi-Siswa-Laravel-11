@extends('app')

@section('title', 'Rekap Presensi')
@section('header_title', 'Rekap Presensi Bulanan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <form action="{{ route('rekap-presensi.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label for="month" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
            <select id="month" name="month" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
                @foreach(range(1, 12) as $month)
                    <option value="{{ $month }}" @selected($selectedMonth === $month)>
                        {{ \Carbon\Carbon::create(null, $month, 1)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
            <select id="year" name="year" class="w-full rounded-xl border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-700 focus:border-indigo-500 focus:ring-indigo-500">
                @foreach($years as $year)
                    <option value="{{ $year }}" @selected($selectedYear === $year)>{{ $year }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
            <i data-feather="filter" class="w-4 h-4 mr-2"></i> Tampilkan
        </button>

        <button type="button" onclick="window.print()" class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
            <i data-feather="printer" class="w-4 h-4 mr-2"></i> Cetak
        </button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500 font-medium">Periode</p>
            <i data-feather="calendar" class="w-5 h-5 text-indigo-500"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">{{ $selectedDate->translatedFormat('F Y') }}</h3>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500 font-medium">Total Presensi</p>
            <i data-feather="check-circle" class="w-5 h-5 text-green-500"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $totalPresensi }}</h3>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500 font-medium">Siswa Pernah Hadir</p>
            <i data-feather="user-check" class="w-5 h-5 text-blue-500"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $totalSiswaHadir }}</h3>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500 font-medium">Belum Pernah Hadir</p>
            <i data-feather="user-minus" class="w-5 h-5 text-orange-500"></i>
        </div>
        <h3 class="text-3xl font-bold text-gray-800">{{ $totalBelumPernahHadir }}</h3>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="font-semibold text-gray-800 text-lg">Rekap Per Siswa</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Siswa</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">NIS</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Orang Tua</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Total Hadir</th>
                    <th scope="col" class="px-6 py-4 font-medium tracking-wider">Status Bulan Ini</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($rekapSiswa as $siswa)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $siswa->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $siswa->nis }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $siswa->orangTua->nama ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $siswa->total_hadir }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($siswa->total_hadir > 0)
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">Ada Presensi</span>
                            @else
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded-full">Belum Ada</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="font-semibold text-gray-800 text-lg">Riwayat Presensi Bulanan</h3>
    </div>

    @if($riwayatPresensi->isEmpty())
        <div class="p-12 text-center text-gray-500">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                <i data-feather="inbox" class="w-8 h-8 text-gray-400"></i>
            </div>
            <p>Belum ada presensi pada periode ini.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Waktu</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Nama Siswa</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">NIS</th>
                        <th scope="col" class="px-6 py-4 font-medium tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($riwayatPresensi as $presensi)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $presensi->waktu }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $presensi->siswa->nama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $presensi->siswa->nis }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                    {{ $presensi->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $riwayatPresensi->links() }}
        </div>
    @endif
</div>

@endsection
