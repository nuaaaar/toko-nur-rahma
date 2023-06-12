<?php

namespace App\Exports\Procurement;

use App\Exports\Procurement\Sheets\ProcurementItemSheet;
use App\Exports\Procurement\Sheets\ProcurementSheet;
use App\Models\Procurement;
use App\Models\ProcurementItem;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProcurementExport implements WithMultipleSheets
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
        $procurements = Procurement::with('supplier')->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo)->get();

        $procurementItems = ProcurementItem::with('product', 'procurement')->whereHas('procurement', function ($query) {
            $query->where('date', '>=', $this->dateFrom)->where('date', '<=', $this->dateTo);
        })->get();

        $sheets = [];

        $sheets[] = new ProcurementSheet($procurements);

        $sheets[] = new ProcurementItemSheet($procurementItems);

        return $sheets;
    }
}
