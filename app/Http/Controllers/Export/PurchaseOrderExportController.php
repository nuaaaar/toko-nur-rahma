<?php

namespace App\Http\Controllers\Export;

use App\Exports\PurchaseOrder\PurchaseOrderExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseOrderExportController extends Controller
{
    public function __invoke(Request $request)
    {
        return $this->export($request);
    }

    public function export(Request $request)
    {
        $dateFrom = $request->date_from ?? date('Y-m-01');

        $dateTo = $request->date_to ?? date('Y-m-d');

        return Excel::download(new PurchaseOrderExport($dateFrom, $dateTo), date('Y_m_d').'_Data PO.xlsx');
    }
}
