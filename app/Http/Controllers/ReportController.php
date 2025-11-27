<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use PDF;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['items','user'])
            ->orderBy('created_at','desc');

        // Filter tanggal
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        // Filter pencarian kode/customer
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('kode', 'like', '%'.$q.'%')
                    ->orWhere('customer_name', 'like', '%'.$q.'%');
            });
        }

        // OPSIONAL: Filter user (kasir)
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // OPSIONAL: Filter metode bayar
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $transactions = $query->paginate(15);

        return view('backend.v_laporan.index', compact('transactions'));
    }

    public function exportCsv(Request $request)
    {
        $query = Transaction::with('items')->orderBy('created_at','desc');

        if ($request->filled('from')) $query->whereDate('created_at','>=',$request->from);
        if ($request->filled('to')) $query->whereDate('created_at','<=',$request->to);

        $rows = $query->get()->map(function ($tx) {
            return [
                'id' => $tx->id,
                'kode' => $tx->kode ?? '',
                'tanggal' => optional($tx->created_at)->toDateTimeString(),
                'customer' => $tx->customer_name ?? '',
                'total' => $tx->total,
                'items' => $tx->items->map(function ($it) {
                    return $it->product_name.' x'.$it->qty.($it->diskon ? ' (d:'.$it->diskon.')' : '');
                })->implode('; ')
            ];
        });

        $filename = 'laporan_transaksi_'.now()->format('YmdHis').'.csv';

        return new StreamedResponse(function () use ($rows) {
            $handle = fopen('php://output', 'w');

            // Tambah BOM UTF-8 agar CSV tidak rusak di Excel
            fwrite($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, ['id','kode','tanggal','customer','total','items']);
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = Transaction::with('items')->orderBy('created_at','desc');

        if ($request->filled('from')) $query->whereDate('created_at','>=',$request->from);
        if ($request->filled('to')) $query->whereDate('created_at','<=',$request->to);

        $transactions = $query->get();
        $grandTotal = $transactions->sum('total');

        $pdf = PDF::loadView('backend.v_laporan.pdf', [
            'transactions' => $transactions,
            'from' => $request->from,
            'to' => $request->to,
            'grandTotal' => $grandTotal,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('laporan_transaksi_' . now()->format('Ymd') . '.pdf');
    }

    
    public function exportXlsx(Request $request)
    {
        $query = Transaction::with(['items','user'])->orderBy('created_at','desc');
        if ($request->filled('from')) $query->whereDate('created_at','>=',$request->from);
        if ($request->filled('to')) $query->whereDate('created_at','<=',$request->to);

        // optional filters kept same as index (user_id/metode/q)
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use($q){
                $sub->where('kode','like','%'.$q.'%')
                    ->orWhere('customer_name','like','%'.$q.'%');
            });
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        $transactions = $query->get();

        $export = new TransactionsExport($transactions);

        $fileName = 'laporan_transaksi_'.now()->format('YmdHis').'.xlsx';

        return Excel::download($export, $fileName);
    }
}
