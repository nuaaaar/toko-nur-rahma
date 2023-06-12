<?php

namespace App\Exports\Sale\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SaleItemSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $saleItems;

    public function __construct($saleItems)
    {
        $this->saleItems = $saleItems;
    }

    public function view(): View
    {
        return view('exports.sale.sale-item', [
            'sale_items' => $this->saleItems
        ]);
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Nama Barang',
            'Satuan',
            'Harga Satuan',
            'Qty',
            'Total'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => '0,000',
            'E' => '0',
            'F' => '0,000',
        ];
    }
}
