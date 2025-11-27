<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $data = Transaction::with('user')->orderBy('id', 'desc')->paginate(30);
        $judul = "Data Transaksi Penjualan";
        return view('backend.v_transaksi.index', compact('data','judul'));
    }

    public function create()
    {
        $produk = Produk::orderBy('nama_produk')->get(); // gunakan nama_produk
        $judul = "Transaksi Baru";
        return view('backend.v_transaksi.create', compact('produk','judul'));
    }

    // alias sama dengan create (bila mau gunakan route resource create)
    public function pos()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $judul = "POS - Kasir";
        return view('backend.v_transaksi.pos', compact('produk','judul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|integer|exists:produk,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'bayar' => 'nullable|numeric|min:0',
            'kembalian' => 'nullable|numeric',
        ]);

        DB::beginTransaction();
        try {
            // create transaction
            $trx = Transaction::create([
                'user_id' => auth()->id(),
                'total' => $request->total,
                'bayar' => $request->bayar ?? 0,
                'kembalian' => $request->kembalian ?? 0,
            ]);

            // save items & adjust stok
            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);

                // cek stok
                if ($produk->stok < $item['qty']) {
                    DB::rollBack();
                    return back()->with('error', "Stok produk {$produk->nama_produk} tidak mencukupi (tersisa {$produk->stok}).");
                }

                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'produk_id' => $item['produk_id'],
                    'qty' => $item['qty'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                // decrement stok
                $produk->decrement('stok', $item['qty']);
            }

            DB::commit();
            return redirect()->route('backend.transaksi.index')->with('success','Transaksi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Gagal menyimpan transaksi: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $trx = Transaction::with('items.produk', 'user')->findOrFail($id);
        $judul = "Detail Transaksi";
        return view('backend.v_transaksi.show', compact('trx','judul'));
    }

    public function print($id)
    {
        $trx = Transaction::with('items.produk', 'user')->findOrFail($id);
        // printable minimal
        return view('backend.v_transaksi.print', compact('trx'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $trx = Transaction::with('items')->findOrFail($id);

            // restore stok
            foreach ($trx->items as $item) {
                Produk::where('id', $item->produk_id)->increment('stok', $item->qty);
            }

            $trx->items()->delete();
            $trx->delete();

            DB::commit();
            return back()->with('success','Transaksi dihapus dan stok dipulihkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Gagal menghapus transaksi: '.$e->getMessage());
        }
    }
}
