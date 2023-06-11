<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryOrder\CreateDeliveryOrderRequest;
use App\Http\Requests\DeliveryOrder\UpdateDeliveryOrderRequest;
use App\Services\Customer\CustomerService;
use App\Services\DeliveryOrder\DeliveryOrderService;
use App\Services\DeliveryOrderItem\DeliveryOrderItemService;
use App\Services\Product\ProductService;
use App\Services\ProductStock\ProductStockService;
use App\Services\PurchaseOrder\PurchaseOrderService;
use DB;
use Illuminate\Http\Request;
use Log;

class DeliveryOrderController extends Controller
{
    protected $customerService;

    protected $deliveryOrderService;

    protected $deliveryOrderItemService;

    protected $productService;

    protected $productStockService;

    protected $purchaseOrderService;

    public function __construct(CustomerService $customerService, DeliveryOrderService $deliveryOrderService, DeliveryOrderItemService $deliveryOrderItemService, ProductService $productService, ProductStockService $productStockService, PurchaseOrderService $purchaseOrderService)
    {
        $this->customerService = $customerService;
        $this->deliveryOrderService = $deliveryOrderService;
        $this->deliveryOrderItemService = $deliveryOrderItemService;
        $this->productService = $productService;
        $this->productStockService = $productStockService;
        $this->purchaseOrderService = $purchaseOrderService;

        $this->middleware('permission:delivery-orders.read')->only(['index', 'show']);
        $this->middleware('permission:delivery-orders.create')->only(['create', 'store']);
        $this->middleware('permission:delivery-orders.update')->only(['edit', 'update']);
        $this->middleware('permission:delivery-orders.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['customers'] = $this->customerService->getCustomers('name', 'asc', null, 0);
        $data['delivery_orders'] = $this->deliveryOrderService->getDeliveryOrders($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.delivery-order.index', $data);
    }

    public function create(Request $request)
    {
        $data['purchase_order'] = $this->purchaseOrderService->findByInvoiceNumber($request->invoice_number ?? '');

        if(!$data['purchase_order']) return redirect()->route('dashboard.delivery-order.index')->with('error', 'Data purchase order tidak ditemukan');

        return view('dashboard.delivery-order.create', $data);
    }

    public function store(CreateDeliveryOrderRequest $request)
    {
        DB::beginTransaction();
        try{
            $deliveryOrder = $this->deliveryOrderService->create($request->all());

            $this->productStockService->upsertProductStocksFromEveryProductByDate('delivery_order', null, $request->date, null, $request->delivery_order_items);

            $this->deliveryOrderItemService->insertDeliveryOrderItems($request->delivery_order_items, $deliveryOrder->id);

            $this->purchaseOrderService->changeStatus($request->purchase_order_id, 'diproses');

            DB::commit();
            return redirect()->route('dashboard.delivery-order.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['delivery_order'] = $this->deliveryOrderService->findById($id);

        if(!$data['delivery_order']) return abort(404);

        $data['purchase_order'] = $this->purchaseOrderService->findByInvoiceNumber($data['delivery_order']->purchaseOrder->invoice_number ?? '');

        return view('dashboard.delivery-order.edit', $data);
    }

    public function update(UpdateDeliveryOrderRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $deliveryOrder = $this->deliveryOrderService->findById($id);

            $oldDeliveryOrderDate = $deliveryOrder->date;

            $oldDeliveryOrderItems = $deliveryOrder->deliveryOrderItems->toArray();

            $this->productStockService->upsertProductStocksFromEveryProductByDate('delivery_order', $oldDeliveryOrderDate, $request->date, $oldDeliveryOrderItems, $request->delivery_order_items);

            $this->deliveryOrderService->update($id, $request->all());

            DB::commit();
            return redirect()->route('dashboard.delivery-order.index')->with('success', 'Berhasil mengubah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $deliveryOrder = $this->deliveryOrderService->findById($id);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('delivery_order', null, $deliveryOrder->date, $deliveryOrder->deliveryOrderItems->toArray(), null);

            $this->deliveryOrderService->delete($id);

            $purchaseOrder = $this->purchaseOrderService->findByInvoiceNumber($deliveryOrder->purchaseOrder->invoice_number ?? '');

            if($purchaseOrder->deliveryOrderItems->sum('qty')  == 0) $this->purchaseOrderService->changeStatus($purchaseOrder->id, 'menunggu');

            DB::commit();
            return redirect()->route('dashboard.delivery-order.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
