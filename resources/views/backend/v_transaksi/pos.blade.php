@extends('backend.v_layout.app')

@section('content')

<style>
/* ============================= */
/* FULL BACKGROUND PAGE */
/* ============================= */
.pos-full-wrapper {
    background: #f2f2f2;       /* abu-abu terang */
    min-height: calc(100vh - 60px);  /* tinggi penuh dikurangi header */
    padding: 20px;
    box-sizing: border-box;
}

/* POS layout */
.pos-container { 
    display:flex; 
    gap:20px; 
}

.pos-left { 
    flex: 2; 
}

.pos-right { 
    flex: 1; 
    max-width:500px; 
    background:white; 
    padding:15px; 
    border-radius:10px;
    box-shadow: 0 0 6px #00000015;
}

.product-grid { 
    display:flex; 
    flex-wrap:wrap; 
    gap:10px; 
}

.product { 
    border:1px solid #ddd; 
    padding:10px; 
    cursor:pointer; 
    width:130px; 
    text-align:center;
    background: white;
    border-radius:8px;
    transition:.2s;
}
.product:hover {
    background:#eaeaea;
}
</style>

<div class="pos-full-wrapper">

<br>
<h4>{{ $judul }}</h4>
<br>

<div class="pos-container">
    <div class="pos-left">
        <div class="product-grid">
            @foreach($produk as $p)
            <div class="product" 
                 data-id="{{ $p->id }}" 
                 data-harga="{{ $p->harga }}" 
                 data-name="{{ $p->nama_produk }}">
                 
                <strong>{{ $p->nama_produk }}</strong>
                <div>Rp {{ number_format($p->harga,0,',','.') }}</div>
                <div>Stok: {{ $p->stok }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="pos-right">
        <h5>Keranjang</h5>
        <table class="table" id="cart">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div class="mt-2 fw-bold">Total: 
            <span id="posTotal">Rp 0</span>
        </div>

        <button id="posCheckout" class="btn btn-primary mt-3 w-100">
            Checkout
        </button>
    </div>
</div>

</div> <!-- END WRAPPER -->

<script>
function formatRp(n){return 'Rp '+Number(n||0).toLocaleString('id-ID');}

const cart = [];

document.querySelectorAll('.product').forEach(el=>{
    el.addEventListener('click', ()=> {
        const id = el.dataset.id;
        let it = cart.find(x=>x.id==id);
        if(!it) { 
            cart.push({
                id, 
                name:el.dataset.name, 
                qty:1, 
                harga:Number(el.dataset.harga), 
                subtotal:Number(el.dataset.harga)
            }); 
        } else { 
            it.qty++; 
            it.subtotal = it.qty * it.harga; 
        }
        renderCart();
    });
});

function renderCart(){
    const tbody = document.querySelector('#cart tbody');
    tbody.innerHTML = '';
    let total = 0;
    cart.forEach(it=>{
        total += it.subtotal;
        const tr = document.createElement('tr');
        tr.innerHTML = `<td>${it.name}</td>
                        <td>${it.qty}</td>
                        <td>${formatRp(it.subtotal)}</td>`;
        tbody.appendChild(tr);
    });
    document.getElementById('posTotal').innerText = formatRp(total);
}

document.getElementById('posCheckout').addEventListener('click', ()=>{
    if(cart.length==0) return alert('Keranjang kosong');

    const form = document.createElement('form');
    form.method='POST';
    form.action='{{ route("backend.transaksi.store") }}';

    const csrf = document.createElement('input');
    csrf.type='hidden'; csrf.name='_token'; 
    csrf.value='{{ csrf_token() }}';
    form.appendChild(csrf);

    cart.forEach(it=>{
        form.appendChild(hidden('items[][produk_id]', it.id));
        form.appendChild(hidden('items[][qty]', it.qty));
        form.appendChild(hidden('items[][harga]', it.harga));
        form.appendChild(hidden('items[][subtotal]', it.subtotal));
    });

    form.appendChild(hidden('total', cart.reduce((s,i)=>s+i.subtotal,0)));
    document.body.appendChild(form);
    form.submit();
});

function hidden(name, val){ 
    const i=document.createElement('input'); 
    i.type='hidden'; i.name=name; i.value=val; 
    return i; 
}
</script>

@endsection
