<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Services\SiswaService;
use App\Http\Requests\SiswaRequest;

class SiswaController extends Controller
{
    public function __construct(protected SiswaService $siswaService) {}

    public function index()
    {
        $siswa = $this->siswaService->getPaginated();

        return view('dashboard.siswa.index', compact('siswa'));
    }

    public function create()
    {
        $orangTua = OrangTua::all();

        return view('dashboard.siswa.create', compact('orangTua'));
    }

    public function store(SiswaRequest $request)
    {
        $this->siswaService->create($request->validated());

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil ditambahkan. QR Code otomatis di-generate.');
    }

    public function edit(Siswa $siswa)
    {
        $orangTua = OrangTua::all();

        return view('dashboard.siswa.edit', compact('siswa', 'orangTua'));
    }

    public function update(SiswaRequest $request, Siswa $siswa)
    {
        $this->siswaService->update($siswa, $request->validated());

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil diubah.');
    }

    public function destroy(Siswa $siswa)
    {
        $this->siswaService->delete($siswa);

        return redirect()->route('siswa.index')->with('success', 'Data Siswa berhasil dihapus.');
    }
}
