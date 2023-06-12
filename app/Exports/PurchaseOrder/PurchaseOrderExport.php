<?php

namespace App\Exports\PurchaseOrder;

use App\Exports\PurchaseOrder\Sheets\PurchaseOrderItemSheet;
use App\Exports\PurchaseOrder\Sheets\PurchaseOrderSheet;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PurchaseOrderExport implements WithMultipleSheets
{
    protected $dateFrom;

    protected $dateTo;

    public function __construct($dateFrom, $dateTo)
    {
        $this->dateFrom = $dateFrom;

        $this->dateTo = $dateTo;
    }

    public function sheets(): array
    {
        $purchaseOrders = PurchaseOrder::with('customer', 'sale')->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo)->get();

        $purchaseOrderItems = PurchaseOrderItem::with('product', 'purchaseOrder')->whereHas('purchaseOrder', function ($query) {
            $query->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo);
        })->get();

        $sheets = [];

        $sheets[] = new PurchaseOrderSheet($purchaseOrders);

        $sheets[] = new PurchaseOrderItemSheet($purchaseOrderItems);

        return $sheets;
    }
}
