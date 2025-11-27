@extends('backend.v_layout.app')

@section('content')
<h4>{{ $judul }}</h4>

<form method="POST" action="{{ route('backend.transaksi.store') }}">
    @csrf

    <table class="table" id="tblItems">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Diskon (%)</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <button type="button" class="btn btn-success" id="addRow">+ Tambah Item</button>

    <div class="mt-3">
        <label>Total</label>
        <h3 id="totalDisplay">Rp 0</h3>
        <input type="hidden" name="total" id="inputTotal">
    </div>

    <div class="row mt-2">
        <div class="col-md-4">
            <label>Diskon Total (%)</label>
            <input type="number" id="diskon_total" class="form-control" min="0" value="0">
        </div>
        <div class="col-md-4">
            <label>Bayar</label>
            <input type="number" id="bayar" name="bayar" class="form-control" value="0">
        </div>
        <div class="col-md-4">
            <label>Kembalian</label>
            <input type="number" id="kembalian" name="kembalian" class="form-control" readonly>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Simpan Transaksi</button>
</form>

<script>
let produk = @json($produk);

function formatRp(n) {
    return 'Rp ' + Number(n || 0).toLocaleString('id-ID');
}

document.getElementById('addRow').addEventListener('click', () => {
    const tbody = document.querySelector('#tblItems tbody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="items[][produk_id]" class="form-control produkSelect">
                <option value="">-- Pilih --</option>
                ${produk.map(p=>`<option value="${p.id}" data-harga="${p.harga}">${p.nama_produk}</option>`).join('')}
            </select>
        </td>
        <td><input type="number" name="items[][harga]" class="form-control harga" readonly></td>
        <td><input type="number" name="items[][diskon]" class="form-control diskon" min="0" value="0"></td>
        <td><input type="number" name="items[][qty]" class="form-control qty" min="1" value="1"></td>
        <td><input type="number" name="items[][subtotal]" class="form-control subtotal" readonly></td>
        <td><button type="button" class="btn btn-danger delRow">X</button></td>
    `;
    tbody.appendChild(row);
});

document.addEventListener('change', (e) => {
    if (e.target.classList.contains('produkSelect')) {
        let harga = e.target.selectedOptions[0].dataset.harga;
        let row = e.target.closest('tr');
        row.querySelector('.harga').value = harga;
        hitungSubtotal(row);
    }
    if (e.target.classList.contains('qty') || e.target.classList.contains('diskon')) {
        hitungSubtotal(e.target.closest('tr'));
    }
});

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('delRow')) {
        e.target.closest('tr').remove();
        hitungTotal();
    }
});

document.getElementById('diskon_total').addEventListener('input', hitungTotal);
document.getElementById('bayar').addEventListener('input', hitungKembalian);

function hitungSubtotal(row) {
    let harga = Number(row.querySelector('.harga').value || 0);
    let qty = Number(row.querySelector('.qty').value || 0);
    let diskon = Number(row.querySelector('.diskon').value || 0);
    let subtotal = harga * qty;
    if (diskon > 0) {
        subtotal = subtotal - (subtotal * (diskon/100));
    }
    row.querySelector('.subtotal').value = subtotal;
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(e => total += Number(e.value || 0));
    let diskon_total = Number(document.getElementById('diskon_total').value || 0);
    if (diskon_total > 0) total = total - (total * (diskon_total/100));
    document.getElementById('totalDisplay').innerText = formatRp(total);
    document.getElementById('inputTotal').value = total;
    hitungKembalian();
}

function hitungKembalian() {
    let bayar = Number(document.getElementById('bayar').value || 0);
    let total = Number(document.getElementById('inputTotal').value || 0);
    let kembalian = bayar - total;
    document.getElementById('kembalian').value = kembalian;
}
</script>
@endsection
