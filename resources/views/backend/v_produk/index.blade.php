@extends('backend.v_layout.app')
@section('content')
<br>
<div class="row">
    <div class="col-12">

        <a href="{{ route('backend.produk.create') }}">
            <button class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Produk</button>
        </a>

        <div class="card mt-3">
            <div class="card-body">

                <h5 class="card-title">{{ $judul }}</h5>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kode</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($produk as $row)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $row->nama_produk }}</td>
                                <td>{{ $row->kode_produk }}</td>
                                <td>{{ $row->satuan }}</td>
                                <td>Rp{{ number_format($row->harga,0,',','.') }}</td>
                                <td>{{ $row->kategori->nama }}</td>
                                <td>{{ $row->stok }}</td>

                                <td>
                                    <img src="{{ asset('storage/img-produk/'.$row->foto) }}"
                                         width="60" class="rounded">
                                </td>

                                <td>
                                    <a href="{{ route('backend.produk.edit',$row->id) }}">
                                        <button class="btn btn-success btn-sm">Ubah</button>
                                    </a>

                                    <form action="{{ route('backend.produk.destroy',$row->id) }}"
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
</div>

@endsection
