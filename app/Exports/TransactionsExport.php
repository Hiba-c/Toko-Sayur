<?php
// app/Exports/TransactionsExport.php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $rows;

    /**
     * Expect a Collection of Transaction models (with items & user preloaded).
     */
    public function __construct(Collection $transactions)
    {
        $this->rows = $transactions->map(function($tx){
            return [
                'id' => $tx->id,
                'kode' => $tx->kode ?? '',
                'tanggal' => optional($tx->created_at)->toDateTimeString(),
                'customer' => $tx->customer_name ?? '',
                'total' => $tx->total,
                'kasir' => optional($tx->user)->nama ?? '',
                'items' => $tx->items->map(function($it){
                    return $it->product_name.' x'.$it->qty.($it->diskon ? ' (d:'.$it->diskon.')' : '');
                })->implode('; ')
            ];
        });
    }

    public function collection()
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return ['id','kode','tanggal','customer','total','kasir','items'];
    }
}
