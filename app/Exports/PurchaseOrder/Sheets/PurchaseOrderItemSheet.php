<?php

namespace App\Exports\PurchaseOrder\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrderItemSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $purchaseOrderItems;

    public function __construct($purchaseOrderItems)
    {
        $this->purchaseOrderItems = $purchaseOrderItems;
    }

    public function view(): View
    {
        return view('exports.purchase-order.purchase-order-item', [
            'purchase_order_items' => $this->purchaseOrderItems
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
