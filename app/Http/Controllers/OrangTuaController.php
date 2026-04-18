<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrangTuaRequest;
use App\Http\Requests\UpdateOrangTuaRequest;
use App\Models\OrangTua;
use App\Services\OrangTuaService;
use App\Http\Requests\OrangTuaRequest;

class OrangTuaController extends Controller
{
    public function __construct(protected OrangTuaService $orangTuaService) {}

    public function index()
    {
        $orangTua = $this->orangTuaService->getPaginated();

        return view('dashboard.orang-tua.index', compact('orangTua'));
    }

    public function create()
    {
        return view('dashboard.orang-tua.create');
    }

    public function store(OrangTuaRequest $request)
    {
        $this->orangTuaService->create($request->validated());

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil ditambahkan.');
    }

    public function edit(OrangTua $orangTua)
    {
        return view('dashboard.orang-tua.edit', compact('orangTua'));
    }

    public function update(OrangTuaRequest $request, OrangTua $orangTua)
    {
        $this->orangTuaService->update($orangTua, $request->validated());

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil diubah.');
    }

    public function destroy(OrangTua $orangTua)
    {
        $this->orangTuaService->delete($orangTua);

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil dihapus.');
    }
}
