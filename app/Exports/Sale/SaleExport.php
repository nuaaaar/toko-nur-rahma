<?php

namespace App\Exports\Sale;

use App\Exports\Sale\Sheets\SaleItemSheet;
use App\Exports\Sale\Sheets\SaleSheet;
use App\Models\Sale;
use App\Models\SaleItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SaleExport implements WithMultipleSheets
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
        $procurements = Sale::with('customer', 'bank')->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo)->get();

        $procurementItems = SaleItem::with('product', 'sale')->whereHas('sale', function ($query) {
            $query->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo);
        })->get();

        $sheets = [];

        $sheets[] = new SaleSheet($procurements);

        $sheets[] = new SaleItemSheet($procurementItems);

        return $sheets;
    }
}
