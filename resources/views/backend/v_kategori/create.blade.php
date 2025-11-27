@extends('backend.v_layout.app')
@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="card-title">{{ $judul }}</h4>

        <form action="{{ route('backend.kategori.store') }}" method="POST">
            @csrf

            <div class="form-group mt-3">
                <label>Kode Kategori</label>
                <input type="text" name="kode" class="form-control" required placeholder="Contoh: KAT01">
            </div>

            <div class="form-group mt-3">
                <label>Nama Kategori</label>
                <input type="text" name="nama" class="form-control" required placeholder="Contoh: Sembako">
            </div>

            <button class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('backend.kategori.index') }}" class="btn btn-secondary mt-3">Kembali</a>

        </form>

    </div>
</div>

@endsection
