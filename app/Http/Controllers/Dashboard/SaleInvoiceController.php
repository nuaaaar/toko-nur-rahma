<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Sale\SaleService;
use Illuminate\Http\Request;

class SaleInvoiceController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;

        $this->middleware('permission:sales.read');
    }

    public function __invoke($id)
    {
        return $this->invoice($id);
    }

    public function invoice($id)
    {
        $data['sale'] = $this->saleService->findById($id);

        return view('dashboard.sale.invoice', $data);
    }
}
