<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StockOpname\CreateStockOpnameRequest;
use App\Http\Requests\StockOpname\UpdateStockOpnameRequest;
use App\Services\ProductStock\ProductStockService;
use App\Services\StockOpname\StockOpnameService;
use App\Services\StockOpnameItem\StockOpnameItemService;
use DB;
use Illuminate\Http\Request;
use Log;

class StockOpnameController extends Controller
{
    protected $productStockService;

    protected $stockOpnameService;

    protected $stockOpnameItemService;

    public function __construct(ProductStockService $productStockService, StockOpnameService $stockOpnameService, StockOpnameItemService $stockOpnameItemService)
    {
        $this->productStockService = $productStockService;
        $this->stockOpnameService = $stockOpnameService;
        $this->stockOpnameItemService = $stockOpnameItemService;
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'date';
        $request['orderType'] = $request->orderType ?? 'desc';

        $data['stock_opnames'] = $this->stockOpnameService->getStockOpnames($request->orderBy, $request->orderType, $request->filters, $request->search, 10);

        return view('dashboard.stock-opname.index', $data);
    }

    public function create(Request $request)
    {
        $request['date_from'] = $request->date_from ?? date('Y-m-d', strtotime('-7 days'));
        $request['date_to'] = $request->date_to ?? date('Y-m-d');

        $data['products'] = $this->productStockService->getProductStocksBetweenDates([], $request->date_from, $request->date_to, 'product_code', 'asc', [], null);

        return view('dashboard.stock-opname.create', $data);
    }

    public function store(CreateStockOpnameRequest $request)
    {
        DB::beginTransaction();
        try{
            $stockOpname = $this->stockOpnameService->create($request->all());

            $this->stockOpnameItemService->insertStockOpnameItems($request->stock_opname_items, $stockOpname->id);

            DB::commit();
            return redirect()->route('dashboard.stock-opname.index')->with('success', 'Berhasil menambah data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }

    public function edit($id)
    {
        $data['stock_opname'] = $this->stockOpnameService->findById($id);

        if(!$data['stock_opname']) return abort(404);

        $data['products'] = $this->productStockService->getProductStocksBetweenDates([], $data['stock_opname']->date_from, $data['stock_opname']->date_to, 'product_code', 'asc', [], null);

        return view('dashboard.stock-opname.edit', $data);
    }

    public function update(UpdateStockOpnameRequest $request, $id)
    {
        DB::beginTransaction();
        try{
            $stockOpname = $this->stockOpnameService->findById($id);

            $this->stockOpnameService->update($stockOpname->id, $request->all());

            $this->stockOpnameItemService->updateStockOpnameItems($request->stock_opname_items, $stockOpname->id);

            DB::commit();
            return redirect()->route('dashboard.stock-opname.index')->with('success', 'Berhasil mengubah data');
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
            $stockOpname = $this->stockOpnameService->findById($id);

            $this->stockOpnameService->delete($stockOpname->id);

            DB::commit();
            return redirect()->route('dashboard.stock-opname.index')->with('success', 'Berhasil menghapus data');
        }catch(\Exception $e){
            DB::rollBack();
            Log::error($e);

            return abort(500);
        }
    }
}
