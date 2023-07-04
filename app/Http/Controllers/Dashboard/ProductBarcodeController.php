<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;

class ProductBarcodeController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;

        $this->middleware(['permission:products.read']);
    }

    public function __invoke($id)
    {
        return $this->show($id);
    }

    public function show($id)
    {
        $data['product'] = $this->productService->findOrFail($id);

        return view('dashboard.product.barcode', $data);
    }
}
