{{-- resources/views/backend/v_laporan/index.blade.php --}}
@extends('backend.v_layout.app')
<br>
@section('content')
<br><br>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Laporan Transaksi</h3>
        <div>
            <a href="{{ route('backend.laporan.export.csv', request()->query()) }}" class="btn btn-outline-secondary">Export CSV</a>
            <a href="{{ route('backend.laporan.export.xlsx', request()->query()) }}" class="btn btn-outline-success">Export XLSX</a>
            <a href="{{ route('backend.laporan.export.pdf', request()->query()) }}" target="_blank" class="btn btn-outline-danger">Export PDF</a>
        </div>
    </div>

    <form class="row g-2 mb-3" method="GET" action="{{ route('backend.laporan.index') }}">
        <div class="col-md-2">
            <label class="form-label">Dari</label>
            <input type="date" name="from" value="{{ request('from') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Sampai</label>
            <input type="date" name="to" value="{{ request('to') }}" class="form-control">
        </div>

        <div class="col-md-3">
            <label class="form-label">Cari (No trx / Pelanggan)</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="kode atau nama pelanggan">
        </div>

        <div class="col-md-2">
            <label class="form-label">Kasir</label>
            <select name="user_id" class="form-select">
                <option value="">-- semua --</option>
                @foreach(\App\Models\User::orderBy('nama')->get() as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label">Metode Bayar</label>
            <select name="metode" class="form-select">
                <option value="">-- semua --</option>
                <option value="cash" {{ request('metode')=='cash' ? 'selected' : '' }}>Cash</option>
                <option value="debit" {{ request('metode')=='debit' ? 'selected' : '' }}>Debit</option>
                <option value="ewallet" {{ request('metode')=='ewallet' ? 'selected' : '' }}>E-Wallet</option>
            </select>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-sm table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Trx</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th class="text-end">Total</th>
                            <th>Kasir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $tx)
                            <tr>
                                <td>{{ $loop->iteration + ($transactions->currentPage()-1)*$transactions->perPage() }}</td>
                                <td>{{ $tx->kode ?? $tx->id }}</td>
                                <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $tx->customer_name ?? '-' }}</td>
                                <td style="min-width:210px;">
                                    @foreach($tx->items as $it)
                                        <div style="font-size:13px">
                                            <strong>{{ $it->product_name }}</strong> x{{ $it->qty }}
                                            @if($it->diskon) <small class="text-muted">(diskon: {{ $it->diskon }})</small>@endif
                                        </div>
                                    @endforeach
                                </td>
                                <td class="text-end">{{ number_format($tx->total,0,',','.') }}</td>
                                <td>{{ optional($tx->user)->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('backend.transaksi.print', $tx->id) }}" class="btn btn-sm btn-outline-primary" target="_blank">Print</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">Tidak ada data.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-end"><strong>Jumlah Halaman Ini:</strong></td>
                            <td class="text-end"><strong>{{ number_format($transactions->sum('total'),0,',','.') }}</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between align-items-center">
        <div>Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi</div>
        <div>{{ $transactions->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
