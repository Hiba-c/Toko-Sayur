@extends('backend.v_layout.app')
@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="card-title">{{ $judul }}</h4>

        <form action="{{ route('backend.produk.update', $row->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">

                <div class="col-md-6 mt-3">
                    <label>Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ $row->nama_produk }}" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Kode Produk</label>
                    <input type="text" name="kode_produk" value="{{ $row->kode_produk }}" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Satuan</label>
                    <select name="satuan" class="form-control" required>
                        <option value="pcs" {{ $row->satuan=='pcs'?'selected':'' }}>Pcs</option>
                        <option value="kg" {{ $row->satuan=='kg'?'selected':'' }}>Kg</option>
                        <option value="lusin" {{ $row->satuan=='lusin'?'selected':'' }}>Lusin</option>
                    </select>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Harga</label>
                    <input type="number" name="harga" value="{{ $row->harga }}" class="form-control" required>
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
                    <input type="number" name="stok" value="{{ $row->stok }}" class="form-control" required>
                </div>

                <div class="col-md-6 mt-3">
                    <label>Foto Produk</label>
                    <input type="file" name="foto" class="form-control">

                    @if($row->foto)
                    <img src="{{ asset('storage/'.$row->foto) }}" width="120" class="mt-3 rounded">
                    @endif
                </div>

            </div>

            <button class="btn btn-success mt-4">Update</button>
            <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary mt-4">Kembali</a>

        </form>

    </div>
</div>

@endsection
