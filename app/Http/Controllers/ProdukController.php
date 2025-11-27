<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->get();

        return view('backend.v_produk.index', [
            'judul' => 'Data Produk',
            'produk' => $produk
        ]);
    }

    public function create()
    {
        // dd(Kategori::all()->toArray()); #mencari data
        return view('backend.v_produk.create', [
            'judul' => 'Tambah Produk',
            'kategori' => Kategori::all()
        ]);
    }

    public function store(Request $request)
    {
        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('img-produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'kode_produk' => $request->kode_produk,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'foto' => $foto
        ]);

        return redirect()->route('backend.produk.index');
    }

        public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // validasi
        $request->validate([
            'nama_produk' => 'required',
            'kode_produk' => 'required',
            'satuan' => 'required',
            'harga' => 'required|numeric',
            'kategori_id' => 'required|integer',
            'stok' => 'required|integer',
            'foto' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        // update foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('img-produk', 'public');
            $produk->foto = $foto;
        }

        // update data lainnya
        $produk->nama_produk = $request->nama_produk;
        $produk->kode_produk = $request->kode_produk;
        $produk->satuan = $request->satuan;
        $produk->harga = $request->harga;
        $produk->kategori_id = $request->kategori_id;
        $produk->stok = $request->stok;

        $produk->save();

        return redirect()->route('backend.produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function edit($id)
    {
        return view('backend.v_produk.edit', [
            'judul' => 'Edit Produk',
            'row' => Produk::findOrFail($id),
            'kategori' => Kategori::all()
        ]);
    }
}
