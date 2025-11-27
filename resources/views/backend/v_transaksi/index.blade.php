@extends('backend.v_layout.app')

@section('content')
<br>
<h4>{{ $judul }}</h4>
<br>
<a href="{{ route('backend.transaksi.create') }}" class="btn btn-success mb-2">Buat Transaksi</a>
<a href="{{ route('backend.pos') }}" class="btn btn-primary mb-2">Mode POS</a>

<table class="table table-striped">
    <thead>
        <tr><th>#</th><th>Tanggal</th><th>Kasir</th><th>Total</th><th>Aksi</th></tr>
    </thead>
    <br><br>
    <tbody>
        @foreach($data as $row)
        <tr>
            <td>{{ $loop->iteration + ($data->currentPage()-1)*$data->perPage() }}</td>
            <td>{{ $row->created_at }}</td>
            <td>{{ $row->user->nama ?? '-' }}</td>
            <td>Rp {{ number_format($row->total,0,',','.') }}</td>
            <td>
                <a href="{{ route('backend.transaksi.show',$row->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('backend.transaksi.print',$row->id) }}" target="_blank" class="btn btn-secondary btn-sm">Print</a>
                <form action="{{ route('backend.transaksi.destroy',$row->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini? stok akan dikembalikan')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $data->links() }}
@endsection
