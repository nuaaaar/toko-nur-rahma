<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Category\CategoryService;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductEmptyStockController extends Controller
{
    protected $categoryService;

    protected $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;

        $this->middleware(['permission:product-empty-stock.read'])->only(['index']);
    }

    public function index(Request $request)
    {
        $request['orderBy'] = $request->orderBy ?? 'product_code';
        $request['orderType'] = $request->orderType ?? 'asc';

        $data['categories'] = $this->categoryService->all();
        $data['products'] = $this->productService->getEmptyStockProducts($request->orderBy, $request->orderType, $request->filters, $request->search);

        return view('dashboard.product-empty-stock.index', $data);
    }
}
