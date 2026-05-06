<?php

namespace App\Http\Controllers;

use App\Models\OrangTua;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function index(): View
    {
        $orangTua = OrangTua::latest()->paginate(10);

        return view('dashboard.orang-tua.index', compact('orangTua'));
    }

    public function create()
    {
        return view('dashboard.orang-tua.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:orang_tua,email',
        ]);

        OrangTua::create($validated);

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil ditambahkan.');
    }

    public function edit(OrangTua $orangTua)
    {
        return view('dashboard.orang-tua.edit', compact('orangTua'));
    }

    public function update(Request $request, OrangTua $orangTua)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:orang_tua,email,' . $orangTua->id,
        ]);

        $orangTua->update($validated);

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil diubah.');
    }

    public function destroy(OrangTua $orangTua)
    {
        $orangTua->delete();

        return redirect()->route('orang-tua.index')->with('success', 'Data Orang Tua berhasil dihapus.');
    }
}
