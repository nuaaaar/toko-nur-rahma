<?php

namespace App\Exports\Procurement\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProcurementItemSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $procurementItems;

    public function __construct($procurementItems)
    {
        $this->procurementItems = $procurementItems;
    }

    public function view(): View
    {
        return view('exports.procurement.procurement-item', [
            'procurement_items' => $this->procurementItems
        ]);
    }

    public function headings(): array
    {
        return [
            'No. Invoice Agen',
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
