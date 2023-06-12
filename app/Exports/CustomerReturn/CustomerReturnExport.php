<?php

namespace App\Exports\CustomerReturn;

use App\Exports\CustomerReturn\Sheets\CustomerReturnItemSheet;
use App\Exports\CustomerReturn\Sheets\CustomerReturnSheet;
use App\Models\CustomerReturn;
use App\Models\CustomerReturnItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CustomerReturnExport implements WithMultipleSheets
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
        $customerReturns = CustomerReturn::with('customer', 'sale')->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo)->get();

        $customerReturnItems = CustomerReturnItem::with('product', 'customerReturn')->whereHas('customerReturn', function ($query) {
            $query->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo);
        })->get();

        $sheets = [];

        $sheets[] = new CustomerReturnSheet($customerReturns);

        $sheets[] = new CustomerReturnItemSheet($customerReturnItems);

        return $sheets;
    }
}
