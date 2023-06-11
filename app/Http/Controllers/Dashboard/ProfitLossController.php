<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CustomerReturn\CustomerReturnService;
use App\Services\Procurement\ProcurementService;
use App\Services\Sale\SaleService;
use Illuminate\Http\Request;

class ProfitLossController extends Controller
{
    protected $customerReturnService;

    protected $procurementService;

    protected $saleService;

    public function __construct(CustomerReturnService $customerReturnService, ProcurementService $procurementService, SaleService $saleService)
    {
        $this->customerReturnService = $customerReturnService;
        $this->procurementService = $procurementService;
        $this->saleService = $saleService;

        $this->middleware(['permission:profit-loss.read'], ['only' => ['index']]);
    }

    public function index(Request $request)
    {
        $request['filters']  = [
            'date_from' => $request->filters['date_from'] ?? date('Y-m-01'),
            'date_to' => $request->filters['date_to'] ?? date('Y-m-d'),
        ];

        $data['customer_returns'] = $this->customerReturnService->getCustomerReturns('date', 'desc', $request->filters, null, 0);
        $data['procurements'] = $this->procurementService->getProcurementsWithSupplierAndItems('date', 'desc', $request->filters, null, 0);
        $data['sales'] = $this->saleService->getSales('date', 'desc', $request->filters, null, 0);
        $data['total_profit_loss'] = $data['sales']->sum('total') - $data['procurements']->sum('total') - $data['customer_returns']->sum('total');

        return view('dashboard.profit-loss.index', $data);
    }

}
