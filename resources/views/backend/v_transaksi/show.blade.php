@extends('backend.v_layout.app')

@section('content')
<h4>{{ $judul }}</h4>

<p><strong>Tanggal:</strong> {{ $trx->created_at }}</p>
<p><strong>Kasir:</strong> {{ $trx->user->nama ?? '-' }}</p>

<table class="table table-bordered">
    <thead><tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr></thead>
    <tbody>
        @foreach($trx->items as $it)
        <tr>
            <td>{{ $it->produk->nama_produk }}</td>
            <td>Rp {{ number_format($it->harga,0,',','.') }}</td>
            <td>{{ $it->qty }}</td>
            <td>Rp {{ number_format($it->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<h4>Total: Rp {{ number_format($trx->total,0,',','.') }}</h4>
@endsection
