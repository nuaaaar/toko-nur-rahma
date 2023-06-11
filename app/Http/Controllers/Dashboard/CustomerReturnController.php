<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerReturn\CreateCustomerReturnRequest;
use App\Http\Requests\CustomerReturn\UpdateCustomerReturnRequest;
use App\Services\Customer\CustomerService;
use App\Services\CustomerReturn\CustomerReturnService;
use App\Services\CustomerReturnItem\CustomerReturnItemService;
use App\Services\Product\ProductService;
use App\Services\ProductStock\ProductStockService;
use App\Services\Sale\SaleService;
use DB;
use Illuminate\Http\Request;
use Log;

class CustomerReturnController extends Controller
{
    protected $customerService;

    protected $customerReturnService;

    protected $customerReturnItemService;

    protected $productService;

    protected $productStockService;

    protected $saleService;

    public function __construct(CustomerService $customerService, CustomerReturnService $customerReturnService, CustomerReturnItemService $customerReturnItemService, ProductService $productService, ProductStockService $productStockService, SaleService $saleService)
    {
        $this->customerService = $customerService;
        $this->customerReturnService = $customerReturnService;
        $this->customerReturnItemService = $customerReturnItemService;
        $this->productService = $productService;
        $this->productStockService = $productStockService;
        $this->saleService = $saleService;

        $this->middleware('permission:customer-returns.read')->only(['index', 'show']);
        $this->middleware('permission:customer-returns.create')->only(['create', 'store']);
        $this->middleware('permission:customer-returns.update')->only(['edit', 'update']);
        $this->middleware('permission:customer-returns.delete')->only('destroy');
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['customers'] = $this->customerService->getCustomers('name', 'asc', null, 0);
        $data['customer_returns'] = $this->customerReturnService->getCustomerReturns($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.customer-return.index', $data);
    }

    public function create(Request $request)
    {
        $data['sale'] = $this->saleService->findByInvoiceNumber($request->invoice_number ?? '');

        if(!$data['sale']) return redirect()->route('dashboard.customer-return.index')->with('error', 'Data penjualan tidak ditemukan');

        $data['categories'] = $this->customerReturnService->getCategories();

        return view('dashboard.customer-return.create', $data);
    }

    public function store(CreateCustomerReturnRequest $request)
    {
        DB::beginTransaction();
        try{
            $customerReturn = $this->customerReturnService->create($request->all());

            $this->productStockService->upsertProductStocksFromEveryProductByDate('return', null, $request->date, null, $request->customer_return_items);

            if($customerReturn->category == 'ganti barang') $this->productStockService->upsertProductStocksFromEveryProductByDate('change', null, $request->date, null, $request->customer_return_items);

            $this->customerReturnItemService->insertCustomerReturnItems($request->customer_return_items, $customerReturn->id);

            DB::commit();
            return redirect()->route('dashboard.customer-return.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['customer_return'] = $this->customerReturnService->findById($id);

        if(!$data['customer_return']) return abort(404);

        $data['sale'] = $this->saleService->findByInvoiceNumber($data['customer_return']->sale->invoice_number ?? '');
        $data['categories'] = $this->customerReturnService->getCategories();

        return view('dashboard.customer-return.edit', $data);
    }

    public function update(UpdateCustomerReturnRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $customerReturn = $this->customerReturnService->findById($id);

            $oldCustomerReturnCategory = $customerReturn->category;

            $oldCustomerReturnDate = $customerReturn->date;

            $oldCustomerReturnItems = $customerReturn->customerReturnItems->toArray();

            $this->productStockService->upsertProductStocksFromEveryProductByDate('return', $oldCustomerReturnDate, $request->date, $oldCustomerReturnItems, $request->customer_return_items);

            if($oldCustomerReturnCategory == 'ganti barang' && $request->category == 'ganti barang') $this->productStockService->upsertProductStocksFromEveryProductByDate('change', $oldCustomerReturnDate, $request->date, $oldCustomerReturnItems, $request->customer_return_items);

            if($oldCustomerReturnCategory == 'refund pembayaran' && $request->category == 'ganti barang') $this->productStockService->upsertProductStocksFromEveryProductByDate('change', null, $request->date, null, $request->customer_return_items);

            if($oldCustomerReturnCategory == 'ganti barang' && $request->category == 'refund pembayaran') $this->productStockService->upsertProductStocksFromEveryProductByDate('change', null, $oldCustomerReturnDate, $oldCustomerReturnItems, null);

            $this->customerReturnService->update($id, $request->all());

            DB::commit();
            return redirect()->route('dashboard.customer-return.index')->with('success', 'Berhasil mengubah data');
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
            $customerReturn = $this->customerReturnService->findById($id);

            $this->productStockService->upsertProductStocksFromEveryProductByDate('return', null, $customerReturn->date, $customerReturn->customerReturnItems->toArray(), null);

            if($customerReturn->category == 'ganti barang') {
                $this->productStockService->upsertProductStocksFromEveryProductByDate('change', null, $customerReturn->date, $customerReturn->customerReturnItems->toArray(), null);
            }

            $this->customerReturnService->delete($id);

            DB::commit();
            return redirect()->route('dashboard.customer-return.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
