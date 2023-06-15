<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PurchaseOrder\PurchaseOrderService;

class PurchaseOrderInvoiceController extends Controller
{
    protected $purchaseOrderService;

    public function __construct(PurchaseOrderService $purchaseOrderService)
    {
        $this->purchaseOrderService = $purchaseOrderService;

        $this->middleware('permission:purchase-orders.read');
    }

    public function __invoke($id)
    {
        return $this->invoice($id);
    }

    public function invoice($id)
    {
        $data['purchase_order'] = $this->purchaseOrderService->findById($id);

        return view('dashboard.purchase-order.invoice', $data);
    }
}
