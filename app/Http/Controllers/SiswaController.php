<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('orangTua')->latest()->paginate(10);

        return view('dashboard.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $orangTua = OrangTua::all();

        return view('dashboard.siswa.create', compact('orangTua'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswa,nis',
            'orang_tua_id' => 'required|exists:orang_tua,id',
        ]);

        Siswa::create($validated);

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan. QR Code otomatis di-generate.');
    }

    public function edit(Siswa $siswa)
    {
        $orangTua = OrangTua::all();

        return view('dashboard.siswa.edit', compact('siswa', 'orangTua'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|unique:siswa,nis,' . $siswa->id,
            'orang_tua_id' => 'required|exists:orang_tua,id',
        ]);

        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diubah.');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }
}
