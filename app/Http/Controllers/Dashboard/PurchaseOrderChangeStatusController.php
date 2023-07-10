<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\PurchaseOrder\PurchaseOrderService;
use App\Services\Sale\SaleService;
use App\Services\SaleItem\SaleItemService;
use DB;
use Illuminate\Http\Request;
use Log;

class PurchaseOrderChangeStatusController extends Controller
{
    protected $purchaseOrderService;

    protected $saleService;

    protected $saleItemService;

    public function __construct(PurchaseOrderService $purchaseOrderService, SaleService $saleService, SaleItemService $saleItemService)
    {
        $this->purchaseOrderService = $purchaseOrderService;
        $this->saleService = $saleService;
        $this->saleItemService = $saleItemService;

        $this->middleware('permission:purchase-orders.change-status');

    }

    public function __invoke(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try{
            $this->purchaseOrderService->changeStatus($id, $request->status);

            if ($request->status == 'selesai') {
                $purchaseOrder = $this->purchaseOrderService->findById($id);

                $sale = $this->saleService->createFromPurchaseOrder($purchaseOrder, $request->payment);

                $purchaseOrderItems = $purchaseOrder->purchaseOrderItems->map(function ($item) {
                    return collect($item)->except(['id', 'purchase_order_id', 'created_at', 'updated_at', 'product']);
                })->toArray();

                $this->saleItemService->insertSaleItems($purchaseOrderItems, $sale->id);
            }

            DB::commit();

            return redirect()->route('dashboard.purchase-order.index')->with('success', 'Status pemesanan berhasil diubah');
        }catch (\Exception $e) {
            DB::rollback();
            Log::error($e);

            return abort(500);
        }

    }
}
