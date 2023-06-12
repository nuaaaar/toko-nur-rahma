<?php

namespace App\Exports\StockOpname\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockOpnameItemSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $purchaseOrderItems;

    public function __construct($purchaseOrderItems)
    {
        $this->purchaseOrderItems = $purchaseOrderItems;
    }

    public function view(): View
    {
        return view('exports.stock-opname.stock-opname-item', [
            'stock_opname_items' => $this->purchaseOrderItems
        ]);
    }

    public function headings(): array
    {
        return [
            'No. Invoice',
            'Nama Barang',
            'Fisik',
            'Retur Supplier',
            'Aktual',
            'Sistem',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => '0',
            'D' => '0',
            'E' => '0',
            'F' => '0',
        ];
    }
}
