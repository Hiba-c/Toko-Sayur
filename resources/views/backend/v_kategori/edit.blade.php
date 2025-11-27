@extends('backend.v_layout.app')
@section('content')

<div class="card">
    <div class="card-body">

        <h4 class="card-title">{{ $judul }}</h4>

        <form action="{{ route('backend.kategori.update', $row->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mt-3">
                <label>Kode Kategori</label>
                <input type="text" name="kode" class="form-control" value="{{ $row->kode }}" required>
            </div>

            <div class="form-group mt-3">
                <label>Nama Kategori</label>
                <input type="text" name="nama" class="form-control" value="{{ $row->nama }}" required>
            </div>

            <button class="btn btn-success mt-3">Update</button>
            <a href="{{ route('backend.kategori.index') }}" class="btn btn-secondary mt-3">Kembali</a>

        </form>

    </div>
</div>

@endsection
