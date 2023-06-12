<?php

namespace App\Exports\PurchaseOrder\Sheets;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchaseOrderSheet implements FromView, ShouldAutoSize, WithHeadings, WithColumnFormatting
{
    protected $purchaseOrders;

    public function __construct($purchaseOrders)
    {
        $this->purchaseOrders = $purchaseOrders;
    }

    public function view(): View
    {
        return view('exports.purchase-order.purchase-order', [
            'purchase_orders' => $this->purchaseOrders
        ]);
    }

    public function headings(): array
    {
        return [
            'Tanggal PO',
            'No. Invoice',
            'Status',
            'Nama Customer',
            'Nomor Telepon Customer',
            'Alamat Customer',
            'Total'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => '0,000',
        ];
    }
}
