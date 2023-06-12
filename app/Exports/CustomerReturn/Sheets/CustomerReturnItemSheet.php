<?php

namespace App\Exports\CustomerReturn\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerReturnItemSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $customerReturnItems;

    public function __construct($customerReturnItems)
    {
        $this->customerReturnItems = $customerReturnItems;
    }

    public function view(): View
    {
        return view('exports.customer-return.customer-return-item', [
            'customer_return_items' => $this->customerReturnItems
        ]);
    }

    public function headings(): array
    {
        return [
            'No. Invoice Retur',
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
