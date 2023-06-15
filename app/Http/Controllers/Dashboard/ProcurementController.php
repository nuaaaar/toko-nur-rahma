<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\CreateProcurementRequest;
use App\Http\Requests\Procurement\UpdateProcurementRequest;
use App\Services\Procurement\ProcurementService;
use App\Services\ProcurementItem\ProcurementItemService;
use App\Services\Product\ProductService;
use App\Services\ProductStock\ProductStockService;
use App\Services\Supplier\SupplierService;
use Illuminate\Http\Request;
use Log;
use DB;

class ProcurementController extends Controller
{
    protected $procurementService;

    protected $procurementItemService;

    protected $productService;

    protected $productStockService;

    protected $supplierService;

    public function __construct(ProcurementService $procurementService, ProcurementItemService $procurementItemService, ProductService $productService, ProductStockService $productStockService, SupplierService $supplierService)
    {
        $this->procurementService = $procurementService;
        $this->procurementItemService = $procurementItemService;
        $this->productService = $productService;
        $this->productStockService = $productStockService;
        $this->supplierService = $supplierService;

        $this->middleware(['permission:procurements.read'], ['only' => ['index']]);
        $this->middleware(['permission:procurements.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:procurements.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:procurements.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['suppliers'] = $this->supplierService->getSuppliers('name', 'asc', null, 0);
        $data['procurements'] = $this->procurementService->getProcurementsWithSupplierAndItems($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.procurement.index', $data);
    }

    public function create()
    {
        $data['suppliers'] = $this->supplierService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.procurement.create', $data);
    }

    public function store(CreateProcurementRequest $request)
    {
        DB::beginTransaction();
        try{
            $procurement = $this->procurementService->create($request->all());

            $this->productStockService->upsertProductStocksFromEveryProductByDate('procurement', null, $request->date, null, $request->procurement_items);

            $this->procurementItemService->insertProcurementItems($request->procurement_items, $procurement->id);

            DB::commit();
            return redirect()->route('dashboard.procurement.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['procurement'] = $this->procurementService->findById($id);
        $data['suppliers'] = $this->supplierService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.procurement.edit', $data);
    }

    public function update(UpdateProcurementRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $procurement = $this->procurementService->findById($id);

            $oldProcurementDate = $procurement->date;

            $oldProcurementItems = $procurement->procurementItems->toArray();

            $this->productStockService->upsertProductStocksFromEveryProductByDate('procurement', $oldProcurementDate, $request->date, $oldProcurementItems, $request->procurement_items);

            $this->procurementItemService->updateProcurementItems($request->procurement_items, $procurement->id);

            $this->procurementService->update($id, $request->all());

            DB::commit();
            return redirect()->route('dashboard.procurement.index')->with('success', 'Berhasil mengubah data');
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
            $procurement = $this->procurementService->findById($id);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('procurement', null, $procurement->date, $procurement->procurementItems->toArray(), null);

            $this->procurementService->delete($id);

            DB::commit();
            return redirect()->route('dashboard.procurement.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
