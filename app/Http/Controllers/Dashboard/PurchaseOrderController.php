<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseOrder\CreatePurchaseOrderRequest;
use App\Http\Requests\PurchaseOrder\UpdatePurchaseOrderRequest;
use App\Services\Bank\BankService;
use App\Services\PurchaseOrder\PurchaseOrderService;
use App\Services\PurchaseOrderItem\PurchaseOrderItemService;
use App\Services\Product\ProductService;
use App\Services\ProductStock\ProductStockService;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;
use Log;
use DB;

class PurchaseOrderController extends Controller
{
    protected $bankService;

    protected $purchaseOrderService;

    protected $purchaseOrderItemService;

    protected $productService;

    protected $productStockService;

    protected $customerService;

    public function __construct(BankService $bankService, CustomerService $customerService, PurchaseOrderService $purchaseOrderService, PurchaseOrderItemService $purchaseOrderItemService, ProductService $productService, ProductStockService $productStockService)
    {
        $this->bankService = $bankService;
        $this->customerService = $customerService;
        $this->purchaseOrderService = $purchaseOrderService;
        $this->purchaseOrderItemService = $purchaseOrderItemService;
        $this->productService = $productService;
        $this->productStockService = $productStockService;

        $this->middleware(['permission:purchase-orders.read'], ['only' => ['index']]);
        $this->middleware(['permission:purchase-orders.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:purchase-orders.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:purchase-orders.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['statuses'] = $this->purchaseOrderService->getStatuses();
        $data['banks'] = $this->bankService->all();
        $data['customers'] = $this->customerService->getCustomers('name', 'asc', null, 0);
        $data['purchase_orders'] = $this->purchaseOrderService->getPurchaseOrders($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.purchase-order.index', $data);
    }

    public function create()
    {
        $data['customers'] = $this->customerService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.purchase-order.create', $data);
    }

    public function store(CreatePurchaseOrderRequest $request)
    {
        DB::beginTransaction();
        try{
            $customer = $this->customerService->updateOrCreateCustomer($request->customer);

            $purchaseOrder = $this->purchaseOrderService->create(array_merge($request->except('customer', 'purchase_order_items'), [
                'status' => 'menunggu',
                'customer_id' => $customer->id,
            ]));

            $this->purchaseOrderItemService->insertPurchaseOrderItems($request->purchase_order_items, $purchaseOrder->id);

            DB::commit();
            return redirect()->route('dashboard.purchase-order.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['purchase_order'] = $this->purchaseOrderService->findById($id);
        $data['customers'] = $this->customerService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.purchase-order.edit', $data);
    }

    public function update(UpdatePurchaseOrderRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $purchaseOrder = $this->purchaseOrderService->findById($id);

            $customer = $this->customerService->updateOrCreateCustomer($request->customer);

            $this->purchaseOrderItemService->updatePurchaseOrderItems($request->purchase_order_items, $purchaseOrder->id);

            $this->purchaseOrderService->update($id, array_merge($request->except('customer', 'purchase_order_items'), [
                'customer_id' => $customer->id,
            ]));

            DB::commit();
            return redirect()->route('dashboard.purchase-order.index')->with('success', 'Berhasil mengubah data');
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
            $purchaseOrder = $this->purchaseOrderService->findById($id);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('purchase_order', null, $purchaseOrder->date, $purchaseOrder->purchaseOrderItems->toArray(), null);

            $this->purchaseOrderService->delete($id);

            DB::commit();
            return redirect()->route('dashboard.purchase-order.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
