{{-- resources/views/backend/v_laporan/pdf.blade.php --}}
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size:12px; color:#222; }
        .header { text-align:center; margin-bottom:10px }
        .company { font-size:16px; font-weight:700 }
        .meta { font-size:12px; margin-bottom:8px; }
        table { width:100%; border-collapse: collapse; font-size:11px }
        th, td { border: 1px solid #ddd; padding:6px; vertical-align:top }
        th { background:#f5f5f5; }
        .right { text-align:right }
        .small { font-size:10px; color:#555 }
    </style>
</head>
<body>
    <div class="header">
        <div class="company">SayurKu</div>
        <div class="small">Laporan Transaksi</div>
        <div class="meta">Periode: {{ $from ?? '-' }} s/d {{ $to ?? '-' }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:3%">#</th>
                <th style="width:12%">No. Trx</th>
                <th style="width:14%">Tanggal</th>
                <th>Pelanggan</th>
                <th style="width:28%">Items</th>
                <th style="width:13%">Total</th>
                <th style="width:10%">Kasir</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $tx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $tx->kode ?? $tx->id }}</td>
                <td>{{ optional($tx->created_at)->format('Y-m-d H:i') }}</td>
                <td>{{ $tx->customer_name ?? '-' }}</td>
                <td>
                    @foreach($tx->items as $it)
                        <div style="margin-bottom:4px;">
                            {{ $it->product_name }} x{{ $it->qty }}
                            @if($it->diskon) <span class="small"> (d: {{ $it->diskon }})</span> @endif
                        </div>
                    @endforeach
                </td>
                <td class="right">{{ number_format($tx->total,0,',','.') }}</td>
                <td>{{ optional($tx->user)->nama ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:10px; text-align:right">
        <strong>Total Semua: {{ number_format($grandTotal ?? $transactions->sum('total') ?? 0,0,',','.') }}</strong>
    </div>
</body>
</html>
