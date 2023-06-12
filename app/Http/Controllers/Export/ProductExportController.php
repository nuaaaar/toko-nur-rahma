<?php

namespace App\Http\Controllers\Export;

use App\Exports\Product\ProductExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return $this->export();
    }

    public function export()
    {
        return Excel::download(new ProductExport, date('Y_m_d').'_Data Produk.xlsx');
    }
}
