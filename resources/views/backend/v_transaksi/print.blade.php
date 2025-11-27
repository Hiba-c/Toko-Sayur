<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Transaksi #{{ $trx->id }}</title>
    <style>
        body{font-family: monospace; font-size:12px; width:280px; }
        .center{text-align:center;}
        table{width:100%;}
        .right{text-align:right;}
    </style>
</head>
<body onload="window.print()">
    <div class="center">
        <h3>Toko Sayur</h3>
        <div>{{ $trx->created_at }}</div>
    </div>

    <table>
        <tbody>
        @foreach($trx->items as $it)
            <tr>
                <td>{{ $it->produk->nama_produk }} x{{ $it->qty }}</td>
                <td class="right">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <hr>
    <table>
        <tr><td>Total</td><td class="right">Rp {{ number_format($trx->total,0,',','.') }}</td></tr>
        <tr><td>Bayar</td><td class="right">Rp {{ number_format($trx->bayar,0,',','.') }}</td></tr>
        <tr><td>Kembalian</td><td class="right">Rp {{ number_format($trx->kembalian,0,',','.') }}</td></tr>
    </table>

    <div class="center">
        <p>Terima kasih - Datang Lagi</p>
    </div>
</body>
</html>
