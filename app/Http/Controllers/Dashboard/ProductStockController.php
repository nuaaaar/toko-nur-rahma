<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\ProductStock\ProductStockService;
use App\Traits\DateTrait;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    use DateTrait;

    protected $categoryService;

    protected $productStockService;

    public function __construct(CategoryService $categoryService, ProductStockService $productStockService)
    {
        $this->categoryService = $categoryService;

        $this->productStockService = $productStockService;
    }

    public function index(Request $request)
    {
        $request['date_from'] = $request->date_from ?? date('Y-m-d', strtotime('-7 days'));
        $request['date_to'] = $request->date_to ?? date('Y-m-d');
        $request['orderBy'] = $request->orderBy ?? 'name';
        $request['orderType'] = $request->orderType ?? 'asc';

        $data['dates'] = $this->getDates($request->date_from, $request->date_to);
        $data['products'] = $this->productStockService->getProductStocksBetweenDates($request->product_ids ?? [], $request->date_from, $request->date_to, $request->orderBy, $request->orderType, $request->filters ?? [], $request->search);
        $data['categories'] = $this->categoryService->all();

        return view('dashboard.product-stock.index', $data);
    }
}
