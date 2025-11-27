<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        return view('backend.v_kategori.index', [
            'judul' => 'Data Kategori',
            'kategori' => Kategori::all()
        ]);
    }

    public function create()
    {
        return view('backend.v_kategori.create', [
            'judul' => 'Tambah Kategori'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori',
            'nama' => 'required'
        ]);

        Kategori::create($request->all());

        return redirect()->route('backend.kategori.index')->with('success', 'Kategori berhasil ditambah');
    }

    public function edit($id)
    {
        return view('backend.v_kategori.edit', [
            'judul' => 'Edit Kategori',
            'row' => Kategori::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required'
        ]);

        Kategori::findOrFail($id)->update($request->all());

        return redirect()->route('backend.kategori.index')->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect()->route('backend.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
