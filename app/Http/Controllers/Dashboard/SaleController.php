<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sale\CreateSaleRequest;
use App\Http\Requests\Sale\UpdateSaleRequest;
use App\Services\Bank\BankService;
use App\Services\Sale\SaleService;
use App\Services\SaleItem\SaleItemService;
use App\Services\Product\ProductService;
use App\Services\ProductStock\ProductStockService;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;
use Log;
use DB;

class SaleController extends Controller
{
    protected $bankService;

    protected $saleService;

    protected $saleItemService;

    protected $productService;

    protected $productStockService;

    protected $customerService;

    public function __construct(BankService $bankService, CustomerService $customerService, SaleService $saleService, SaleItemService $saleItemService, ProductService $productService, ProductStockService $productStockService)
    {
        $this->bankService = $bankService;
        $this->customerService = $customerService;
        $this->saleService = $saleService;
        $this->saleItemService = $saleItemService;
        $this->productService = $productService;
        $this->productStockService = $productStockService;

        $this->middleware(['permission:sales.read'], ['only' => ['index']]);
        $this->middleware(['permission:sales.create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:sales.update'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:sales.delete'], ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['customers'] = $this->customerService->getCustomers('name', 'asc', null, 0);
        $data['sales'] = $this->saleService->getSales($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.sale.index', $data);
    }

    public function create()
    {
        $data['banks'] = $this->bankService->all();
        $data['customers'] = $this->customerService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.sale.create', $data);
    }

    public function store(CreateSaleRequest $request)
    {
        DB::beginTransaction();
        try{
            $customer = $this->customerService->updateOrCreateCustomer($request->customer);

            $request['customer_id'] = $customer->id;

            $sale = $this->saleService->create($request->except('customer', 'sale_items'));

            $this->productStockService->upsertProductStocksFromEveryProductByDate('sale', null, $request->date, null, $request->sale_items);

            $this->saleItemService->insertSaleItems($request->sale_items, $sale->id);

            DB::commit();
            return redirect()->route('dashboard.sale.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['sale'] = $this->saleService->findById($id);
        $data['banks'] = $this->bankService->all();
        $data['customers'] = $this->customerService->all();
        $data['products'] = $this->productService->getAllProductsWithLatestStock('product_code', 'asc', null, null, 0);

        return view('dashboard.sale.edit', $data);
    }

    public function update(UpdateSaleRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $sale = $this->saleService->findById($id);

            $oldSaleDate = $sale->date;

            $oldSaleItems = $sale->saleItems->toArray();

            $customer = $this->customerService->updateOrCreateCustomer($request->customer);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('sale', $oldSaleDate, $request->date, $oldSaleItems, $request->sale_items);

            $this->saleItemService->updateSaleItems($request->sale_items, $sale->id);

            $request['customer_id'] = $customer->id;

            $this->saleService->update($id, $request->except('customer', 'sale_items'));

            DB::commit();
            return redirect()->route('dashboard.sale.index')->with('success', 'Berhasil mengubah data');
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
            $sale = $this->saleService->findById($id);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('sale', null, $sale->date, $sale->saleItems->toArray(), null);

            $this->saleService->delete($id);

            DB::commit();
            return redirect()->route('dashboard.sale.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
