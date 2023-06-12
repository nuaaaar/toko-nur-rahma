<?php

namespace App\Exports\StockOpname;

use App\Exports\StockOpname\Sheets\StockOpnameItemSheet;
use App\Exports\StockOpname\Sheets\StockOpnameSheet;
use App\Models\StockOpname;
use App\Models\StockOpnameItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StockOpnameExport implements WithMultipleSheets
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
        $stockOpnames = StockOpname::with('customer', 'sale')->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo)->get();

        $stockOpnameItems = StockOpnameItem::with('product', 'stockOpname')->whereHas('stockOpname', function ($query) {
            $query->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo);
        })->get();

        $sheets = [];

        $sheets[] = new StockOpnameSheet($stockOpnames);

        $sheets[] = new StockOpnameItemSheet($stockOpnameItems);

        return $sheets;
    }
}
