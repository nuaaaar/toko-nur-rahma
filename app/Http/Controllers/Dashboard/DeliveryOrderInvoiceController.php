<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DeliveryOrder\DeliveryOrderService;

class DeliveryOrderInvoiceController extends Controller
{
    protected $deliveryOrderService;

    public function __construct(DeliveryOrderService $deliveryOrderService)
    {
        $this->deliveryOrderService = $deliveryOrderService;

        $this->middleware('permission:delivery-orders.read');
    }

    public function __invoke($id)
    {
        return $this->invoice($id);
    }

    public function invoice($id)
    {
        $data['delivery_order'] = $this->deliveryOrderService->findById($id);

        return view('dashboard.delivery-order.invoice', $data);
    }
}
