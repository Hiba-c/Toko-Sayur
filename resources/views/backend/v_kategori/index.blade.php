@extends('backend.v_layout.app')
@section('content')
<br>
<div class="row">
    <div class="col-12">

            <a href="{{ route('backend.kategori.create') }}">
                <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
            </a>
            <br><br>
        <div class="card">
            <div class="card-body">

                <h5 class="card-title">{{ $judul }}</h5>

                <!-- FILTER -->
            <!-- <form method="GET" class="mb-3">
                    <div class="row">

                        <div class="col-md-4">
                    <select name="kategori_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode...">
                        </div>

                        <div class="col-md-4">
                            <button class="btn btn-primary">Filter</button>
                        </div>

                    </div>
                </form> -->

                <!-- TABEL -->
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->kode }}</td>
                            <td>{{ $row->nama }}</td>
                                                            <td>
                                    <a href="{{ route('backend.kategori.edit',$row->id) }}">
                                        <button class="btn btn-success btn-sm">Ubah</button>
                                    </a>

                                    <form action="{{ route('backend.kategori.destroy',$row->id) }}"
                                          method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm show_confirm">Hapus</button>
                                    </form>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
