<?php

namespace App\Exports\Sale\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function view(): View
    {
        return view('exports.sale.sale', [
            'sales' => $this->sales
        ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal Penjualan',
            'No. Invoice',
            'Nama Customer',
            'Nomor Telepon Customer',
            'Alamat Customer',
            'Metode Pembayaran',
            'Bank',
            'Total'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'H' => '0,000',
        ];
    }
}
