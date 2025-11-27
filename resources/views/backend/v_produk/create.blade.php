@extends('backend.v_layout.app')
@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="card-title">{{ $judul }}</h4>

        <form action="{{ route('backend.produk.store') }}" method="POST">
            @csrf

            <div class="row">

                <div class="col-md-6 mt-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Kode Produk</label>
                    <input type="text" name="kode_produk" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="">-- Pilih Satuan --</option>
                        <option value="pcs">Pcs</option>
                        <option value="kg">Kg</option>
                        <option value="lusin">Lusin</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-md-6 mt-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" required>
                </div>

                <div class="col-md-12 mt-3">
                    <label>Foto Produk</label>
                    <input type="file" name="foto" class="form-control">
                </div>

            </div>

            <button class="btn btn-primary mt-4">Simpan</button>
            <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary mt-4">Kembali</a>

        </form>

    </div>
</div>

@endsection
