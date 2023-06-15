<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\CustomerReturn\CustomerReturnService;

class CustomerReturnInvoiceController extends Controller
{
    protected $customerReturnService;

    public function __construct(CustomerReturnService $customerReturnService)
    {
        $this->customerReturnService = $customerReturnService;

        $this->middleware('permission:customerReturns.read');
    }

    public function __invoke($id)
    {
        return $this->invoice($id);
    }

    public function invoice($id)
    {
        $data['customer_return'] = $this->customerReturnService->findById($id);

        return view('dashboard.customer-return.invoice', $data);
    }
}
